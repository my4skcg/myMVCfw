<?php
namespace Controllers;

class profile extends \Lib\controller {
	
  function __construct() {
		parent::__construct();
  }

	function index() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		//$this->view->render(basename(__FILE__, ".php"));
		$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		$GLOBALS['appLog']->log('---   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
	} // end function index

	function register() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		require (SITEPATH . 'config/errorMsgs.php');
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
			$errorMessages[$errors] = $errorMsg['usernameReq'];
			$errors++;
		}
		if( empty($password) )
		{
			$GLOBALS['appLog']->log('Empty Password', \Lib\appLogger::INFO, __METHOD__);
			$errorMessages[$errors] = $errorMsg['pwdReq'];
			$errors++;
		}
		if( empty($password2) )
		{
			$GLOBALS['appLog']->log('Empty Confirm Password', \Lib\appLogger::INFO, __METHOD__);
			$errorMessages[$errors] = $errorMsg['pwdConfirmReq'];
			$errors++;
		}
		if( empty($email) )
		{
			$GLOBALS['appLog']->log('Empty Email', \Lib\appLogger::INFO, __METHOD__);
			$errorMessages[$errors] = $errorMsg['emailReq'];
			$errors++;
		}

		if ($errors == 0)
		{
			// so far, no errors
			// check if the username already exists
			if (\Models\user::userExists($username))
			{
				$GLOBALS['appLog']->log('Username exists', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[$errors] = $errorMsg['userExists'];
				$errors++;
			}

			// check if password and confirm password are the same
			elseif ($password != $password2)
			{
				$GLOBALS['appLog']->log('password and confirm do not match', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[$errors] = $errorMsg['pwdConfrmNoMatch'];
				$errors++;
			}

			elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$GLOBALS['appLog']->log('password and confirm do not match', \Lib\appLogger::INFO, __METHOD__);
				$errorMessages[$errors] = $errorMsg['emailNotValid'];
				$errors++;
			}

		}

		if ($errors > 0)
		{
			$u['username'] = $username;
			$u['email'] = $email;
			\Lib\session::set('userData', $u);
			\Lib\session::set('errorMsg', $errorMessages);
			header("location: http://" . HOST . URI ."/profile");
			exit();
		}

		$u['username'] = $username;
		$u['email'] = $email;
		$u['password'] = \Lib\auth::encrypt($password);
		$user = new \Models\user(0, $u);
		$this->sendActivationEmail($user);

		// add a view telling user to check email and follow the directions to complete registration
		$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		//die ("Activation email Sent");


	} // end function register

	function activate($args)
	{
		$GLOBALS['appLog']->log('args: ' . print_r($args,1), \Lib\appLogger::INFO, __METHOD__);
		$uid = isset($args[0]) ? $args[0] : null;
		$key = isset($args[1]) ? $args[1] : null;
		$GLOBALS['appLog']->log('uid: ' . $uid . '   key: ' . $key, \Lib\appLogger::INFO, __METHOD__);
		if($uid && $key)
		{
			$user = new \Models\user($uid);
			$user->activate($key);
			// render view telling user the account has now been activated and may login
			//   have a login button?
			$this->view->render(basename(__FILE__, ".php") . "/" . __FUNCTION__);
		}
 else {
			die ("User Id and Key not set for activation");
		}

	} // end function activate

	private function sendActivationEmail($user)
	{
		// @todo do I need this step?
		//ini_set("SMTP", "smtp.server.com");//confirm smtp

		$domain = HOST . URI;
		$uid = $user->getId();
		$username = $user->getUsername();
		$actkey = $user->getActivateKey();
    $link = "http://$domain/profile/activate/$uid/$actkey";
		
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

} // end class profile

?>
