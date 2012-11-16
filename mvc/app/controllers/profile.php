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
		$lang = \Lib\Registry::getInstance()->get('lang');

		// get user id from session
		$uid = \Lib\session::get('uid');
		$GLOBALS['appLog']->log('uid: ' . $uid, \Lib\appLogger::INFO, __METHOD__);

		// get profile data from db
		$profiledoa = new \App\Models\profiledoa(\App\Config\PROFILE_CLASS, \App\Config\PROFILES_TABLE);
		$GLOBALS['appLog']->log('$profiledoa :    ' . print_r($profiledoa,1), \Lib\appLogger::INFO, __METHOD__);
		$profile = $profiledoa->getData($uid);
		if ($profile)
		{
			\Lib\session::set('profileData', $profile->toArray());
			$GLOBALS['appLog']->log('profile data from db :    ' . print_r($profile,1), \Lib\appLogger::INFO, __METHOD__);
		}

		if (!isset($_POST['submitform'])) {
			$file = basename(__FILE__, ".php") . "/" . __FUNCTION__;
			$GLOBALS['appLog']->log('Render :    ' . $file, \Lib\appLogger::INFO, __METHOD__);
			$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		}
		// form has been submitted; process it
		else {
			$GLOBALS['appLog']->log('editProfile form was submitted.', \Lib\appLogger::INFO, __METHOD__);

			$p = array();
			foreach($_POST as $key=> $value) {
				if ($key != 'submitform')
				  $p[$key] = $value;   // put profile data in another array
			}

			$p['id'] = $uid;
			$GLOBALS['appLog']->log('$p :    ' . print_r($p,1), \Lib\appLogger::INFO, __METHOD__);
			
			$errorMessages = array();

			if( empty($p['firstname']) )
			{
				$GLOBALS['appLog']->log('Empty First Name', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[] = $lang['FIRSTNAMEREQ'];
			}

			if( empty($p['lastname']) )
			{
				$GLOBALS['appLog']->log('Empty Last Name', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[] = $lang['LASTNAMEREQ'];
			}

			if( empty($p['address1']) )
			{
				$GLOBALS['appLog']->log('Empty address', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[] = $lang['ADDRREQ'];
			}

			if( empty($p['city']) )
			{
				$GLOBALS['appLog']->log('Empty city', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[] = $lang['CITYREQ'];
			}

			if( empty($p['state']) )
			{
				$GLOBALS['appLog']->log('Empty state', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[] = $lang['STATEREQ'];
			}

			if( empty($p['zip']) )
			{
				$GLOBALS['appLog']->log('Empty zip', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[] = $lang['ZIPREQ'];
			}

			$GLOBALS['appLog']->log('$errorMessages :    ' . print_r($errorMessages,1), \Lib\appLogger::INFO, __METHOD__);
			if (count($errorMessages) == 0)
			{
				// all required fields are filled in
				/*
				 * @todo any other validation???
				 */
			}

			if (count($errorMessages) == 0)
			{
				$profiledoa->insertUpdateData($p);
				$GLOBALS['appLog']->log('profile data updated', \Lib\appLogger::INFO, __METHOD__);
			  \Lib\session::set('status', 'successful');
			  \Lib\session::set('displayMsg', $lang['PROFILEUPDATED']);
				$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
			}
			else
			{
				$GLOBALS['appLog']->log('error messages to display', \Lib\appLogger::INFO, __METHOD__);
			  \Lib\session::set('status', 'errors');
			  \Lib\session::set('displayMsg', $errorMessages);
			  \Lib\session::set('profileData', $p);
				$file = basename(__FILE__, ".php") . "/" . __FUNCTION__;
				$GLOBALS['appLog']->log('Render :    ' . $file, \Lib\appLogger::INFO, __METHOD__);
				$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		}

		}
	}
}
	

?>
