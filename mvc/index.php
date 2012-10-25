<?php

define('SITEPATH', realpath(dirname(__FILE__)).'/');
require (SITEPATH . 'config/config.php');

require_once (SITEPATH . 'lib/appLogger.php');

$GLOBALS['appLog'] = new \Lib\appLogger(SITEPATH . 'logs', \Lib\appLogger::DEBUG, basename(__FILE__));
//echo '<pre> appLogger created </pre>';

//if(!defined('FW_VERSION')) die('the framework did not seem to load?');

/*
define('HOST', $_SERVER['HTTP_HOST']);

$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
define('URI', $uri);
 * 
 */

//echo '<pre>'.print_r($_SERVER['REQUEST_URI'],1).'</pre>';

$GLOBALS['appLog']->log('Using $GLOBALS[appLog]', \Lib\appLogger::DEBUG, basename(__FILE__));
$GLOBALS['appLog']->log('SITEPATH = ' . SITEPATH, \Lib\appLogger::DEBUG, basename(__FILE__));
$GLOBALS['appLog']->log('HOST = ' . HOST, \Lib\appLogger::DEBUG, basename(__FILE__));
$GLOBALS['appLog']->log('URI = ' . URI, \Lib\appLogger::DEBUG, basename(__FILE__));

require (SITEPATH . 'lib/bootstrap.php');
new \Lib\bootstrap();

?>
