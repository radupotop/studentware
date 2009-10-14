<?php
/**
 * @file
 * Simple mailing list for Studentware.
 */
include('../config.php');
include('functions.php');

/**
 * Send emails to all users
 * @param null
 * @return null
 */
function mailing_list() {
	global $mailing_list;

	// Connect to IMAP
	$conn = imap_open (
		'{'.$mailing_list['server'].$mailing_list['param'].'}Inbox',
		$mailing_list['user'],
		$mailing_list['pass']
	);

	// Put all emails in an array
	$result = mysql_query('select email from users');
	$num_rows = mysql_num_rows($result);
	for($i=0; $i<$num_rows ;$i++) {
		$row = mysql_fetch_array($result);
		$emails[$i] = $row[0];
	}

	$headers = imap_headers($conn);
	$num_emails = sizeof($headers);

	// Parse each email
	for ($i = 1; $i < $num_emails+1; $i++) {
		$mail_header = imap_headerinfo($conn, $i);
		// $from is an object
		$from = $mail_header->from[0];
		$subject = esc($mail_header->subject);
		$subject = preg_replace('/^[Re: ?]+/i', '', $subject);

		$body = strip_tags(imap_body($conn, $i));

		$from_email = $from->mailbox.'@'.$from->host;

		// Anti-spam. Do not allow users that are not registered to send emails
		if (in_array($from_email, $emails)) {

			// Get id of user that sent email
			$result = mysql_query('
				select id_user from users where email="'.$from_email.'";
			');
			$row = mysql_fetch_array($result);
			$id_user = $row[0];

			// Select the topic that has the same subject as the email
			$result = mysql_query('
				select * from topics where title="'.$subject.'"
			');
			$row = mysql_fetch_array($result);

			if ($row) {
				// found topic, make post

				make_post($id_user, $body, $subject);

				// Email users (Re: )
				foreach($emails as $email) {
					// Send to all except original sender
					if ($email != $from_email) {
						imap_mail($email, 'Re: '.$subject, $body);
					}
				}

			} else {
				// create topic & make post

				mysql_query ('
					insert into topics values (
						null,
						'.$id_user.',
						NOW(),
						"'.$subject.'"
					);
				');

				make_post($id_user, $body, $subject);

				// Email users
				foreach($emails as $email) {
					// Send to all except original sender
					if ($email != $from_email) {
						imap_mail($email, $subject, $body);
					}
				}
			}
		}
		// Mark email for deletion
		imap_delete($conn, $i);
	}
	// Delete all marked emails
	imap_expunge($conn);

	// Close connection
	imap_close($conn);
	return;
}

function make_post($id_user, $body, $subject) {
	$result = mysql_query ('
		select id_topic from topics where title="'.$subject.'"
	');
	$row = mysql_fetch_array($result);
	$id_topic=$row[0];

	mysql_query('
		insert into posts values (
			null,
			'.$id_topic.',
			'.$id_user.',
			NOW(),
			"'.esc($body).'"
		);
	');

	return;
}

if ($mailing_list['enabled']) {
	mailing_list();
}
?>
