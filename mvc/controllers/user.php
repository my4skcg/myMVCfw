<?php
namespace Controllers;

class user extends \Lib\controller {
	
  public function __construct() {
		parent::__construct();
  }

	public function index() {
//		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
//		$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
//		$GLOBALS['appLog']->log('---   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		$this->register();
	} // end function index

	public function register() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		$lang = \Lib\Registry::getInstance()->get('lang');
		// if the form has not be submitted, then render form to user
		if (!isset($_POST['submitform'])) {
			$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		}
		// form has been submitted; process it
		else {

		$userdoa = new \Models\userdoa();

		$username = $_POST['username'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$email = $_POST['email'];
		$GLOBALS['appLog']->log('Username: ' . $username . '   Email: ' . $email, \Lib\appLogger::INFO, __METHOD__);
		$GLOBALS['appLog']->log('Password: ' . $password . '   Password2: ' . $password2, \Lib\appLogger::INFO, __METHOD__);

		$errors = 0;
		$errorMessages = array();
		if( empty($username) )
		{
			$GLOBALS['appLog']->log('Empty Username', \Lib\appLogger::INFO, __METHOD__);
			$errorMessages[$errors] = $lang['USERNAMEREQ'];
			$errors++;
		}
		if( empty($password) )
		{
			$GLOBALS['appLog']->log('Empty Password', \Lib\appLogger::INFO, __METHOD__);
			$errorMessages[$errors] = $lang['PWDREQ'];
			$errors++;
		}
		if( empty($password2) )
		{
			$GLOBALS['appLog']->log('Empty Confirm Password', \Lib\appLogger::INFO, __METHOD__);
			$errorMessages[$errors] = $lang['PWDCONFIRMREQ'];
			$errors++;
		}
		if( empty($email) )
		{
			$GLOBALS['appLog']->log('Empty Email', \Lib\appLogger::INFO, __METHOD__);
			$errorMessages[$errors] = $lang['EMAILREQ'];
			$errors++;
		}

		if ($errors == 0)
		{
			// so far, no errors
			// check if the username already exists
			if ($userdoa->userExists($username))
			{
				$GLOBALS['appLog']->log('Username exists', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[$errors] = $lang['USEREXISTS'];
				$errors++;
			}

			// check if password and confirm password are the same
			elseif ($password != $password2)
			{
				$GLOBALS['appLog']->log('password and confirm do not match', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[$errors] = $lang['PWDCONFIRMNOMATCH'];
				$errors++;
			}

			elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$GLOBALS['appLog']->log('Not a valid E-mail address', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[$errors] = $lang['EMAILNOTVALID'];
				$errors++;
			}

		}

		if ($errors == 0)
		{
			$u['username'] = $username;
			// only want username set in session
			\Lib\session::set('userData', $u);

			$u['email'] = $email;
			$u['created'] = date("Y-m-d H:i:s");
			$u['active'] = false;
			$u['password'] = \Lib\auth::encrypt($username, $password);
			$u['activateKey'] = 0;
			$u['salt'] = 0;

			\Lib\session::set('status', 'successful');
			$uid = $userdoa->createNewUser($u);
			$user = $userdoa->getUserData($uid);
			$this->sendActivationEmail($user);

			// add a view telling user to check email and follow the directions to complete registration
			$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		}

		else //if ($errors > 0)
		{
			$u['username'] = $username;
			$u['email'] = $email;
			\Lib\session::set('status', 'errors');
			\Lib\session::set('userData', $u);
			\Lib\session::set('displayMsg', $errorMessages);
			header("location: http://" . HOST . URI ."/user");
			exit();
		}
	}

	} // end function register

	public function activate($args)
	{
		$GLOBALS['appLog']->log('args: ' . print_r($args,1), \Lib\appLogger::INFO, __METHOD__);
		$lang = \Lib\Registry::getInstance()->get('lang');
		$uid = isset($args[0]) ? $args[0] : null;
		$key = isset($args[1]) ? $args[1] : null;
		$GLOBALS['appLog']->log('uid: ' . $uid . '   key: ' . $key, \Lib\appLogger::INFO, __METHOD__);
		if($uid && $key)
		{
			$userdoa = new \Models\userdoa();
			$user= $userdoa->getUserData($uid);
			if ($key == $user->getActivateKey())
			{
				$results = $userdoa->updateActive($uid);

				/*
			 	 * check $results for error handling
			 	 */
				if (!$results)
				{
					$msg = 'Error updating user as active.';
					$controller = new Error($msg);
					$controller->index();
				}

			}

			//
			// render view telling user the account has now been activated and may login
			//   have a login button?
			$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		}
 else {
			die ("User Id and Key not set for activation");
		}

	} // end function activate

	function editUser() {
		$lang = \Lib\Registry::getInstance()->get('lang');
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		$GLOBALS['appLog']->log('$_POST: ' . print_r($_POST, 1), \Lib\appLogger::INFO, __METHOD__);
		$GLOBALS['appLog']->log('$lang = ' . print_r($lang,1),
						appLogger::INFO, __METHOD__);

		// get user id from session
		$uid = \Lib\session::get('uid');
		$GLOBALS['appLog']->log('uid: ' . $uid, \Lib\appLogger::INFO, __METHOD__);
		// get user data from db
		$userdoa = new \Models\userdoa();
		$user = $userdoa->getUserData($uid);
		$GLOBALS['appLog']->log('user: ' . print_r($user, 1), \Lib\appLogger::INFO, __METHOD__);

		// if the form has not be submitted, then render form to user
		if (!isset($_POST['submitform'])) {
			$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		}
		// form has been submitted; process it
		else {
			$password = $_POST['password'];
			$username = $user->getUsername();
			$uidStored = \Lib\auth::authenticate($username, $password);
			$GLOBALS['appLog']->log(sprintf('user id from session (%s); user id from db (%s)', $uid, $uidStored), \Lib\appLogger::INFO, __METHOD__);

			$errors = 0;
			$errorMessages = array();

			/*
			 * Authenticate the current password entered by the user
			 * Check if the user id in the session matches the db user id
			 */
			if ($uidStored == 0) {
					$GLOBALS['appLog']->log('Invalid Password entered: ' . $uidStored, \Lib\appLogger::INFO, __METHOD__);
					$errorMessages[$errors] = $lang['INVALIDUSERPWD'];
					$errors++;
			}
			else if ($uid != $uidStored) {
					$GLOBALS['appLog']->log(sprintf('user id from session (%s) does not match user id from db (%s)', $uid, $uidStored), \Lib\appLogger::INFO, __METHOD__);
					$errorMessages[$errors] = $lang['PWDVERIFYFAIL'];
					$errors++;
			}

			if (!$errors) 
			{
				if (isset($_POST['newusername']) && ($_POST['newusername'] != '') && ($_POST['newusername'] != $username)) {
					$newusername = $_POST['newusername'];
					if ($userdoa->userExists($newusername))
					{
						$GLOBALS['appLog']->log('Username exists', \Lib\appLogger::INFO, __METHOD__);
						$errorMessages[$errors] = $lang['USEREXISTS'];
						$errors++;
					}
					else
						$user->setUsername($newusername);
				}

				if (isset($_POST['newpassword']) && ($_POST['newpassword'] != '')) {
					if ($_POST['newpassword'] != $_POST['newpassword2'])
					{
						$GLOBALS['appLog']->log('newpassword and confirm do not match', \Lib\appLogger::INFO, __METHOD__);
						$errorMessages[$errors] = $lang['PWDCONFIRNOMATCH'];
						$errors++;
					}
					else
						$password = \Lib\auth::encrypt($newusername, $_POST['newpassword']);
				}

				if (isset($_POST['email']) && ($_POST['email'] != '')) {
					$email = $_POST['email'];

					if (!filter_var($email, FILTER_VALIDATE_EMAIL))
					{
						$GLOBALS['appLog']->log('Not a valid E-mail address', \Lib\appLogger::INFO, __METHOD__);
						$errorMessages[$errors] = $lang['EMAILNOTVALID'];
						$errors++;
					}
					else
						$user->setEmail($email);
				}
			} // !$errors


		$GLOBALS['appLog']->log('user: ' . print_r($user, 1), \Lib\appLogger::DEBUG, __METHOD__);
			if ($errors == 0)
			{
				$results = $userdoa->updateUser($user, $password);
				/*
				 * @todo status message of 'User Updated Successfully'
				 */
			  \Lib\session::set('status', 'successful');
			  \Lib\session::set('displayMsg', $lang['USERUPDATED']);
				$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
			}
			else //if ($errors > 0)
			{
			  \Lib\session::set('status', 'errors');
				\Lib\session::set('userData', $u);
				\Lib\session::set('displayMsg', $errorMessages);
				$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
				//header("location: http://" . HOST . URI ."/editUser");
				//exit();
			}
		}
	} // end edit

	function delete() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		$lang = \Lib\Registry::getInstance()->get('lang');
		$userdoa = new \Models\userdoa();
		$uid = \Lib\session::get('uid');

		/*
		 * @todo must delete data from all other tables for this $uid
		 */
		if ($userdoa->deleteUser($uid))
		{
			\Lib\session::destroy();
			\Lib\session::init();
			\Lib\session::set('displayMsg', $lang['USERDELETED']);
			header("location: http://" . HOST . URI ."/index");
			exit();
		}
		else
		{
			// error
			$msg = 'Error deleting user.';
			$controller = new Error($msg);
			$controller->index();
		}

	} // end deleteuser

	private function sendActivationEmail($user)
	{
		// @todo do I need this step?
		//ini_set("SMTP", "smtp.server.com");//confirm smtp

		$domain = HOST . URI;
		$uid = $user->getId();
		$username = $user->getUsername();
		$actkey = $user->getActivateKey();
    $link = "http://$domain/user/activate/$uid/$actkey";
		
    $message = "
Thank you for registering on http://$domain/,

Your account information:

username:  $username

Please click the link below to activate your account.

$link

Regards
$domain Administration
";

		$headers = 'From: Me <admin@northtexasmoms.com>' . "\r\n";
		$headers .= "Reply-To: no-reply@$domain" . "\r\n";
    $GLOBALS['appLog']->log('To: '. $user->getEmail(), \Lib\appLogger::INFO, __METHOD__);
    $GLOBALS['appLog']->log('Email Msg: '. $message, \Lib\appLogger::INFO, __METHOD__);
    $GLOBALS['appLog']->log('$actkey = '. $actkey, \Lib\appLogger::INFO, __METHOD__);
    $GLOBALS['appLog']->log('$headers = '. $headers, \Lib\appLogger::INFO, __METHOD__);

		// mail($to,$subject,$message,$header);
    $rc = mail($user->getEmail(), "Please activate your account.", $message, $headers);
    if ($rc)
    {
        $GLOBALS['appLog']->log('Send Activate Email successful', \Lib\appLogger::INFO, __METHOD__);
				return true;
    } else
    {
        $GLOBALS['appLog']->log('Send Activate Email NOT successful', \Lib\appLogger::INFO, __METHOD__);
        return false;
    }

	} // end function sendActivationEmail

} // end class user

?>
