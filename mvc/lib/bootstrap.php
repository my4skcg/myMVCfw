<?php
namespace Lib;

class bootstrap {


  function __construct() {

		/* 
		 * @todo incorporate router and request classes from mvcThephpechoTutorial
		 * should I use 
		 * 		call_user_func(array($controller, $method), $args);
		 * 		slower than below, but can handle methods with different # of args
		 * OR 
		 * 		$controller->{$method}($arg);
		 * 		can $arg be an array of args or can it only be one arg?
		 * 		this is faster than the above
		 */

		//echo '<pre>'.print_r('In Boostrap constructor',1).'</pre>';
    //require (SITEPATH . 'lib/KLogger.php');
		//require_once (SITEPATH . 'app/appLogger.php');
		
		if (DEVELOPMENT_ENVIRONMENT == true) 
		{
			define ('LOGGING_ON', true);
			error_reporting(E_ALL);
			ini_set('display_errors','On');
		}

		$GLOBALS['appLog']->log('##############  ' . __METHOD__, appLogger::INFO, __METHOD__);
		
		// Setup the autoloader
		$this->loader();

		// Initialize the session
		session::init();

		// Determine language
		$this->loadLang();
		
		// Setup the database handling
		require_once (SITEPATH . 'config/const.php');
		require_once (SITEPATH . 'config/database.php');
		require_once (SITEPATH . 'lib/dbHandler.php');
		// @todo currently implemented as a factory; do I want to put it in registry?
		new dbHandler();

		$this->route(new request());
				

	} // function
	
	private function route(request $request)
	{
			$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
//			$GLOBALS['appLog']->log('$request = ' . print_r($request,1), appLogger::DEBUG, __METHOD__);
			
			$cntrlr = $request->getController();
			$method = $request->getMethod();
			$args = $request->getArgs();
//			$GLOBALS['appLog']->log('controller = ' . $cntrlr, appLogger::DEBUG, __METHOD__);
//			$GLOBALS['appLog']->log('method = ' . $method, appLogger::DEBUG, __METHOD__);
//			$GLOBALS['appLog']->log('args = ' . print_r($args,1), appLogger::DEBUG, __METHOD__);

			$controllerFile = SITEPATH.'controllers/'.$cntrlr.'.php';
			// App controller
			$appControllerFile = SITEPATH.'app/controllers/'.$cntrlr.'.php';
			$GLOBALS['appLog']->log('controllerFile = ' . $controllerFile, appLogger::DEBUG, __METHOD__);
			$GLOBALS['appLog']->log('appControllerFile = ' . $appControllerFile, appLogger::DEBUG, __METHOD__);

			// Check if a controller exists in the framework or app and if the file is readable
			$className = false;
			if (file_exists($controllerFile)) {
//				$GLOBALS['appLog']->log($controllerFile . ' exists', appLogger::INFO, __METHOD__);
				if (is_readable($controllerFile)) {
					$className = sprintf('\Controllers\%s', $cntrlr);
//					$GLOBALS['appLog']->log($controllerFile . ' is readable', appLogger::INFO, __METHOD__);
				}
//				else
//					$GLOBALS['appLog']->log($controllerFile . ' is not readable', appLogger::INFO, __METHOD__);
			}
			elseif (file_exists($appControllerFile)) {
//				$GLOBALS['appLog']->log($appControllerFile . ' exists', appLogger::INFO, __METHOD__);
				if (is_readable($appControllerFile)) {
					$className = sprintf('\App\Controllers\%s', $cntrlr);
//					$GLOBALS['appLog']->log($appControllerFile . ' is readable', appLogger::INFO, __METHOD__);
				}
//				else
//					$GLOBALS['appLog']->log($appControllerFile . ' is not readable', appLogger::INFO, __METHOD__);
			}

			// if $classname was set above, then a controller exists
			if ($className) {

//				$GLOBALS['appLog']->log('className = ' . $className, appLogger::DEBUG, __METHOD__);

				$controller = new $className;
				$GLOBALS['appLog']->log('$controller = ' . print_r($controller, 1), appLogger::INFO, __METHOD__);
				
//				if (is_callable(array($controller,$method)))
//					$GLOBALS['appLog']->log('Callable', appLogger::DEBUG, __METHOD__);
//				else
//					$GLOBALS['appLog']->log('Not Callable', appLogger::DEBUG, __METHOD__);
				 		

				$method = (is_callable(array($controller,$method))) ? $method : 'index';
				$GLOBALS['appLog']->log('method = ' . $method, appLogger::DEBUG, __METHOD__);

				if (!empty($args))
				{
					call_user_func(array($controller,$method),$args);
				}
				else
				{
					call_user_func(array($controller,$method));
				}
			}
		$GLOBALS['appLog']->log('---   ' . __METHOD__, appLogger::INFO, __METHOD__);
	}
	
