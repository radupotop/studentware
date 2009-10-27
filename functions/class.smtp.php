<?php
/**
 * Send messages using a local or remote SMTP server.
 * It supports TLS and SSL crypto.
 * @class Smtp
 */
class Smtp {
	public $server;
	public $port = '25';
	public $crypto; // can be null, ssl, tls
	public $username;
	public $password;
	public $timeout = '45';

	private $localhost = 'localhost';
	private $nl = "\r\n";
	private $conn;

	/**
	 * Connect and Auth to server.
	 */
	private function __construct() {
		$this->connect();
		$this->auth();
	}

	/**
	 * Connect to server.
	 */
	private function connect() {
		$this->crypto = strtolower(trim($this->crypto));
		if($this->crypto == 'ssl')
			$this->server = 'ssl://' . $this->server;
		$this->conn = fsockopen(
			$this->server, $this->port, $errno, $errstr, $this->timeout
		);
		return;
	}

	/**
	 * Auth.
	 */
	private function auth() {
		fputs($this->conn, 'HELO ' . $this->localhost . $this->nl);
		if($this->crypto == 'tls') {
			fputs($this->conn, 'STARTTLS' . $this->nl);
			stream_socket_enable_crypto(
				$this->conn, true, STREAM_CRYPTO_METHOD_TLS_CLIENT
			);
			fputs($this->conn, 'HELO ' . $this->localhost . $this->nl);
		}
		fputs($this->conn, 'AUTH LOGIN' . $this->nl);
		fputs($this->conn, base64_encode($this->username) . $this->nl);
		fputs($this->conn, base64_encode($this->password) . $this->nl);
		return;
	}

	/**
	 * Send an email.
	 */
	function send($from, $to, $subject, $message, $headers=null) {
		fputs($this->conn, 'MAIL FROM: <'. $from .'>'. $this->nl);
		fputs($this->conn, 'RCPT TO: <'. $to .'>'. $this->nl);
		fputs($this->conn, 'DATA'. $this->nl);
		fputs($this->conn,
			'From: '. $from .$this->nl.
			'To: '. $to .$this->nl.
			'Subject: '. $subject .$this->nl.
			$headers .$this->nl.
			$this->nl.
			$message . $this->nl.
			'.' .$this->nl
		);
		return;
	}

	/**
	 * Quit and disconnect.
	 */
	private function __destruct() {
		fputs($this->conn, 'QUIT' . $this->nl);
		fclose($this->conn);
	}
}

?>
