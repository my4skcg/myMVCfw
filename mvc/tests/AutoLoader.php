<?php

//echo 'In AutoLoader.php' . PHP_EOL;

		set_include_path(sprintf(
			'%s%s%s',
			get_include_path(),
			PATH_SEPARATOR,
			dirname(dirname(__FILE__))
		));

		spl_autoload_extensions(".class.php,.php,inc");

//		echo 'include path = ' . get_include_path() . PHP_EOL;
		
		spl_autoload_register(function($class){
//			echo PHP_EOL . 'class = ' . $class . PHP_EOL;
			try { spl_autoload($class); }
			catch(Exception $e) { }
		});

?>
