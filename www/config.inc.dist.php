<?php
/**
*   Publishr-Online
*
*   @author     Costache Vicentiu <vicxyz@gmail.com>
*   @copyright (c) 2016-2017. All rights reserved.
*
*   For the full copyright and license information, please view the LICENSE* file that was distributed with this source code.
*/


//get your API key & secret from Flickr
define('API_KEY', '');
define('API_SECRET', '');
define('API_REDIRECT', '/flicker/index.php');

//for debug, default false
if (!defined('API_DEBUG')) define('API_DEBUG', false);

//for debug purposes, get the auth token
define('AUTH_TOKEN', '');




define('SITE_EMAIL', 'contact@publishr-online.com');
define('SITE_NAME', 'Photo Publishr Online');
define('SITE_URL', 'http://publishr-online.com');
define('SITE_TIMEZONE', 'America/Chicago');



//DB params
$dbconfig = array(
	'host'=>'localhost',
	'username'=>'',
	'password'=>'',
	'name'=>'publishr'
	
);
//Mail SMTP params for contact page
$mailconfig = array(
    'from'=>array('contact@publishr-online.com' =>'Feedback alert'),
    'smtp_server'=>'',
    'smtp_username'=>'',
    'smtp_password'=>'',
    'smtp_port' => 465
   
    
    );

//default photos per page
define('PHOTOS_PER_PAGE', 30);


//--- DO NOT MODIFY BELOW

//locations
if (isset($_SERVER['WINDIR']))
    define('BASE_LOCATION', substr(__FILE__,0,strrpos(__FILE__,'\\')+1));
if (!defined('BASE_LOCATION'))
    define('BASE_LOCATION', dirname(substr(__FILE__,0,strrpos(__FILE__,'/')+1)). '/application');



define('LIB_LOCATION', BASE_LOCATION."/lib/");
define('CACHE_LOCATION', BASE_LOCATION."/cache");
define('TEMPLATES_LOCATION', BASE_LOCATION."/templates");

if (!defined('LOG_NAME')) define('LOG_NAME', 'web'); //web, cron
define('LOG_LOCATION', BASE_LOCATION .'/log');