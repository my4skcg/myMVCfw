<?php
namespace Lib;

class doa {
	
	protected $db;
	protected $classname;
	protected $tablename;

	function __construct($class, $table) {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
	  $this->classname = $class;
		$this->tablename = $table;
		$GLOBALS['appLog']->log('$classname = ' . $this->classname, \Lib\appLogger::INFO, __METHOD__);
		$GLOBALS['appLog']->log('$tablename = ' . $this->tablename, \Lib\appLogger::INFO, __METHOD__);
		$dsn = (\Config\DB_TYPE.':host='. \Config\DB_HOST.';dbname='. \Config\DB_NAME);
		$this->db = \Lib\dbHandler::getDB($dsn, \Config\DB_USER, \Config\DB_PWD);
  	$GLOBALS['appLog']->log(print_r($this->db, 1), \Lib\appLogger::DEBUG, __METHOD__);
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

	public function insertData($data) {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		try
		{
  		$this->db->insert($this->tablename, $data, $this->classname);
  		$GLOBALS['appLog']->log(print_r($data, 1), \Lib\appLogger::DEBUG, __METHOD__);
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

		$id = $this->db->lastInsertId();
		return $id;
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

	public function updateDataById($data, $id) {

		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		$dataArray = $data->toArray();
		//$GLOBALS['appLog']->log('data: ' . print_r($data, 1), \Lib\appLogger::DEBUG, __METHOD__);
		//$GLOBALS['appLog']->log('dataArray: ' . print_r($dataArray, 1), \Lib\appLogger::DEBUG, __METHOD__);
		$whereClause = '`id`=:id';
		$whereData = array(
				'id' => $id
		);

		try
		{
			$results = $this->db->update($this->tablename, $dataArray, $whereClause, $whereData, $this->classname);
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

	public function deleteDataById($id) {
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);
		try
		{
			$whereClause = '`id`=:id';
			$whereData = array(
					'id' => $id
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


}
?>
