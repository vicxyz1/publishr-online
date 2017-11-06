<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\phpFlickr;

use Illuminate\Support\Facades\Log;

//!FIXME: Rename to Photo
class Photos extends Model
{

    private $_flickr;
    private $_privacy = 5; //public 1, friends, family, family&friends, private
    private $token = null;
    private $_photos = null;
    //FIXME: nasty, create setters
    public $pages = null;
    public $per_page = 5; //PHOTOS_PER_PAGE;
    public $total_views = 0;

    protected $fillable = ['flickr_photo_id', 'publish_time', 'auth_token', 'auth_secret', 'flickr_groups'];

    public function __construct(array $attributes = [])
    {
        $api_key = env('API_KEY');
        $api_secret = env('API_SECRET');
        $this->_flickr = new phpFlickr($api_key, $api_secret);

        //auto populate with oauth tokens
        if (session()->has('phpFlickr_oauth_token')) {

            $token = array(
                'token' => session('phpFlickr_oauth_token'),
                'secret' => session('phpFlickr_oauth_secret_token'),
            );

            $this->setToken($token);
        }
        parent::__construct($attributes);
    }

    /**
     *
     * @param array $token
     */
    function setToken($token)
    {
        $this->token = $token;
        $this->_flickr->setOauthToken($token['token'], $token['secret']);
    }

    /**
     * set privacy
     * @param type $privacy
     */
    public function setPrivacy($privacy)
    {

        $this->_privacy = $privacy;
    }

    /**
     * Get user groups
     * @return bool
     */
    public function getGroups()
    {
        if (is_null($this->token)) {

            return false;
        }

        return $this->_flickr->groups_pools_getGroups();
    }

    /**
     * Return unpublished photos
     * @param null $privacy
     * @return bool
     */
    public function getPhotos($privacy = null)
    {

        if (!is_null($this->_photos))
            return true;


        //max 30

        $search_param = array(
            'user_id' => 'me',
            'per_page' => 300,
            'extras' => 'url_t, url_q, views,url_o, url_z',
            'privacy_filter' => (is_null($privacy) || $privacy > 5 || $privacy < 1) ? $this->_privacy : $privacy
        );

        //get all private
        $photos = $this->_flickr->photos_search($search_param);


        if (!$photos) {
//            logMessage($this->_flickr->getErrorMsg());
            return false;
        }

        $photos = $photos['photo'];
//        logEval($photos, 'photos');


        $this->_photos = array();
        foreach ($photos as $photo) {
            $this->_photos[$photo['id']] = $photo;
            $this->total_views += $photo['views'];
        }
        return true;
    }

    /**
     * @param $page
     * @return array
     */
    public function getUnpublished($page)
    {

        if (!$this->getPhotos()) {
            return array();
        }
        $all_photos = array_keys($this->_photos);

        $this->pages = 0;
        //check if already scheduled

//        logEval($this->token,'token before get col');

        $scheduled = $this->where('auth_token', $this->token['token'])->pluck('flickr_photo_id');

        $scheduled = $scheduled->toArray();

        Log::debug('scheduled from unpublished',    $scheduled);

        //dirty cast
        foreach ($all_photos as $i => $id)
            $all_photos[$i] = (string)$id;

//        logEval($all_photos, 'all photos');
//        logEval($scheduled, 'scheduled');
        $unscheduled = array_diff($all_photos, $scheduled);


//        logEval($unscheduled, 'unscheduled');

        $photos = array();
        //var_dump($scheduled);
        if (!empty($unscheduled)) {

            $this->pages = ceil(count($unscheduled) / $this->per_page);
            $unscheduled = array_slice($unscheduled, ($page - 1) * $this->per_page, $this->per_page);

            foreach ($unscheduled as $id) {
                $photos[$id] = $this->_photos[$id];
            }
        }
//        logEval($photos, 'unscheduled photos');

        return $photos;
    }

    /**
     * @param $page
     * @return array
     */
    public function getScheduled($page)
    {
        if (!$this->getPhotos()) {
            return array();
        }


        $total_scheduled = $this->where('auth_token', $this->token['token'])->count();

        $this->pages = ceil($total_scheduled / $this->per_page);

//        logEval($total_scheduled, 'total scheduled');
        //!FIXME:
        $scheduled = Photos::where('auth_token', $this->token['token'])->paginate($this->per_page);


        //$this->db->getAssoc('SELECT flickr_photo_id, publish_time FROM photos WHERE auth_token=? ORDER BY publish_time LIMIT ? OFFSET ?', array($this->token['token'], $this->per_page, ($page - 1) * $this->per_page));

//        logEval($scheduled, 'scheduled from db ');

        $photos = $this->_photos;

//        dd($scheduled);
        $photo_scheduled = array();

        if ($scheduled->count()) {
            foreach ($scheduled->items() as $photo) {
                $date = date('Y-m-d', $photo->publish_time);
                if (!isset($this->_photos[$photo->flickr_photo_id])) {
                    $this->unpublish($photo->flickr_photo_id);
                    continue;
                }
                $photo_scheduled [$date][] = $this->_photos[$photo->flickr_photo_id];
            }
        }

//        dd($photo_scheduled);

        return $photo_scheduled;
    }

    /**
     * Schedule photos
     * array $photos
     * @param $datetime
     * @param $groups
     * @param $tags
     * @return bool
     */
    public function schedule($photos, $datetime, $groups, $tags = [])
    {

        //TODO: check datetime>now

        if (!is_array($groups)) $groups = array($groups);

        foreach ($photos as $id) {
            $photo = array(
                'flickr_photo_id' => $id,
                'publish_time' => $datetime,
                'auth_token' => $this->token['token'],
                'auth_secret' => $this->token['secret'],
                'flickr_groups' => implode(',', $groups)
            );

            Photos::create($photo);


        }

        return true;
    }

    /**
     * Unpublish photos (del from db)
     * @param $photos
     */
    public function unpublish($photos)
    {

        if (!is_array($photos))
            $photos = array($photos);



        foreach ($photos as $id) {
            Photos::where('flickr_photo_id', $id)
                ->where('auth_token', $this->token['token'])
                ->delete();
        }
    }

    /**
     * Make the photo public
     * @param $photo
     */
    function publish($photo)
    {
        Log::info($photo->photo_id . ' to publish');



        if (!$this->_flickr->photos_setPerms($photo->flickr_photo_id, 1, 0, 0, 3, 0)) {
            Log::warning($this->_flickr->geterrorMsg());
        }


        //modify posted date
        $this->_flickr->photos_setDates($photo->flickr_photo_id, time());
        $this->unpublish($photo->flickr_photo_id);

        //add to groups
        if (!empty($photo->flickr_groups)) {

            $groups = explode(',', $photo->flickr_groups);
            foreach ($groups as $group_id) {
                if (!$this->_flickr->groups_pools_add($photo->flickr_photo_id, $group_id)) {
                    Log::warning($this->_flickr->geterrorMsg());
                }
            }
        }

        if (!$this->_flickr->photos_addTags($photo->flickr_photo_id, 'publishr.online')) {
            Log::warning($this->_flickr->geterrorMsg());
        }


    }



}
