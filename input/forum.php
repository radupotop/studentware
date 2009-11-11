<?php
/**
 * @file
 * Input forum.
 */
	$topic['id'] =
		filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // topic number
	$topic['add']['req'] =
		$_POST['topic']['add']['req'];
	$topic['edit']['req'] =
		filter_var($_POST['topic']['edit']['req'], FILTER_VALIDATE_INT);

	$post['add']['submit'] =
		$_POST['post']['add']['submit'];
	$post['edit']['req'] =
		filter_var($_POST['post']['edit']['req'], FILTER_VALIDATE_INT);

	$html_filter = new InputFilter($tags, $attr);
	$forum = new ForumInput();

/**
 * Input posts add.
 * @return null
 */
function input_post_add() {
	global $topic, $html_filter, $forum, $mailing_list;

	$post['add']['body'] =
		$html_filter->process($_POST['post']['add']['body']);
	$post['add']['submit'] =
		$_POST['post']['add']['submit'];

	if ($_SESSION['login']
	&& $post['add']['body']
	&& $post['add']['submit']) {

		$forum->addPost($topic['id'], $_SESSION['id_user'],
			esc($post['add']['body']));
		$forum->updateTopic($topic['id']);

		// also send to ml
		if($mailing_list['enabled']) {
			$subject = $forum->getTopicTitle($topic['id']);

			$mlSend = new mlSend (
				$mailing_list['email'],
				$mailing_list['smtp']['server'],
				$mailing_list['smtp']['port'],
				$mailing_list['smtp']['crypto'],
				$mailing_list['user'],
				$mailing_list['pass']
			);
			$mlSend->internal(
				$_SESSION['first_name'].' '.$_SESSION['fam_name'],
				$_SESSION['email'],
				$subject,
				$post['add']['body'],
				'nopost'
			);
			unset($mlSend);
		}
	}
	return;
}
input_post_add();

/**
 * Input post edit.
 * @return null
 */
function input_post_edit() {
	global $html_filter;

	$post['edit']['body'] =
		$html_filter->process($_POST['post']['edit']['body']);
	$post['edit']['submit'] =
		filter_var($_POST['post']['edit']['submit'], FILTER_VALIDATE_INT);

	if($_SESSION['login']
	&& $post['edit']['body']
	&& $post['edit']['submit']) {
		$edit_tag = '<p><em>Edited by '.$_SESSION['first_name'].' '.
			$_SESSION['fam_name'].' on '.Date::from_sql('now').'</em></p>';
		mysql_query(
			'update posts set
			body="'.esc($post['edit']['body']).$edit_tag.'"
			where id_post='.$post['edit']['submit']
		);
		queryCount();
	}
	return;
}
input_post_edit();

/**
 * Input topic edit
 * @return null
 */
function input_topic_edit() {
	$topic['edit']['title'] =
		filter_var($_POST['topic']['edit']['title'], FILTER_UNSAFE_RAW);
	$topic['edit']['submit'] =
		filter_var($_POST['topic']['edit']['submit'], FILTER_VALIDATE_INT);
	if ($_SESSION['login']
	&& $topic['edit']['title']
	&& $topic['edit']['submit']) {
		mysql_query (
			'update topics set
			title="'.esc($topic['edit']['title']).'"
			where id_topic='.$topic['edit']['submit']
		);
		queryCount();
	}
	return;
}
input_topic_edit();

/**
 * Input topic add.
 * @return null
 */
function input_topic_add() {
	global $topic, $html_filter, $forum, $mailing_list;

	$topic['add']['title'] =
		filter_var($_POST['topic']['add']['title'], FILTER_UNSAFE_RAW);
	$topic['add']['body'] =
		$html_filter->process($_POST['topic']['add']['body']);
	$topic['add']['submit'] =
		$_POST['topic']['add']['submit'];

	if($topic['add']['title']
	&& $topic['add']['body']
	&& $topic['add']['submit']) {

		$id_topic =
			$forum->addTopic($_SESSION['id_user'], $topic['add']['title']);

		$forum->addPost($id_topic, $_SESSION['id_user'],
			esc($topic['add']['body']));

		// also send to ml
		if($mailing_list['enabled']) {
			$mlSend = new mlSend (
				$mailing_list['email'],
				$mailing_list['smtp']['server'],
				$mailing_list['smtp']['port'],
				$mailing_list['smtp']['crypto'],
				$mailing_list['user'],
				$mailing_list['pass']
			);
			$mlSend->internal(
				$_SESSION['first_name'].' '.$_SESSION['fam_name'],
				$_SESSION['email'],
				$topic['add']['title'],
				$topic['add']['body'],
				'nopost'
			);
			unset($mlSend);
		}


		// redirect to newly created topic
		header('Location: ?p='.$_GET['p'].'&id='.$id_topic);
	}
	return;
}
input_topic_add();

/**
 * Input post delete
 * @return null
 */
function input_post_delete() {
	global $topic;
	$post['delete']['req'] =
		filter_var($_POST['post']['delete']['req'], FILTER_VALIDATE_INT);
	if ($_SESSION['login'] && $post['delete']['req']) {
		// delete post
		mysql_query (
			'delete from posts
			where id_post='.$post['delete']['req']
		);
		queryCount();
		// check if topic contains more posts
		$result = mysql_query (
			'select *
			from posts
			where id_topic='.$topic['id']
		);
		queryCount();
		$row = mysql_fetch_array($result);
		// delete if topic is empty
		if ($row == false) {
			mysql_query (
				'delete from topics
				where id_topic='.$topic['id']
			);
			queryCount();
			// redirect to list of topics
			header('Location: ?p='.$_GET['p']);
		}
	}
	return;
}
input_post_delete();


/**
 * Input post delete.
 * @return null
 */
function input_topic_delete() {
	$topic['delete']['req'] =
		filter_var($_POST['topic']['delete']['req'], FILTER_VALIDATE_INT);
	if ($_SESSION['login'] && $topic['delete']['req']) {
		// delete topics
		mysql_query (
			'delete from topics
			where id_topic='.$topic['delete']['req']
		);
		queryCount();
		// and also delete posts from that topic
		mysql_query (
			'delete from posts
			where id_topic='.$topic['delete']['req']
		);
		queryCount();
		// redirect to list of topics
		header('Location: ?p='.$_GET['p']);
	}
	return;
}
input_topic_delete();

?>
