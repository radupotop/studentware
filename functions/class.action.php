<?php
/**
 * Add, edit, delete: users, topics, etc.
 * @class Action
 */
class Action {

	/***************************************************************************
	 * Add posts.
	 * @return null
	 */
	function posts_add() {
		$post = $_POST['post'];
		$reply = $_POST['reply'];

		global $topic;
		global $html_filter;

		$post = $html_filter->process($post);

		if($reply && $post) {
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
			header('Location: ' . current_page());
		}
	return;
	}


} // end class.
?>
