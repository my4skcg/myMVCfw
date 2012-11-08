<?php
namespace App\Models;

/**
 * Description of profiledoa
 *
 * @author marnscott
 */
class profiledoa {

	private $db;
	private $classname = \App\Config\PROFILE_CLASS;
	//private $classname;
	private $tablename = \App\Config\PROFILES_TABLE;

	function __construct() {
		//$this->classname = \App\Config\PROFILE_CLASS;
		$GLOBALS['appLog']->log('$classname = ' . $this->classname, \Lib\appLogger::INFO, __METHOD__);
		$GLOBALS['appLog']->log('$tablename = ' . $this->tablename, \Lib\appLogger::INFO, __METHOD__);
		$dsn = (\Config\DB_TYPE.':host='. \Config\DB_HOST.';dbname='. \Config\DB_NAME);
		$this->db = \Lib\dbHandler::getDB($dsn, \Config\DB_USER, \Config\DB_PWD);
	}

	public function insertUpdateData($data) {
		try
		{
  		$GLOBALS['appLog']->log(print_r($data, 1), \Lib\appLogger::DEBUG, __METHOD__);
			// update the profile data
  		$this->db->insertUpdate($this->tablename, $data, $this->classname);
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

		return true;
	}

	/**
	 * gets user data from database
	 */
	public function getData($id) {

		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		// get data from the profiles table.
		//  currently consists of uid (matching id from users table), 
		//  and profileid (matching id from profile table).
		//  May later include other profile data outside of contact info

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
				// return the profile object;
  			return $results['data'][0];
  		}
  		else
  		{
				// profile does not yet exist for this user
  			return false;
  		}
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}
	}

}

?>
