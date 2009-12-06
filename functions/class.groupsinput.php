<?php
/**
 * Group input class
 * @class GroupsInput
 */
class GroupsInput {
	/**
	 * Get group ID from title.
	 *
	 * @param string $title
	 * @return int $id
	 */
	function getGroupId($title) {
		$query = sprintf(
			'select id_group from groups
			where lower(trim(title))="%s"',
			strtolower(trim($title)));
		$result = mysql_query($query);
		queryCount();
		$row = mysql_fetch_assoc($result);
		if($row)
			$id = $row['id_group'];
		return $id;
	}

	function viewGroup($id='%') {
		$query = sprintf('select * from groups where id_group like "%s"', $id);
		$result = mysql_query($query);
		queryCount();
		while($row = mysql_fetch_assoc($result))
			$groups[$row['id_group']] = $row;
		return $groups;
	}
}
?>
