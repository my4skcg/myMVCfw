<?php

define('SITEPATH', '/var/www/mvc/');
define('URI', '/var/www/mvc');

// possible autoloading problems with the camelcase names
define ('LOGGING_ON', true);
require (SITEPATH . 'lib/appLogger.php');

require (SITEPATH . 'lib/dbHandler.php');
require (SITEPATH . 'lib/registry.php');
require (SITEPATH . 'lib/session.php');

// non-class files
require (SITEPATH . 'config/const.php');
require (SITEPATH . 'config/database.php');
require (SITEPATH . 'languages/lang.en.php');
\Lib\Registry::getInstance()->set('lang', $lang);

include_once(SITEPATH . 'tests/AutoLoader.php');

?>
