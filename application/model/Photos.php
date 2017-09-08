<?php

/**
 *   Publishr-Online
 *
 * @author     Costache Vicentiu <vicxyz@gmail.com>
 * @copyright (c) 2016-2017. All rights reserved.
 *
 *   For the full copyright and license information, please view the LICENSE* file that was distributed with this source code.
 */

/**
 * Description of Photos
 *
 * @author vic
 */
class Photos
{

    //put your code here
    private $_flickr;
    private $_privacy = 5; //public 1, friends, family, family&friends, private
    private $token;
    //FIXME: nasty, create setters
    public $db;

    public $pages = null;
    public $per_page = PHOTOS_PER_PAGE;
    private $_photos = null;
    public $total_views = 0;

    function __construct($flickr)
    {

        $this->_flickr = $flickr;
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

    /**
     *  Get all private photos.
     * @param type $page
     * @return boolean
     */
    public function getPhotos($privacy = null)
    {

        if (!is_null($this->_photos))
            return false;


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
            logMessage($this->_flickr->getErrorMsg());
            return false;
        }

        $photos = $photos['photo'];
        logEval($photos, 'photos');


        $this->_photos = array();
        foreach ($photos as $photo) {
            $this->_photos[$photo['id']] = $photo;
            $this->total_views += $photo['views'];
        }
        return true;
    }

    /**
     *
     * @param type $page
     * @return type
     */
    function getUnpublished($page)
    {

        if (!$this->getPhotos()) {
            return array();
        }
        $all_photos = array_keys($this->_photos);

        $this->pages = 0;
        //check if already scheduled

        $scheduled = $this->db->getCol('SELECT flickr_photo_id FROM photos WHERE auth_token=? ', array("{$this->token['token']}:{$this->token['secret']}"), true);

        logEval($scheduled, 'scheduled from unpublished');

        //dirty cast
        foreach ($all_photos as $i => $id)
            $all_photos[$i] = (string)$id;

//        logEval($all_photos, 'all photos');
        logEval($scheduled, 'scheduled');
        $unscheduled = array_diff($all_photos, $scheduled);


        logEval($unscheduled, 'unscheduled');

        $photos = array();
        //var_dump($scheduled);
        if (!empty($unscheduled)) {

            $this->pages = ceil(count($unscheduled) / $this->per_page);
            $unscheduled = array_slice($unscheduled, ($page - 1) * $this->per_page, $this->per_page);

            foreach ($unscheduled as $id) {
                $photos[$id] = $this->_photos[$id];
            }
        }
        logEval($photos, 'unscheduled photos');

        return $photos;
    }

    function getScheduled($page)
    {
        if (!$this->getPhotos()) {
            return array();
        }


        $total_scheduled = $this->db->getOne('SELECT COUNT(photo_id) FROM photos WHERE auth_token=? ', array("{$this->token['token']}:{$this->token['secret']}"));
        $this->pages = ceil($total_scheduled / $this->per_page);

        logEval($total_scheduled, 'total scheduled');

        $scheduled = $this->db->getAssoc('SELECT flickr_photo_id, publish_time FROM photos WHERE auth_token=? ORDER BY publish_time LIMIT ? OFFSET ?', array("{$this->token['token']}:{$this->token['secret']}", $this->per_page, ($page - 1) * $this->per_page));


        $photos = $this->_photos;


        $photo_scheduled = array();
        //var_dump($scheduled);
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
//          var_dump($photo_scheduled);                

        return $photo_scheduled;
    }

    function schedule($photos, $datetime, $groups, $tags)
    {

        //var_dump($photos);
        //TODO: check datetime>now

        if (!is_array($groups)) $groups = array($groups);

        foreach ($photos as $id) {
            $photo = array(
                'flickr_photo_id' => $id,
                'publish_time' => $datetime,
                'auth_token' => "{$this->token['token']}:{$this->token['secret']}",
                'flickr_groups' => implode(',', $groups)
            );

            logEval($photo, 'photo param');
            try {
                $this->db->autoExecute('photos', $photo, 'INSERT');
            } catch (Exception $e) {
                echo $this->db->errorMsg();
                return FALSE;
            }
        }
    }

    function unpublish($photos)
    {

        if (!is_array($photos))
            $photos = array($photos);

        foreach ($photos as $id) {
            $this->db->query('DELETE FROM photos WHERE flickr_photo_id=? AND auth_token=?', array($id, "{$this->token['token']}:{$this->token['secret']}"));
        }
    }

    function publish($photo)
    {
//        print_r($photo);

        if (!$this->_flickr->photos_setPerms($photo['flickr_photo_id'], 1, 0, 0, 3, 0)) {
            logMessage($this->_flickr->geterrorMsg(), \Monolog\Logger::WARNING);
        }
        //modify posted date
        $this->_flickr->photos_setDates($photo['flickr_photo_id'], time());
        $this->unpublish($photo['flickr_photo_id']);

        //add to groups
        if (!empty($photo['flickr_groups'])) {

            $groups = explode(',', $photo['flickr_groups']);
            foreach ($groups as $group_id) {
                if (!$this->_flickr->groups_pools_add($photo['flickr_photo_id'], $group_id)) {
                    logMessage($this->_flickr->geterrorMsg(), \Monolog\Logger::WARNING);
                }
            }
        }

        if (!$this->_flickr->photos_addTags($photo['flickr_photo_id'], 'publishr.online')) {
            logMessage($this->_flickr->geterrorMsg(), \Monolog\Logger::WARNING);
        }


    }

    public function getMostViewed($count = 10)
    {
        //get public & reset photos
        $this->_photos = null;
        logMessage('getMostViewed');
        $this->getPhotos(1);
        $views_photos = $this->_photos;


        uasort($views_photos, 'compare_views');

        logEval($views_photos, 'viewed photos');

        return array_slice($views_photos, 0, $count);
    }

    public function getPhoto($id)
    {

        $this->getPhotos();

        return isset($this->_photos[$id]) ? $this->_photos[$id] : false;
    }

}

function compare_views($p1, $p2)
{
    if ($p1['views'] == $p2['views'])
        return 0;
    return ($p1['views'] > $p2['views']) ? -1 : 1;
}
