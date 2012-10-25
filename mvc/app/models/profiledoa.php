<?php

/**
 * Description of profiledoa
 *
 * @author marnscott
 */
class profiledoa {

	private $db;
	private $classname = App\Config\PROFILE_CLASS;

	function __construct() {
		$dsn = (\Config\DB_TYPE.':host='. \Config\DB_HOST.';dbname='. \Config\DB_NAME);
		$this->db = \Lib\dbHandler::getDB($dsn, \Config\DB_USER, \Config\DB_PWD);
	}

	public function createNewProfile($profileData) {
		try
		{
  		$this->db->insert(PROFILES_TABLE, $profileData, $this->classname);
  		$GLOBALS['appLog']->log(print_r($profileData, 1), \Lib\appLogger::DEBUG, __METHOD__);
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

		$uid = $this->db->lastInsertId();
		return $uid;
	}

}

?>
