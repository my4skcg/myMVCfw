<?php

//define('SITEPATH', '/Users/marnscott/WebDev/NetBeansProjects/mvc-php-fw/myMVCfw/mvc/');
define('SITEPATH', '/var/www/mvc/');
//
require (SITEPATH . 'config/const.php');
require (SITEPATH . 'config/database.php');
require (SITEPATH . 'lib/appLogger.php');
require (SITEPATH . 'lib/database.php');
require (SITEPATH . 'lib/dbHandler.php');

include_once(SITEPATH . '/tests/autoloader.php');

// Register the directory to your include files
//autoLoader::registerDirectory(SITEPATH);
autoloader::registerDirectory(SITEPATH . 'config');
autoloader::registerDirectory(SITEPATH . 'lib');
autoloader::registerDirectory(SITEPATH . 'controllers');
autoloader::registerDirectory(SITEPATH . 'models');
autoloader::registerDirectory(SITEPATH . 'views');

$GLOBALS['appLog'] = new \Lib\appLogger(SITEPATH . 'phpunitlogs', \Lib\appLogger::DEBUG, basename(__FILE__));

?>
