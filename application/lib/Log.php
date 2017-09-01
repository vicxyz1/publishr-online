<?php

/**
 *   Publishr-Online
 *
 *   @author     Costache Vicentiu <vicxyz@gmail.com>
 *   @copyright (c) 2016-2017. All rights reserved.
 *
 *   For the full copyright and license information, please view the LICENSE* file that was distributed with this source code.
 */

/**
 * Description of Log
 *
 * @author vic
 */
class Log {

    //put your code here
    /**
     * The Monolog logger instance.
     *
     * @var \Monolog\Logger
     */
    protected $monolog;

    /**
     * All of the error levels.
     *
     * @var array
     */
    protected $levels = array(
        'debug',
        'info',
        'notice',
        'warning',
        'error',
        'critical',
        'alert',
        'emergency',
    );

    private function __construct($name) {
        
    }

    public function functionName($param) {
        
    }

}


function logMessage($msg, $level = \Monolog\Logger::DEBUG) {
    global $logger;
    
    $levels = array(
        \Monolog\Logger::DEBUG =>'debug',
        \Monolog\Logger::INFO=>'info',
        \Monolog\Logger::NOTICE =>'notice',
        \Monolog\Logger::WARNING =>'warning',
        \Monolog\Logger::ERROR => 'error',
        'critical',
        'alert',
        'emergency',
    );
    
    if (isset($levels[$level])) {
        $logger->$levels[$level]($msg);
    }
// You can now use your logger
//    $logger->addInfo($msg);
}

function logEval($var, $name = '') {

    $msg = "$name:" . var_export($var, true);
    logMessage($msg);
}
