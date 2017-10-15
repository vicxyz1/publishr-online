<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\phpFlickr;

class Photos extends Model
{

    private $_flickr;
    private $_privacy = 5; //public 1, friends, family, family&friends, private
    private $token = null;
    private $_photos = null;
    //FIXME: nasty, create setters
    public $pages = null;
    public $per_page = 30; //PHOTOS_PER_PAGE;
    public $total_views = 0;





    public function __construct(array $attributes = [])
    {
        $api_key = env('API_KEY');
        $api_secret = env('API_SECRET');
        $this->_flickr =  new phpFlickr($api_key, $api_secret);

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
     *
     * @param type $privacy
     */
    public function setPrivacy($privacy)
    {

        $this->_privacy = $privacy;
    }


    public function getGroups() {

        //!TODO: check if token was set
        return $this->_flickr->groups_pools_getGroups();
    }

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
    public function getUnpublished($page) {

        if (!$this->getPhotos()) {
            return array();
        }
        $all_photos = array_keys($this->_photos);

        $this->pages = 0;
        //check if already scheduled

//        logEval($this->token,'token before get col');

        $scheduled = $this->pluck('flickr_photo_id')->where('auth_token', $this->token['token']);

        $scheduled = $scheduled->toArray();

//        logEval($scheduled, 'scheduled from unpublished');

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
    function getScheduled($page)
    {
        if (!$this->getPhotos()) {
            return array();
        }


        $total_scheduled =$this->where('auth_token', $this->token['token'])->count();
            //$this->db->getOne('SELECT COUNT(photo_id) FROM photos WHERE auth_token=? ', array($this->token['token']));

        $this->pages = ceil($total_scheduled / $this->per_page);

//        logEval($total_scheduled, 'total scheduled');
        //!FIXME:
        $scheduled = [];
            //$this->db->getAssoc('SELECT flickr_photo_id, publish_time FROM photos WHERE auth_token=? ORDER BY publish_time LIMIT ? OFFSET ?', array($this->token['token'], $this->per_page, ($page - 1) * $this->per_page));

//        logEval($scheduled, 'scheduled from db ');

        $photos = $this->_photos;


        $photo_scheduled = array();

        if (!empty($scheduled)) {
            foreach ($scheduled as $id => $datetime) {

                $date = date('Y-m-d', $datetime);
                if (!isset($this->_photos[$id])) {
                    $this->unpublish($id);
                    continue;
                }
                $photo_scheduled [$date][] = $this->_photos[$id];
            }
        }

        return $photo_scheduled;
    }



}
