<?php
/*!
* This file is part of the HybridAuth PHP Library (hybridauth.sourceforge.net | github.com/hybridauth/hybridauth)
*
* This branch contains work in progress toward the next HybridAuth 3 release and may be unstable.
*/

namespace Hybridauth\Logger;

/**
 * Debugging and Logging manager
 */
class LogWriter implements \Hybridauth\Logger\LoggerInterface
{ 
	public $enabled = false;

	public $file    = null;

	// --------------------------------------------------------------------

	function __construct( $enabled = false, $file = null )
	{
		$this->enabled = $enabled;
		$this->file    = $file;
	}

	// --------------------------------------------------------------------

	public function info($message, $extra = array())
	{
		$this->_write( "INFO", $message, $extra );
	}

	// --------------------------------------------------------------------

	public function error($message, $extra = array())
	{
		$this->_write( "ERROR", $message, $extra );
	}

	// --------------------------------------------------------------------

	public function debug($message, $extra = array())
	{
		$this->_write( "DEBUG", $message, $extra );
	}

	// --------------------------------------------------------------------

	private function _write($level, $message, $extra = array())
	{
		if( ! $this->enabled ){
			return;
		}

		if( ! file_exists( $this->file ) || is_writable( $this->file ) ){
			return;
		}

		if( count( $extra ) ){
			$message .= " -- " . print_r($extra, true);
		}

		$datetime = new DateTime();
		$datetime =  $datetime->format(DATE_ATOM);

		file_put_contents(
			$this->file, 
			$level . " -- " . $_SERVER['REMOTE_ADDR'] . " -- " . $datetime . " -- " . $message . "\n", 
			FILE_APPEND
		); 
	}
}
