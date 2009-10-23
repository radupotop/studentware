<?php
class UsersInput {

	/**
	 * Get user ID from email address.
	 *
	 * @param string $email
	 * @return int $id
	 */
	function getUserId($email) {
		$result = mysql_query(
			'select id_user
			from users
			where lower(trim(email))="'.strtolower(trim($email)).'"'
		);
		queryCount();
		$row = mysql_fetch_array($result);
		if ($row)
			$id = $row['id_user'];
		return $id;
	}

	/**
	 * Get email address from user ID.
	 *
	 * @param int $id
	 * @return string $email
	 */
	function getUserEmail($id) {
		$result = mysql_query(
			'select email
			from users
			where id_user='.$id
		);
		queryCount();
		$row = mysql_fetch_array($result);
		if ($row)
			$email = $row['email'];
		return $email;
	}

}
?>
