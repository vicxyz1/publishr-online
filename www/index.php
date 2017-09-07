<?php

require 'config.inc.php';
require_once BASE_LOCATION . '/bootstrap.php';
require_once BASE_LOCATION . '/model/Photos.php';

$callback = SITE_URL . 'auth.php';

//unset($_SESSION['phpFlickr_auth_token']);

if (isset($_GET['logout'])) {
    unset($_SESSION['phpFlickr_oauth_token']);
    unset($_SESSION['phpFlickr_oauth_secret_token']);
}

//TODO: remove
if (isset($_GET['login'])) {
    $f->getRequestToken($callback);
    $_SESSION['redirect'] = 'index.php';
    die();
}

logEval($_POST, 'post');
$tpl_param = array();

$tpl_param['menu'] = 'home';

if (!isset($_SESSION['phpFlickr_oauth_token'])) {

    $tpl->tpl = 'index.tpl.php';
    $tpl->display('layout_nologin.tpl.php');
    die();
}

//logged:

$token = array(
   'token' => $_SESSION['phpFlickr_oauth_token'],
   'secret'=> $_SESSION['phpFlickr_oauth_secret_token'],
);


//get all private
//$photos = $this->_flickr->photos_search($search_param);

//$f->setOauthToken($token['token'], $token['secret']);
//$search_param = array(
//    'user_id' => 'me',
//    'per_page' => 300,
//    'extras' => 'url_t, url_q, views,url_o, url_z',
//    'privacy_filter' => 5
//);
//
//$p = $f->photos_search($search_param);
////print_r($f->getErrorMsg());

//var_dump($p);
$action = 'none';
$template = 'home';


$Photos = new Photos($f);
$Photos->db = $db;
$Photos->setToken($token );

 $tags = array();

$groups = $f->groups_pools_getGroups();

$groups = (isset($groups['group']))?$groups['group']:[];



$tpl_param['groups'] = $groups;

logEval($groups, 'groups');

if (isset($_POST['action'])) {

    $action = $_POST['action'];



    $photos = isset($_POST['photos']) ? $_POST['photos'] : array();




    if ($action == 'publish'):
        if (!count($photos)) {
            $tpl_param['err1_msg'] = 'No photo selected.';
        }
        $datetime = $_POST['pub_time'];
        
        $pub_time = date('Y-m-d H:i:s', strtotime($datetime)+ 60*$_POST['tz']);
        
        //$pub_time = DateTime::createFromFormat('Y-m-d H:i T', $datetime, new DateTimeZone(SITE_TIMEZONE));
    //    $pub_time = date('Y-m-d H:i:s', $pub_time);    
        logEval($pub_time, 'pub time');
        
        
        //everything ok 
        if (!isset($tpl_param['err_msg'])) {
            $Photos->schedule($photos,  strtotime($pub_time) , $_POST['groups'], $tags);
        }

    endif;

    if ($action == 'unpublish'):
        if (!count($photos)) {
            $tpl_param['err2_msg'] = 'No photo selected.';
        }

        $Photos->unpublish($photos);

    endif;
}


$spage = isset($_GET['spage']) ? $_GET['spage'] : 1;
$upage = isset($_GET['upage']) ? $_GET['upage'] : 1;


$unpublished = $Photos->getUnpublished($upage);
if (empty($unpublished)) {
    $tpl_param['err1_msg'] = 'No private photos to display.';
}
$tpl_param['upages'] = $Photos->pages;

$scheduled = $Photos->getScheduled($spage);
if (empty($scheduled)) {
    $tpl_param['err2_msg'] = 'No scheduled photos to display.';
}
$tpl_param['spages'] = $Photos->pages;


$tpl_param['action'] = $action;
$tpl_param['unpublished'] = $unpublished;
$tpl_param['scheduled'] = $scheduled;



$tpl->tpl = $template . '.tpl.php';
$tpl->assign($tpl_param);
$tpl->display('layout.tpl.php');
/*EOF*/
