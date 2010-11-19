<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Driver for sending with sendmail
 * Based heavily on the code from the Email class in Codeigniter.
 */
class Dmail_sendmail extends CI_Driver {

	/**
	 * Sends the email using the sendmail protocol
	 * @return boolean True if successful, false if not.
	 */
	public function send() {

		$return = true;
		// Start sendmail
		$fp = @popen($this->sendmail_path . " -oi -t -d", 'w');

		// Check if sendmail is not
		if ($fp === FALSE OR $fp === NULL) {
			// server probably has popen disabled, so nothing we can do to get a verbose error.
			$return = false;
			$this->_debug_message('Could not use popen, are you sure the function is enabled?', 'error');
		} else {
			// Combine the headers and message to be sent...
			fputs($fp, $this->_headers . $this->_message);

			// Get the status
			$status = pclose($fp);

			// Send an error if the email failed
			if ($status != 0) {
				$return = false;
				$this->_debug_message('Could not send email with sendmail. Exited with status code ' . $status . '.', 'error');
			}
		}
		$this->_debug_message($return ? "Happy" : "sad");
		// True if no errors, false if errors
		return $return;

	}

}
?>
