<?php
namespace Models;

/**
 * Description of user
 *
 * @author marnscott
 */
//class user extends \Lib\model {
class user {

	private $id;
	private $username;
	private $password;
	private $email;
	private $active;
	private $activateKey;
	private $salt;
	private $created;
	private $lastlogin;

	public function  __construct() {
		//parent::__construct();
	}

	/**
	 * check if the user has activated the account
	 */
	public function checkActive() {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		return ($this->active ? true : false);
	}

	public function getId() {
		return $this->id;
	}

	public function getActivateKey() {
		return $this->activateKey;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function createActivateKey() {
		return (md5(uniqid(rand(), true)));
	}

	public function toArray($obj = NULL) {

		$vars = get_object_vars ( $this );
    $array = array ();
    foreach ( $vars as $key => $value ) {
			//$GLOBALS['appLog']->log('key: ' . print_r($key, 1), \Lib\appLogger::INFO, __METHOD__);
      $array [$key] = $value;
    }
    return $array;
	}

}
?>
