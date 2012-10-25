<?php
namespace Controllers;

class test extends \Lib\controller {

  function __construct() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		parent::__construct();
		$GLOBALS['appLog']->log('---   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
  }

	function index() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		require (SITEPATH . 'mytests/test_UserDoa_createNewUser.php');
		new test_UserDoa_createNewUser();

		//$this->view->render('help/index');
		$GLOBALS['appLog']->log('---   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
	}

}
?>