<?php
/**
 * Parse MIME messages and return them in an usable form.
 * @class mimeParser
 */

class mimeParser {
	public $conn;

	/**
	 * @param resource $conn - imap or pop3 connection from where to read messages
	 */
	function __construct($conn=resource) {
		$this->conn = $conn;
	}
}
?>
