<?php

/**
 *   Publishr-Online
 *
 *   @author     Costache Vicentiu <vicxyz@gmail.com>
 *   @copyright (c) 2016-2017. All rights reserved.
 *
 *   For the full copyright and license information, please view the LICENSE* file that was distributed with this source code.
 */

define('API_DEBUG', false);
define('BASE_LOCATION', dirname(substr(__FILE__, 0, strrpos(__FILE__, '/') + 1)));
define('LOG_NAME', 'cron_publish');

require_once BASE_LOCATION . '/../www/config.inc.php';



require_once BASE_LOCATION . '/bootstrap.php';
require_once BASE_LOCATION . '/model/Photos.php';
//make public everything scheduled now>publish time


$photos = $db->getAll('SELECT * FROM photos WHERE UNIX_TIMESTAMP() > publish_time ');



$Photos = new Photos($f);
$Photos->db = $db;


foreach ($photos as $photo) {
    logEval($photo, 'photo to process');

//    list($token, $secret) = explode(',', $photo['auth_token']);

//    $Photos->setToken(array('token'=>$token, 'secret'=>$secret));
    $Photos->setToken($photo['auth_token']);

    $Photos->publish($photo);
}
