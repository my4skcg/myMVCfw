<?php
namespace Lib;

class model {
	//protected $db;
	
	function __construct() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
	}
}
?>