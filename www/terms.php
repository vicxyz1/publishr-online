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
$template = 'terms';


$tpl_param = [];
$tpl_param['menu'] = 'terms and conditions';

$tpl_param['site_name'] = SITE_NAME;
$tpl_param['base_url'] = SITE_URL;

$layout = isset($_SESSION['phpFlickr_auth_token'])?'layout.tpl.php':'layout_nologin.tpl.php';

$tpl->tpl = $template . '.tpl.php';
$tpl->assign($tpl_param);
$tpl->display($layout);
/*EOF*/