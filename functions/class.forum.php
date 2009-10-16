<?php
/**
 * Forum functions class.
 * @class Forum
 */

class Forum {

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
		while($row = mysql_fetch_array($result)) {
			$query_title = strtolower(trim($row['title']));
			if($title == $query_title)
				$id_topic = $row['id_topic'];
		}
		return $id_topic;
	}

}


?>
