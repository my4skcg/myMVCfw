<?php
namespace Models;
/*
 * @todo Use or Delete ????
 * 	implemented this intending on putting the object in $_SESSION
 * 	to pass messages to user, but an object must be serialized in
 * 	order to do so.  Not sure if I want to do that.
 */

/**
 * Description of message
 *
 * @author marnscott
 */
class message {
	private $status = null;
	private $messages = array();

	function __construct() {
		
	}

	public function setStatus($s) {
		$this->status = $s;
	}

	public function getStatus() {
		return $this->status;
	}

	public function addMsg($msg) {
		$this->messages[] = $msg;
	} // add

	public function popMsg() {
		return array_pop($this->messages);
	} // pop
} // class message

?>
