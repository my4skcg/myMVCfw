<?php
namespace App\Controllers;

class profile extends \Lib\controller {

  public function __construct() {
		parent::__construct();
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		// Set the directory where the views exist
		$this->view->setViewDir('app/views');
  }

	public function index() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

	}

	function editProfile() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		if (!isset($_POST['submitform'])) {
			$file = basename(__FILE__, ".php") . "/" . __FUNCTION__;
			$GLOBALS['appLog']->log('Render :    ' . $file, \Lib\appLogger::INFO, __METHOD__);
			$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		}
		// form has been submitted; process it
		else {
			$GLOBALS['appLog']->log('editProfile form was submitted.', \Lib\appLogger::INFO, __METHOD__);

		}

	}
}
	

?>