	function loader() {
		
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
		
		set_include_path(sprintf(
			'%s%s%s',
			get_include_path(),
			PATH_SEPARATOR,
			dirname(dirname(__FILE__))
		));
		
		$GLOBALS['appLog']->log('get_include_path() = ' . get_include_path(), appLogger::INFO, __METHOD__);
		//	spl_autoload_register();

		spl_autoload_register(function($c){
//			$GLOBALS['appLog']->log('$c= ' . print_r($c, 1), appLogger::INFO, __METHOD__);
			try { spl_autoload($c); }
			catch(Exception $e) { }
		});

		// framework version. do not touch.
		// @todo check this in all files; die if not set.
		define('FW_VERSION','1.0');

		// set this to the name of your application's namespace.
		// @todo use this in my code???
		define('FW_APP_NS','App');
		
		$GLOBALS['appLog']->log('---   ' . __METHOD__, appLogger::INFO, __METHOD__);

// ********* use an autoloader
//    require_once (SITEPATH . 'lib/view.php');
//    require_once (SITEPATH . 'lib/controller.php');
//    require_once (SITEPATH . 'lib/model.php');
//    require_once (SITEPATH . 'lib/database.php');
//    require_once (SITEPATH . 'lib/session.php');
//		require_once (SITEPATH . 'lib/request.php');
//    require_once (SITEPATH . 'config/database.inc');
//		$GLOBALS['appLog']->log(print_r(get_included_files(),1), appLogger::DEBUG);
		}

	private function loadLang()
	{
		if(isSet($_GET['lang']))
		{
			$lang = $_GET['lang'];

			// register the session and set the cookie
			$_SESSION['lang'] = $lang;

//			setcookie('lang', $lang, time() + (3600 * 24 * 30));
		}
			else if(isSet($_SESSION['lang']))
		{
			$lang = $_SESSION['lang'];
		}
//			else if(isSet($_COOKIE['lang']))
//		{
//			$lang = $_COOKIE['lang'];
//		}
		else
		{
			$lang = 'en';
		}

		switch ($lang) {
			case 'en':
			$lang_file = 'lang.en.php';
			break;

//			case 'de':
//			$lang_file = 'lang.de.php';
//			break;
//
//			case 'es':
//			$lang_file = 'lang.es.php';
//			break;

			default:
			$lang_file = 'lang.en.php';

		}

		$file = SITEPATH . 'languages/' . $lang_file;
//		$GLOBALS['appLog']->log('loading lang file: ' . $file, appLogger::INFO, __METHOD__);
		include_once SITEPATH . 'languages/'.$lang_file;
		//$GLOBALS['appLog']->log('$lang = ' . print_r($lang,1), appLogger::INFO, __METHOD__);
		\Lib\Registry::getInstance()->set('lang', $lang);
	} // loadLang

	function error($msg) {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
		
		//require SITEPATH . 'controllers/errorController.php';
		$controller = new Error($msg);
		$controller->index();

		$GLOBALS['appLog']->log('---   ' . __METHOD__, appLogger::INFO, __METHOD__);
		// @todo Do I really want to return false???
		return false;
	}
	
} // class
?>
