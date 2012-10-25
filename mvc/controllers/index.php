<?php
namespace Controllers;

class index extends \Lib\controller {

  function __construct() {
    $GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		parent::__construct();
		$GLOBALS['appLog']->log('---   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
  }

	function index() {
    $GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		
		$this->view->render(basename(__FILE__, ".php"));
		$GLOBALS['appLog']->log('---   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
	}

//	function details() {
//		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
//		$this->view->render(basename(__FILE__, ".php"));
//		$GLOBALS['appLog']->log('---   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
//	}

}
?>
