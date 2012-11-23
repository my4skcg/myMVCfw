<?php

class autoloader {
//	function __construct() {
//		set_include_path(sprintf(
//			'%s%s%s',
//			get_include_path(),
//			PATH_SEPARATOR,
//			dirname(dirname(__FILE__))
//		));
//		
//		spl_autoload_register(function($c){
//			$GLOBALS['appLog']->log('$c= ' . print_r($c, 1), appLogger::INFO, __METHOD__);
//			try { spl_autoload($c); }
//			catch(Exception $e) { }
//		});
//
//	}
//}
 
    static private $classNames = array();
 
    /**
     * Store the filename (sans extension) & full path of all ".php" files found
     */
    public static function registerDirectory($dirName) {
 
        $di = new DirectoryIterator($dirName);
        foreach ($di as $file) {
 
            if ($file->isDir() && !$file->isLink() && !$file->isDot()) {
                // recurse into directories other than a few special ones
                self::registerDirectory($file->getPathname());
            } elseif (substr($file->getFilename(), -4) === '.php') {
                // save the class name / path of a .php file found
                $className = substr($file->getFilename(), 0, -4);
                autoloader::registerClass($className, $file->getPathname());
            }
        }
    }
 
    public static function registerClass($className, $fileName) {
        autoloader::$classNames[$className] = $fileName;
    }
 
    public static function loadClass($className) {
        if (isset(autoloader::$classNames[$className])) {
            require_once(autoloader::$classNames[$className]);
        }
     }
 
}
 
spl_autoload_register(array('autoloader', 'loadClass'));

?>
