<?php
function mailingList() {
	global $mailing_list;

	$mlRead = new mlRead (
		$mailing_list['email'],
		$mailing_list['mbox']['server'],
		$mailing_list['mbox']['param'],
		$mailing_list['user'],
		$mailing_list['pass']
	);

	$mlSend = new mlSend (
		$mailing_list['email'],
		$mailing_list['smtp']['server'],
		$mailing_list['smtp']['port'],
		$mailing_list['smtp']['crypto'],
		$mailing_list['user'],
		$mailing_list['pass']
	);

	$addrArray = $mlRead->addrArray();
	$msgArray = $mlRead->msgArray();

	$mlSend->dist($addrArray, $msgArray);

	// post to forum
	$forum = new ForumInput;
	$posts = $mlRead->msgToPost();
	if($posts)
		foreach($posts as $post) {
			$idTopic = $forum->addTopic($post['id_user'], $post['title']);
			$forum->addPost($idTopic, $post['id_user'], $post['body']);
			$forum->updateTopic($idTopic);
		}


	$mlRead->delete();
	return;
}
?>
