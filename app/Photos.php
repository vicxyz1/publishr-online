<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\phpFlickr;

class Photos extends Model
{

    private $_flickr;
    private $_privacy = 5; //public 1, friends, family, family&friends, private
    private $token = null;
    //FIXME: nasty, create setters


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



}
