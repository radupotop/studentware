<?php
/**
 * Send emails to users.
 * @class mlSend
 */

class mlSend {
	public $mlEmail;
	private $smtp;

	/**
	 * Connect to SMTP server.
	 *
	 * @param string $mlEmail - mailing list email address
	 * @param string $server - remote server address or 'localhost'
	 * @param int $port
	 * @param string $crypto - can be null, ssl, tls
	 * @param string $user - optional for localhost server
	 * @param string $pass - optional for localhost server
	 */
	function __construct($mlEmail, $server, $port, $crypto, $user, $pass) {
		$this->mlEmail = $mlEmail;
		$this->smtp = new Smtp($server, $port, $crypto, $user, $pass);
	}

	/**
	 * Distribute:
	 * Sends emails to ml subscribers.
	 */
	function dist($addrArray, $msgArray) {
		if($msgArray)
			foreach ($msgArray as $message) {
				$to = $addrArray;

				// remove sender and ml from receipts
				foreach($to as $key => $toAddr) {
					if (
						$toAddr == $message['from'] ||
						$toAddr == $this->mlEmail
					) {
						unset($to[$key]);
					}
				}

				// send to remaining receipts
				if ($to)
					$this->smtp->send(
						$this->mlEmail,
						$to,
						$message['subject'],
						$message['body'],
						$message['headers']
					);
			}
		return;
	}

	/**
	 * Internal send, eg: from forum to ml.
	 *
	 * @param string $userName - name of user that sent the email
	 * @param string $subject
	 * @param string $body
	 */
	function internal($userName, $subject, $body) {
		global $app;

		$boundary = 'Studentware-'.sha1(time() + rand());
		$headers =
			'X-Mailer: Studentware '.$app['ver']."\r\n".
			'From: '.$userName.' <'.$this->mlEmail.'>'."\r\n".
			'To: '.$this->mlEmail."\r\n".
			'MIME-Version: 1.0'."\r\n".
			'Content-Type: multipart/alternative; boundary="'.$boundary.'"'.
			"\r\n"
		;

		$body =
			'--'.$boundary."\r\n".
			'Content-Type: text/plain; charset=utf-8'."\r\n".
			"\r\n".
			strip_tags($body)."\r\n".
			'--'.$boundary."\r\n".
			'Content-Type: text/html; charset=utf-8'."\r\n".
			"\r\n".
			$body."\r\n".
			'--'.$boundary.'--'."\r\n"
		;

		$subject = '[NOPOST] ' . $subject;

		$this->smtp->send(
			$this->mlEmail,
			array($this->mlEmail),
			$subject,
			$body,
			$headers
		);
		return;
	}

	function __destruct() {
		unset($this->smtp);
	}
}
?>
