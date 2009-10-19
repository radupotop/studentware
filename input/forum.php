<?php
/**
 * @file
 * Input forum.
 */
	$topic['id'] =
		filter_input(INPUT_GET, 'topic', FILTER_VALIDATE_INT); // topic number
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
	global $topic, $html_filter, $forum;

	$post['add']['body'] =
		$html_filter->process($_POST['post']['add']['body']);
	$post['add']['submit'] =
		$_POST['post']['add']['submit'];

	if ($_SESSION['login']
	&& $post['add']['body']
	&& $post['add']['submit']) {
		$forum->addPost($topic['id'], $_SESSION['id_user'], esc($post['add']['body']));
		$forum->updateTopic($topic['id']);
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
	}
	return;
}
input_topic_edit();

/**
 * Input topic add.
 * @return null
 */
function input_topic_add() {
	global $html_filter;

	$topic['add']['title'] =
		filter_var($_POST['topic']['add']['title'], FILTER_UNSAFE_RAW);
	$topic['add']['body'] =
		$html_filter->process($_POST['topic']['add']['body']);
	$topic['add']['submit'] =
		$_POST['topic']['add']['submit'];

	if($topic['add']['title']
	&& $topic['add']['body']
	&& $topic['add']['submit']) {
		// create topic
		mysql_query (
			'insert into topics
			values (
				null,'.
				$_SESSION['id_user'].',
				NOW(),
				"'.esc($topic['add']['title']).'"
			)'
		);
		// select created topic
		$result = mysql_query (
			'select id_topic
			from topics
			where title="'.$topic['add']['title'].'"'
		);
		$row = mysql_fetch_array($result);
		// insert first post into topic
		mysql_query (
			'insert into posts
			values (
				null,'.
				$row['id_topic'].','.
				$_SESSION['id_user'].',
				NOW(),
				"'.esc($topic['add']['body']).'"
			)'
		);
		// redirect to newly created topic
		header('Location: ?p='.$_GET['p'].'&topic='.$row['id_topic']);
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
		// check if topic contains more posts
		$result = mysql_query (
			'select *
			from posts
			where id_topic='.$topic['id']
		);
		$row = mysql_fetch_array($result);
		// delete if topic is empty
		if ($row == false) {
			mysql_query (
				'delete from topics
				where id_topic='.$topic['id']
			);
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
		// and also delete posts from that topic
		mysql_query (
			'delete from posts
			where id_topic='.$topic['delete']['req']
		);
		// redirect to list of topics
		header('Location: ?p='.$_GET['p']);
	}
	return;
}
input_topic_delete();

?>
