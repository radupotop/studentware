<?php
/**
 * @file
 * Input forum.
 */
	$topic['id'] =
		filter_input(INPUT_GET, 'topic', FILTER_VALIDATE_INT); // topic number
	$topic['add']['req'] =
		$_POST['topic']['add']['req'];
	$html_filter = new InputFilter($tags, $attr);

/**
 * Input posts add.
 * @return null
 */
function input_post_add() {
	global $topic, $html_filter;

	$post['add']['body'] =
		$html_filter->process($_POST['post']['add']['body']);
	$post['add']['submit'] =
		$_POST['post']['add']['submit'];

	if ($_SESSION['login']
	&& $post['add']['body']
	&& $post['add']['submit']) {
		mysql_query (
			'insert into posts
			values (
				null,'.
				$topic['id'].','.
				$_SESSION['id_user'].',
				"'.Date::to_sql('now').'",
				"'.esc($post['add']['body']).'"
			)'
		);
		mysql_query(
			'update topics
			set date_modified="' . Date::to_sql('now') . '"
			where id_topic=' . $topic['id']
		);
	}
	return;
}
input_post_add();


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
				"'.Date::to_sql('now').'",
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
				"'.Date::to_sql('now').'",
				"'.esc($topic['add']['body']).'"
			)'
		);
	}
	return;
}
input_topic_add();

?>
