<?php
namespace Models;

/**
 * Description of user
 *
 * @author marnscott
 * @todo extend doa
 */
class userdoa {

	private $db;
	private $classname = USERS_CLASS;
	private $tablename = USERS_TABLE;
	//private $classname = \Config\USERS_CLASS;

	function __construct() {
		$dsn = (\Config\DB_TYPE.':host='. \Config\DB_HOST.';dbname='. \Config\DB_NAME);
		$this->db = \Lib\dbHandler::getDB($dsn, \Config\DB_USER, \Config\DB_PWD);
	}

	public function userExists($username)
	{
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		$selectClause = '`id`';
		$whereClause = '`username`=:username';
		$whereData = array(
				'username' => $username
		);
		
		$results = $this->db->select($this->tablename, $selectClause, $whereClause, $whereData, $this->classname);
		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);

		if ($results['count'] == 0)
			return false;
		else
			return true;

	}

	public function createNewUser($userData) {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		try
		{
			$userData['activateKey'] = $this->createActivateKey();
  		$this->db->insert($this->tablename, $userData, $this->classname);
  		$GLOBALS['appLog']->log(print_r($userData, 1), \Lib\appLogger::DEBUG, __METHOD__);
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

		$uid = $this->db->lastInsertId();
		return $uid;
	}

	/**
	 * gets user data from database
	 */
	public function getUserData($id) {

		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		$selectClause = '*';
		$whereClause = '`id`=:id';
		$whereData = array(
				'id' => $id
		);
		
		try
		{
  		$results = $this->db->select($this->tablename, $selectClause, $whereClause, $whereData, $this->classname);
  		$GLOBALS['appLog']->log('results of select: ' . print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);
  
  		if ($results['count'] === 1)
  		{
				// return the user object;
  			return $results['data'][0];
  		}
  		else
  		{
  			// exception
  		}
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}
	}

	public function getAllUsers() {

	} // end getAllUsers

	public function updateLastlogin($uid) {

		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		$lastlogin = date("Y-m-d H:i:s");
		$data = array(
				'lastlogin' => $lastlogin
		);

		$whereClause = '`id`=:id';
		$whereData = array(
				'id' => $uid
		);

		try
		{
			$results = $this->db->update($this->tablename, $data, $whereClause, $whereData, $this->classname);
			$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);

			if ($results != false)
			{
				// db function was successful, but did we get the results we expected?
				if ($results == 1)
					// one row was updated
					return true;
				else
					return false;
			}
			else
				return false;


		} catch(PDOException $e) {
			die('PDO Exception: ' . $e->getMessage());
		}

	}

	public function updateActive($uid) {

		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		$data = array(
				'active' => true,
				'activateKey' => ''
		);

		$whereClause = '`id`=:id';
		$whereData = array(
				'id' => $uid
		);

		try
		{
			$results = $this->db->update($this->tablename, $data, $whereClause, $whereData, $this->classname);
			$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);

			if ($results != false)
			{
				// db function was successful, but did we get the results we expected?
				if ($results == 1)
					// one row was updated
					return true;
				else
					return false;
			}
			else
				return false;

		} catch(PDOException $e) {
			die('PDO Exception: ' . $e->getMessage());
		}
	}

	public function updateUser($user, $password = NULL) {

		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		$userArray = $user->toArray();
		//$GLOBALS['appLog']->log('user: ' . print_r($user, 1), \Lib\appLogger::DEBUG, __METHOD__);
		//$GLOBALS['appLog']->log('userArray: ' . print_r($userArray, 1), \Lib\appLogger::DEBUG, __METHOD__);
		$uid = $user->getId();
		if ($password)
			$user->setPassword($password);

		$whereClause = '`id`=:id';
		$whereData = array(
				'id' => $uid
		);

		try
		{
			$results = $this->db->update($this->tablename, $userArray, $whereClause, $whereData, $this->classname);
			$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);

			if ($results != false)
			{
				// db function was successful, but did we get the results we expected?
				if ($results == 1)
					// one row was updated
					return true;
				else
					return false;
			}
			else
				return false;
		} catch(PDOException $e) {
			die('PDO Exception: ' . $e->getMessage());
		}
	} // end updateUser

	public function deleteUser($uid) {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		try
		{
			$whereClause = '`id`=:id';
			$whereData = array(
					'id' => $uid
			);
		
			// returns true or false
  		$rc = $this->db->delete($this->tablename, $whereClause, $whereData, $this->classname);
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

		/*
		 * @todo check return code and handle error
		 */
		return $rc;

	}

	private function createActivateKey()
	{
		return (md5(uniqid(rand(), true)));
	}

} // end class userHelper
?>
