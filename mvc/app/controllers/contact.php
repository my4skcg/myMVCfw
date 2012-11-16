<?php
namespace App\Controllers;

class contact extends \Lib\controller {

	private $consts = ['add' => 'add', 'update' => 'update',
					'newRequest' => 'new', 'errors' => 'errors', 'successful' => 'successful'];
	private $contactdoa;

  public function __construct() {
		parent::__construct();
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		$this->contactdoa = new \App\Models\contactdoa(\App\Config\CONTACT_CLASS, \App\Config\CONTACTS_TABLE);
		$GLOBALS['appLog']->log('$contactdoa :    ' . print_r($this->contactdoa,1), \Lib\appLogger::INFO, __METHOD__);
		// Set the directory where the views exist
		$this->view->setViewDir('app/views');
  }

	public function index() {
	}

	function addContact() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		$lang = \Lib\Registry::getInstance()->get('lang');

		if (!isset($_POST['submit'])) {
			$parms = array(
					'lang' => $lang,
					'action' => $this->consts['add'],
					'consts' => $this->consts,
					'status' => $this->consts['newRequest']);
			\Lib\session::set('parms', $parms);
			$file = basename(__FILE__, ".php") . "/" . __FUNCTION__;
			$GLOBALS['appLog']->log('Render :    ' . $file, \Lib\appLogger::INFO, __METHOD__);
			$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		}
		else {
			$GLOBALS['appLog']->log('addContact form was submitted.', \Lib\appLogger::INFO, __METHOD__);

			// get user id from session
			$parms['uid'] = $uid = \Lib\session::get('uid');
			$GLOBALS['appLog']->log('uid: ' . $uid, \Lib\appLogger::INFO, __METHOD__);

			$c = array();
			foreach($_POST as $key=> $value) {
				if ($key != 'submit')
				  $c[$key] = $value;   // put profile data in another array
			}

			$c['userid'] = $uid;
			$GLOBALS['appLog']->log('$c :    ' . print_r($c,1), \Lib\appLogger::INFO, __METHOD__);
			
			$errorMessages = $this->validateFields($c);

			if (count($errorMessages) == 0)
			{
				$this->contactdoa->insertData($c);
				$GLOBALS['appLog']->log('New Contact was added', \Lib\appLogger::INFO, __METHOD__);
				$status = $this->consts['successful'];
				$displayMsg = $lang['CONTACTADDED'];
				$c = array();  // clear the contact data so blank form will be displayed to user
			}
			else
			{
				$GLOBALS['appLog']->log('error messages to display', \Lib\appLogger::INFO, __METHOD__);
				$status = $this->consts['errors'];
				$displayMsg = $errorMessages;
			}

			$parms = array(
					'lang' => $lang,
					'consts' => $this->consts,
					'submit' => $_POST['submit'],
					'action' => $this->consts['add'],
					'status' => $status,
					'displayMsg' => $displayMsg,
					'contactData' => $c 
					);

			\Lib\session::set('parms', $parms);
			$file = basename(__FILE__, ".php") . "/" . __FUNCTION__;
			$GLOBALS['appLog']->log('Render :    ' . $file, \Lib\appLogger::INFO, __METHOD__);
			$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		}
	}

	private function validateFields($c) {

		$lang = \Lib\Registry::getInstance()->get('lang');
			$errorMessages = array();

			if ($this->contactdoa->contactExists($c)) {
				$GLOBALS['appLog']->log('Contact with this name already exists for the user', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages['exists'] = $lang['CONTACTEXISTS'];
			}

			if( empty($c['firstname']) ) {
				$GLOBALS['appLog']->log('Empty First Name', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages['firstname'] = $lang['FIRSTNAMEREQ'];
			}

			if( empty($c['lastname']) ) {
				$GLOBALS['appLog']->log('Empty Last Name', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages['lastname'] = $lang['LASTNAMEREQ'];
			}

			if (!empty($c['phone1'])) {
				if (empty($c['phone1type'])) {
					$GLOBALS['appLog']->log('Phone number 1 requires a type', \Lib\appLogger::INFO, __METHOD__);
					$errorMessages['phone1type'] = $lang['PHREQTYPE'];
				}

				if (!preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $c['phone1'])) {
					$errorMessages['phone1'] = $lang['PHINVFORMAT'];
					$GLOBALS['appLog']->log('Phone 1 ' . $c['phone1'] . ' ' .  $errorMessages['phone1'], \Lib\appLogger::INFO, __METHOD__);
				}
			}

			if (!empty($c['phone2'])) {
				if (empty($c['phone2type'])) {
					$GLOBALS['appLog']->log('Phone number 2 requires a type', \Lib\appLogger::INFO, __METHOD__);
					$errorMessages['phone2type'] = $lang['PHREQTYPE'];
				}

				if (!preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $c['phone2'])) {
					$errorMessages['phone2'] = $lang['PHINVFORMAT'];
					$GLOBALS['appLog']->log('Phone 2 ' . $c['phone2'] . ' ' .  $errorMessages['phone2'], \Lib\appLogger::INFO, __METHOD__);
				}
			}

			if (!empty($c['phone3'])) {
				if (empty($c['phone3type'])) {
					$GLOBALS['appLog']->log('Phone number 3 requires a type', \Lib\appLogger::INFO, __METHOD__);
					$errorMessages['phone3type'] = $lang['PHREQTYPE'];
				}

				if (!preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $c['phone3'])) {
					$errorMessages['phone3'] = $lang['PHINVFORMAT'];
					$GLOBALS['appLog']->log('Phone 3 ' . $c['phone3'] . ' ' .  $errorMessages['phone3'], \Lib\appLogger::INFO, __METHOD__);
				}
			}

			if (!empty($c['phone1type']) && empty($c['phone1'])) {
				$GLOBALS['appLog']->log('Phone type 1 requires a number', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages['phone1'] = $lang['PHTYPEREQNUM'];
			}

			if (!empty($c['phone2type']) && empty($c['phone2']) ) {
				$GLOBALS['appLog']->log('Phone type 2 requires a number', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages['phone2'] = $lang['PHTYPEREQNUM'];
			}

			if (!empty($c['phone3type']) && empty($c['phone3']) ) {
				$GLOBALS['appLog']->log('Phone type 3 requires a number', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages['phone3'] = $lang['PHTYPEREQNUM'];
			}

			return $errorMessages;
	}
}

?>
