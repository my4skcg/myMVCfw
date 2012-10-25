<?php
namespace Lib;

class database extends \PDO {
	
	private $connection;
	
	public function __construct($dsn, $username, $password) {
//		$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
		$connection = parent::__construct($dsn, $username, $password);	
	}

	/**
	 * update
	 * @param string $table A name of table to insert into
	 * @param string $data An associative array containing data to select
	 * @param string $where An associate array containing the where criteria
	 */
	public function select ($table, $selectClause, $whereClause, $whereData, $classname)
	{
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
		
		$stmt = $this->prepare("SELECT $selectClause FROM $table WHERE $whereClause");
		
		foreach ($whereData as $key => $value) 
		{
			$stmt->bindValue(":$key", $value);
		}
		
		$GLOBALS['appLog']->log('stmt = ' . print_r($stmt, 1), \Lib\appLogger::DEBUG, __METHOD__);
		
		$results = $stmt->execute();
	//	$stmt->bind_result($result);   ??? do i want to use this?
		
		$data = $stmt->fetchAll(\PDO::FETCH_CLASS, $classname);
		$count = $stmt->rowCount();
		$GLOBALS['appLog']->log('rowCount = ' . $count, \Lib\appLogger::DEBUG, __METHOD__);
		$GLOBALS['appLog']->log(print_r($data, 1), \Lib\appLogger::DEBUG, __METHOD__);

		return array('count'=>$count, 'data'=>$data);
	}
	
	/**
	 * insert
	 * @param type $table Name of the table in which to insert data
	 * @param type $data An associative array of the data to insert into $table
	 */
	public function insert ($table, $data, $classname)
	{
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
		//ksort($data);
		
		$GLOBALS['appLog']->log(print_r($data, 1), appLogger::INFO, __METHOD__);
		
		$fieldnames = implode('`,`', array_keys($data));
		$fieldvalues = ':' . implode(', :', array_keys($data));
		$sql = "INSERT INTO $table (`$fieldnames`) VALUES ($fieldvalues)";
		
		$GLOBALS['appLog']->log($sql, appLogger::INFO, __METHOD__);
		
		$stmt = $this->prepare($sql);
		foreach ($data as $key => $value) 
		{
			$GLOBALS['appLog']->log($key . '=>' . $value, appLogger::INFO, __METHOD__);
			$stmt->bindValue(":$key", $value);
		}
		
		/*
		 * @todo examples don't seem to check the return from execute(); why?
		 */
		$results = $stmt->execute();
		$count = $stmt->rowCount();
		$data = $stmt->fetchAll(\PDO::FETCH_CLASS, $classname);

		return array('count'=>$count, 'data'=>$data);
		
	}
	
	/**
	 * update
	 * @param string $table A name of table to insert into
	 * @param string $data An associative array
	 * @param string $where the WHERE query part
	 */
	/* @todo change params and prepare to include
	 *		whereClause and whereData
	 *		like select function
	 */
	
	public function update ($table, $data, $whereClause, $whereData, $classname)
	{
		$GLOBALS['appLog']->log(print_r($data, 1), appLogger::INFO, __METHOD__);
		$GLOBALS['appLog']->log(print_r($whereData, 1), appLogger::INFO, __METHOD__);
		$fieldDetails = NULL;

		foreach($data as $key=> $value) {
			$fieldDetails .= "`$key`=:$key,";
		}
		$fieldDetails = rtrim($fieldDetails, ',');
		
		$sql = "UPDATE $table SET $fieldDetails WHERE $whereClause";
		$GLOBALS['appLog']->log($sql, appLogger::INFO, __METHOD__);
		$stmt = $this->prepare($sql);
		
		foreach ($data as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}
		
		foreach ($whereData as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}
		
		$GLOBALS['appLog']->log(print_r($stmt, 1), appLogger::INFO, __METHOD__);
		$results = $stmt->execute();

		if ($results)
		{
			$count = $stmt->rowCount();

			return $count;
		}
		else
			return false;
	}


	/**
	 * update
	 * @param string $table A name of table to insert into
	 * @param string $data An associative array containing data to select
	 * @param string $where An associate array containing the where criteria
	 */
	public function delete ($table, $whereClause, $whereData, $classname)
	{
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, appLogger::INFO, __METHOD__);
		
		$stmt = $this->prepare("DELETE FROM $table WHERE $whereClause");
		
		foreach ($whereData as $key => $value) 
		{
			$stmt->bindValue(":$key", $value);
		}
		
		$GLOBALS['appLog']->log('stmt = ' . print_r($stmt, 1), \Lib\appLogger::DEBUG, __METHOD__);
		
		$results = $stmt->execute();
		
		$GLOBALS['appLog']->log('rowCount = ' . $stmt->rowCount(), \Lib\appLogger::DEBUG, __METHOD__);

		return ($stmt->rowCount() === 1 ? true : false);
	}
}

?>
