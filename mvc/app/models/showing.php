<?php
namespace Models;

/**
 * Description of showing
 *
 * @author marnscott
 * 
 */
class showing {

	private $id;
	private $clientId;
	private $propertyId;
	private $date;
	private $order;

	/**
	 * 
	 * function __construct
	 * 
	 * @param type $id  if 0, then create new showing, else get showing from db
	 * @param type $showing  $id is 0, the showing data to insert into db
	 * @return \Models\showing
	 */
	public function  __construct($id, $showing = array())
	{
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		if ($id == 0)
		{
			// create a new showing in the db
			$this->clientId = $showing['clientId'];
			$this->propertyId = $showing['propertyId'];
			$this->date = $showing['date'];
			$this->order = $showing['order'];
			$this->createNewShowing($showing);
			return $this;
		}
 		else
		{
			// get the data for this showing id from the db
			$this->getShowingData($id);
			$this->id = $id;
			return $this;
		}
	}

	/**
	 * gets showing data from database
	 */
	private function getShowingData($id)
	{
		$dsn = (\Config\DB_TYPE.':host='. \Config\DB_HOST.';dbname='. \Config\DB_NAME);
		$db = \Lib\dbHandler::getDB($dsn, \Config\DB_USER, \Config\DB_PWD);

		$selectClause = '*';
		$whereClause = '`id`=:id';
		$whereData = array(
				'id' => $id
		);
		
		try
		{

  		$results = $db->select(PROPERTIES_TABLE, $selectClause, $whereClause, $whereData);
  		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);
  
  		// @todo use Object Mapping instead???
  		if ($results['count'] === 1)
  		{
				$this->clientId = $results['data'][0]['clientId'];
				$this->propertyId = $results['data'][0]['propertyId'];
				$this->date = $results['data'][0]['date'];
				$this->order = $results['data'][0]['order'];
  		}
  		else
  		{
  			// exception
  		}
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

	} // end getShowingData

	public static function getAllShowings() {

		try
		{
  		$results = $db->select(SHOWINGS_TABLE, '*');
  		return ($results['count'] > 0 ? $results : false);

		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}

	} // end getAllProperties

	/**
	 * creates showing in database
	 */
	private function createNewShowing($showing)
	{
		$dsn = (\Config\DB_TYPE.':host='. \Config\DB_HOST.';dbname='. \Config\DB_NAME);
		$db = \Lib\dbHandler::getDB($dsn, \Config\DB_USER, \Config\DB_PWD);

		try
		{
  		$results = $db->insert(SHOWINGS_TABLE, $showing);
  		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);
  
			// returns the showing id, if error the showing id will be 0
  		if ($results['count'] === 1)
  		{
  			$this->id = $db->lastInsertId();
  		}
			else
			{
  			// some kind of error 
  			// @todo handle this error
  			die ("Database Insert Error");
			}
		} catch(PDOException $e) {
		  die('PDO Exception: ' . $e->getMessage());
		}
	} // end createNewShowing

}

?>
