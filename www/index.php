<?php

require 'config.inc.php';
require_once BASE_LOCATION . '/bootstrap.php';
require_once BASE_LOCATION . '/model/Photos.php';

//unset($_SESSION['phpFlickr_auth_token']);

if (isset($_GET['logout'])) {
    unset($_SESSION['phpFlickr_auth_token']);
}

logEval($_POST, 'post');
$tpl_param = array();

$tpl_param['menu'] = 'home';

if (!isset($_SESSION['phpFlickr_auth_token'])) {

    $tpl->tpl = 'index.tpl.php';
    $tpl->display('layout_nologin.tpl.php');
    die();
}

$action = 'none';
$template = 'home';


$Photos = new Photos($f);
$Photos->db = $db;
$Photos->setToken($_SESSION['phpFlickr_auth_token']['_content']);

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
