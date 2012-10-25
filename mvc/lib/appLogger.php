<?php
namespace Lib;

require_once (SITEPATH . 'lib/vendor/KLogger.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of appLogger
 *
 * @author marnscott
 */
class appLogger extends \KLogger {
	
	private  $_logger;
	private  $_logDirectory;
	private  $_severity;
	
	//public function __construct() {
	public function __construct($logDirectory, $severity) {
		
		//echo '<pre>'.'In appLogger constructor'.'</pre>';
		
		$this->_logDirectory = $logDirectory;
		$this->_severity = $severity;
		$this->_logger = parent::instance($logDirectory, $severity);
		
		/*
		echo '<pre>'.'$logDirectory = '.print_r($this->_logDirectory,1).'</pre>';
		echo '<pre>'.'$severity = '.print_r($this->_severity,1).'</pre>';
		echo '<pre>'.'$logger = '.print_r($this->_logger,1).'</pre>';
		 *
		 */
	}
	
	public function log ($line, $severity, $method = NULL, $args = self::NO_ARGUMENTS) {
		/*
		echo '<pre>'.'In appLogger logMsg'.'</pre>';
		echo '<pre>'.'$logDirectory = '.print_r($this->_logDirectory,1).'</pre>';
		echo '<pre>'.'$severity = '.print_r($this->_severity,1).'</pre>';
		echo '<pre>'.'$logger = '.print_r($this->_logger,1).'</pre>';
		 * 
		 */
		
		// log IF 1) LOGGING_OFF is not defined OR
		//				2) LOGGING_OFF is defined and set to false
		//if (!defined('LOGGING_OFF') || (defined('LOGGING_OFF') && !LOGGING_OFF)) {
		if (defined('LOGGING_ON') && LOGGING_ON) {
			if (isset($method))
			{
				$newline = '[' . $method . ']    ' . $line;
				$line = $newline;
			}

			$this->_logger->log($line, $severity, $args);
		}
	}
	
}

?>
