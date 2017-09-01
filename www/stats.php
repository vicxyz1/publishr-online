<?php
/**
 *   Publishr-Online
 *
 *   @author     Costache Vicentiu <vicxyz@gmail.com>
 *   @copyright (c) 2016-2017. All rights reserved.
 *
 *   For the full copyright and license information, please view the LICENSE* file that was distributed with this source code.
 */


require 'config.inc.php';
require_once BASE_LOCATION . '/bootstrap.php';
require_once BASE_LOCATION . '/model/Photos.php';


if (!isset($_SESSION['phpFlickr_auth_token'])) {

    $tpl->tpl = 'index.tpl.php';
    $tpl->display('layout_nologin.tpl.php');
    die();
}
$template = 'stats';
$tpl_param['menu'] = 'home';

$Photos = new Photos($f);
$Photos->db = $db;
$Photos->setToken($_SESSION['phpFlickr_auth_token']['_content']);

$photos = $Photos->getMostViewed();

$tpl_param['photos'] = $photos;

$tpl_param['total_views'] = $Photos->total_views;




$tpl->tpl = $template . '.tpl.php';
$tpl->assign($tpl_param);
$tpl->display('layout.tpl.php');
/*EOF*/