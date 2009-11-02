<?php
/**
 * Send messages using a local or remote SMTP server.
 * It supports TLS and SSL crypto.
 * @class Smtp
 * @author wooptoo, http://wooptoo.com
 * @license BSD
 */
class Smtp {
	public $server;
	public $port;
	public $crypto;
	public $user;
	public $pass;

	private $timeout = '45';
	private $localhost = 'localhost';
	private $nl = "\r\n";
	private $conn;

	/**
	 * Connect and Auth to server.
	 *
	 * @param string $server - remote server address or 'localhost'
	 * @param int $port
	 * @param string $crypto - can be null, ssl, tls
	 * @param string $user - optional for localhost server
	 * @param string $pass - optional for localhost server
	 */
	function __construct($server, $port, $crypto=null, $user=null, $pass=null) {
		$this->server = $server;
		$this->port = $port;
		$this->crypto = $crypto;
		$this->user = $user;
		$this->pass = $pass;

		$this->connect();
		$this->auth();
	}

	/**
	 * Connect to server.
	 */
	function connect() {
		$this->crypto = strtolower(trim($this->crypto));
		$this->server = strtolower(trim($this->server));

		if($this->crypto == 'ssl')
			$this->server = 'ssl://' . $this->server;
		$this->conn = fsockopen(
			$this->server, $this->port, $errno, $errstr, $this->timeout
		);
		fgets($this->conn);
		return;
	}

	/**
	 * Auth.
	 */
	function auth() {
		fputs($this->conn, 'HELO ' . $this->localhost . $this->nl);
		fgets($this->conn);
		if($this->crypto == 'tls') {
			fputs($this->conn, 'STARTTLS' . $this->nl);
			fgets($this->conn);
			stream_socket_enable_crypto(
				$this->conn, true, STREAM_CRYPTO_METHOD_TLS_CLIENT
			);
			fputs($this->conn, 'HELO ' . $this->localhost . $this->nl);
			fgets($this->conn);
		}
		if($this->server != 'localhost') {
			fputs($this->conn, 'AUTH LOGIN' . $this->nl);
			fgets($this->conn);
			fputs($this->conn, base64_encode($this->user) . $this->nl);
			fgets($this->conn);
			fputs($this->conn, base64_encode($this->pass) . $this->nl);
			fgets($this->conn);
		}
		return;
	}

	/**
	 * Send an email.
	 *
	 * @param string $from
	 * @param array  $to
	 * @param string $subject
	 * @param string $message
	 * @param string $headers - optional
	 */
	function send($from, $to=array(), $subject, $message, $headers=null) {
		fputs($this->conn, 'MAIL FROM: <'. $from .'>'. $this->nl);
		fgets($this->conn);

		// multiple receipts
		foreach($to as $rcpt) {
			fputs($this->conn, 'RCPT TO: <'. $rcpt .'>'. $this->nl);
			fgets($this->conn);
		}
		fputs($this->conn, 'DATA'. $this->nl);
		fgets($this->conn);
		fputs($this->conn,
			'Subject: '. $subject .$this->nl.
			$headers .$this->nl.
			$this->nl.
			$message . $this->nl.
			'.' .$this->nl
		);
		fgets($this->conn);
		return;
	}

	/**
	 * Quit and disconnect.
	 */
	function __destruct() {
		fputs($this->conn, 'QUIT' . $this->nl);
		fgets($this->conn);
		fclose($this->conn);
	}
}

?>
