<?php
/**
 * @file
 * Input forum.
 */
	$topic = filter_input(INPUT_GET, 'topic', FILTER_VALIDATE_INT);
	$html_filter = new InputFilter($tags['forum']);

/**
 * Input posts add.
 * @return null
 */
function input_posts_add() {
	$posts_add = $_POST['reply'];
	if($_SESSION['login'] && $posts_add) {
		global $topic;
		global $html_filter;

		$post = $_POST['post'];
		$post = $html_filter->process($post);

		if($post) {
			mysql_query(
				'insert into posts
				values (null, ' . $topic . ', ' . $_SESSION['id_user'] . ', "' .
				Date::to_sql('now') . '", "' . $post . '")'
			);
			mysql_query(
				'update topics
				set date_modified="' . Date::to_sql('now') . '"
				where id_topic=' . $topic
			);
		}
	}
	return;
}
input_posts_add();


?>
