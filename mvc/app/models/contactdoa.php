<?php
namespace App\Models;

/**
 * Description of profiledoa
 *
 * @author marnscott
 */
class contactdoa extends \Lib\doa {

	function __construct($class, $table) {
		parent::__construct($class, $table);
	}

	public function contactExists($contact)
	{
		$GLOBALS['appLog']->log('+++   ' . __METHOD__, \Lib\appLogger::INFO, __METHOD__);

		$selectClause = '`id`';
		$whereClause = '`firstname`=:firstname AND `lastname`=:lastname';
		$whereData = array(
				'userid' => $c['uid'],
				'firstname' => $c['firstname'],
				'lastname' => $c['lastname']
		);
		
		$results = $this->db->select($this->tablename, $selectClause, $whereClause, $whereData, $this->classname);
//		$GLOBALS['appLog']->log(print_r($results, 1), \Lib\appLogger::DEBUG, __METHOD__);

		if ($results['count'] == 0)
			return false;
		else
			return true;

	}

}

?>
