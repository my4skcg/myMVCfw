<?php
namespace App\Models;

class contact {

	private $id;   
	private $userId;  // user name this contact belongs to
	private $firstname;
	private $lastname;
	private $phone1type;
	private $phone1;
	private $phone2type;
	private $phone2;
	private $phone3type;
	private $phone3;

	function __construct() {
		
	}
	public function getId() {
		return $this->id;
	}

	public function toArray($obj = NULL) {

		$vars = get_object_vars ( $this );
    $array = array ();
    foreach ( $vars as $key => $value ) {
			$GLOBALS['appLog']->log('key: ' . print_r($key, 1), \Lib\appLogger::INFO, __METHOD__);
      $array [$key] = $value;
    }
    return $array;
	}

}

?>
