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
$template = 'contact';

$tpl_param = [];
$tpl_param['menu'] = 'contact';
if (isset($_POST['email'])) {

    $replyto = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $mailbody = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    
    if (!empty($replyto) && !empty($mailbody)) {
        
        $mailto = SITE_EMAIL;

        // Create the Transport the call setUsername() and setPassword()
        $transport = Swift_SmtpTransport::newInstance($mailconfig['smtp_server'], $mailconfig['smtp_port'], 'ssl')
                ->setUsername($mailconfig['smtp_username'])
                ->setPassword($mailconfig['smtp_password'])
        ;
       // logEval($transport, 'mailtp');
// Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance()

                // Give the message a subject
                ->setSubject('Feedback received from '.$name)

                // Set the From address with an associative array
                ->setFrom($mailconfig['from'])
                ->setReplyTo($mailconfig['from'])
                // Set the To addresses with an associative array
                ->setTo($mailto)

                // Give it a body
                ->setBody($mailbody, 'text/html');
        logMessage("Feedback received: $mailbody - from $name");
        
        $tpl_param['result'] = true;
        if (!$mailer->send($message)) {
            $tpl_param['result'] = false;
            logMessage("Error sending alert to $mailto");
        }
    }
}



$layout = isset($_SESSION['phpFlickr_auth_token'])?'layout.tpl.php':'layout_nologin.tpl.php';

$tpl->tpl = $template . '.tpl.php';
$tpl->assign($tpl_param);
$tpl->display($layout);
/*EOF*/