<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Driver for sending with mail
 * Based heavily on the code from the Email class in Codeigniter.
 */
class Dmail_mail extends CI_Driver {

	/**
	 * Used to send an email using mail function of php.
	 * @return boolean True if successful, false if not.
	 */
	public function send() {
		$return = false;
		$to = !$this->_bcc_batch_running ? implode(', ', $this->_sanitize_emails($this->recipients)) : '';
		$subject = $this->_prep_q_encoding($this->subject);
		$message = $this->_message;
		$headers = $this->_headers;
		$sender = $this->_clean_email($this->sender);
		if ($this->safe_mode == TRUE && mail($to, $subject, $message, $headers)) {
			$return = true;
		} else if (mail($to, $subject, $message, $headers, "-f " . $sender)) {
			// most documentation of sendmail using the "-f" flag lacks a space after it, however
			// we've encountered servers that seem to require it to be in place.
			$return = true;
		}
		return $return;
	}

}

?>
