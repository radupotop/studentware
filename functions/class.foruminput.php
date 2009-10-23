<?php
/**
 * Forum functions class.
 * @class ForumInput
 */

class ForumInput {

	/**
	 * Get topic ID from title.
	 *
	 * @param string $title
	 * @return int @id
	 */
	function getTopicId($title) {
		$result = mysql_query(
			'select id_topic
			from topics
			where lower(trim(title))="'.strtolower(trim($title)).'"'
		);
		queryCount();
		$row = mysql_fetch_array($result);
		if ($row)
			$id = $row['id_topic'];
		return $id;
	}

	/**
	 * Get topic title from ID.
	 *
	 * @param int $id
	 * @return string $title
	 */
	function getTopicTitle($id) {
		$result = mysql_query(
			'select title
			from topics
			where id_topic='.$id
		);
		queryCount();
		$row = mysql_fetch_array($result);
		if ($row)
			$title = $row['title'];
		return $title;
	}

	/**
	 * Add post to topic.
	 *
	 * @param string $id_topic
	 * @param string $id_user
	 * @param string $body
	 * @return int $id_post
	 */
	function addPost($id_topic, $id_user, $body) {
		if(!is_numeric($id_topic))
			$id_topic = $this->getTopicId($id_topic);

		if(!is_numeric($id_user)) {
			$users = new UsersInput();
			$id_user = $users->getUserId($id_user);
		}

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
		// select id_post
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
			$id_post = $row['id_post'];
			if ($id_post)
				_log('forum: added post with id='.$id_post);
		}
		return $id_post;
	}

	/**
	 * Update date of given topic.
	 * @param string $id_topic - can be an id or a topic title
	 */
	function updateTopic($id_topic) {
		if(!is_numeric($id_topic))
			$id_topic = $this->getTopicId($id_topic);

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

	/**
	 * Add topic.
	 * @param string $id_user
	 * @param string $title
	 * @return int $id_topic
	 */
	function addTopic($id_user, $title) {
		//check if topic exists
		if($id_topic = $this->getTopicId($title))
			return $id_topic;

		if(!is_numeric($id_user)) {
			$users = new UsersInput();
			$id_user = $users->getUserId($id_user);
		}

		$result = mysql_query (
			'insert into topics values(
				null,
				'.$id_user.',
				NOW(),
				"'.$title.'"
			)'
		);
		queryCount();

		//check again if topic exists and return its ID
		if($result)
			if ($id_topic = $this->getTopicId($title))
				_log('forum: added topic with id='.$id_topic);
		return $id_topic;
	}

}
?>
