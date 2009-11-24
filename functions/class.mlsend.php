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
	 * @param array $addrArray
	 * @param array $msgArray
	 */
	function dist($addrArray, $msgArray) {
		if($msgArray)
			foreach ($msgArray as $message) {
				// do not send NOMAIL messages
				if(!preg_match('/\[NOMAIL]/', $message['subject'])) {
					$message['subject'] =
						str_replace('[NOPOST] ', null, $message['subject']);
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
			}
		return;
	}

	function __destruct() {
		unset($this->smtp);
	}
}
?>
