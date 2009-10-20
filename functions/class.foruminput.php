<?php
/**
 * Forum functions class.
 * @class ForumInput
 */

class ForumInput {

	/**
	 * Identify topic.
	 * Find ID of topic from title.
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
			if($title == $query_title) {
				$id_topic = $row['id_topic'];
				break;
			}
		}
		return $id_topic;
	}

	/**
	 * Identify user.
	 * Find ID of user from email address.
	 *
	 * @param string $addr
	 * @return int $id_user
	 */
	function idUser($addr) {
		$addr = strtolower(trim($addr));
		$result = mysql_query ('select * from users');
		queryCount();

		while($row = mysql_fetch_array($result)) {
			$query_addr = strtolower(trim($row['email']));
			if($addr == $query_addr) {
				$id_user = $row['id_user'];
				break;
			}
		}

		return $id_user;
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
			$id_topic = $this->idTopic($id_topic);

		if(!is_numeric($id_user))
			$id_user = $this->idUser($id_user);

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
			if ($id_post) {
				_log('forum: added post with id='.$id_post);
				return $id_post;
			}
		} else
			return false;
	}

	/**
	 * Update date of given topic.
	 * @param string $id_topic - can be an id or a topic title
	 */
	function updateTopic($id_topic) {
		if(!is_numeric($id_topic))
			$id_topic = $this->idTopic($id_topic);

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
		if(!is_numeric($id_user))
			$id_user = $this->idUser($id_user);

		$result = mysql_query (
			'insert into topics values(
				null,
				'.$id_user.',
				NOW(),
				"'.$title.'"
			)'
		);
		queryCount();

		// select id topic
		if($result) {
			$result = mysql_query(
				'select id_topic
				from topics
				where id_user='.$id_user.' and title="'.$title.'"
				order by id_topic desc
				limit 0,1'
			);
			queryCount();
			$row = mysql_fetch_array($result);
			$id_topic = $row['id_topic'];
			if ($id_topic) {
				_log('forum: added topic with id='.$id_topic);
				return $id_topic;
			}
		} else
			return false;
	}

}
?>
