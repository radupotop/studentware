<?php
/**
 * Forum functions class.
 * @class ForumInput
 */

class ForumInput {

	/**
	 * Get id of topic with given title.
	 * Also used to verify if topic exists.
	 *
	 * @param string $title
	 * @return int $id_topic
	 */
	function idTopic($title) {
		$title = strtolower(trim($title));
		$result = mysql_query('select * from topics');
		queryCount();
		while($row = mysql_fetch_array($result)) {
			$query_title = strtolower(trim($row['title']));
			if($title == $query_title)
				$id_topic = $row['id_topic'];
		}
		return $id_topic;
	}

	/**
	 * Add post to topic.
	 *
	 * @param int $id_topic
	 * @param int $id_user
	 * @param string $body
	 * @return int $id_post
	 */
	function addPost($id_topic, $id_user, $body) {
		$result = mysql_query (
			'insert into posts values (
				null,'.
				$id_topic.','.
				$id_user.',
				NOW(),
				"'.$body.'"
			)'
		);
		queryCount();
		if ($result) {
			$result = mysql_query (
				'select id_post
				from posts
				where id_topic='.$id_topic.' and id_user='.$id_user.'
				order by id_post desc
				limit 0,1'
			);
			queryCount();
			$row = mysql_fetch_array($result);
			$id_post = $row[0];
			if ($id_post) {
				_log('forum: added post with id='.$id_post);
				return $id_post;
			}
		}
		return false;
	}

	/**
	 * Update date of given topic.
	 * @param int $id_topic
	 */
	function updateTopic($id_topic) {
		$result = mysql_query(
			'update topics
			set date_modified=NOW()
			where id_topic='.$id_topic
		);
		queryCount();
		if($result)
			return true;
		else
			return false;
	}

}


?>
