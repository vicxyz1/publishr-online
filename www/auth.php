<?php
/**
 *   Publishr-Online
 *
 *   @author     Costache Vicentiu <vicxyz@gmail.com>
 *   @copyright (c) 2016-2017. All rights reserved.
 *
 *   For the full copyright and license information, please view the LICENSE* file that was distributed with this source code.
 */
require_once 'config.inc.php';
require_once BASE_LOCATION . '/bootstrap.php';

$api_key                 = API_KEY;
$api_secret              = API_SECRET;
$default_redirect        = API_REDIRECT;
$permissions             = "write";

ob_start();
    
unset($_SESSION['phpFlickr_auth_token']);
 
if ( isset($_SESSION['phpFlickr_auth_redirect']) && !empty($_SESSION['phpFlickr_auth_redirect']) ) {
	$redirect = $_SESSION['phpFlickr_auth_redirect'];
	unset($_SESSION['phpFlickr_auth_redirect']);
}



if (empty($_GET['frob'])) {
	$f->auth($permissions, false);
} else {
	$auth = $f->auth_getToken($_GET['frob']);
	$token = $_SESSION['phpFlickr_auth_token'];
//	$User = new User($db);
//        
//        $User->add($auth['user']);
//        var_dump($auth);
//        //add in db
//        die();
}

if (empty($redirect)) {
	header("Location: " . $default_redirect);
} else {
	header("Location: " . $redirect);
}


