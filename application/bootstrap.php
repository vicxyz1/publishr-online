<?php

/**
 *   Publishr-Online
 *
 *   @author     Costache Vicentiu <vicxyz@gmail.com>
 *   @copyright (c) 2016-2017. All rights reserved.
 *
 *   For the full copyright and license information, please view the LICENSE* file that was distributed with this source code.
 */

require_once LIB_LOCATION . '/phpflickr/phpFlickr.php';

require 'vendor/autoload.php';

require_once 'vendor/adodb/adodb-php/adodb-exceptions.inc.php';
require_once 'vendor/adodb/adodb-php/adodb-errorhandler.inc.php';

// DB Connect
 $db = ADONewConnection('mysqli'); # eg. 'mysql' or 'oci8'
 $db->debug = false;
 $db->Connect($dbconfig['host'], $dbconfig['username'], $dbconfig['password'], $dbconfig['name']);
 $db->setFetchMode(ADODB_FETCH_ASSOC);

$tpl = new Savant3();
$tpl->setPath('template', TEMPLATES_LOCATION);


date_default_timezone_set(SITE_TIMEZONE);

//PHPFlickr
$f = new phpFlickr(API_KEY, API_SECRET);
//$f->enableCache("fs", CACHE_LOCATION);


use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\FirePHPHandler;


$logger = new Logger(LOG_NAME);



if (LOG_NAME == 'web') {

    // Now add some handlers
    $logger->pushHandler(new RotatingFileHandler(LOG_LOCATION . '/web.log', 7));
    if (API_DEBUG) $logger->pushHandler(new FirePHPHandler());  
} else {
    $logger->pushHandler(new RotatingFileHandler(LOG_LOCATION . '/'.LOG_NAME.'.log', 14));
}

require_once LIB_LOCATION . '/Log.php';


if (API_DEBUG) {
    $f->setToken(AUTH_TOKEN);
     $_SESSION['phpFlickr_auth_token']=array('_content' => AUTH_TOKEN);
      
}

$tpl->assign([
        'site_name' => SITE_NAME,
        'base_url' => SITE_URL
        ]);