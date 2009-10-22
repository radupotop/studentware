<?php
class UsersInput {

	/**
	 * Identify user by id or email.
	 * Can be used to verify if user exists.
	 *
	 * Input id - get email.
	 * or:
	 * Input email - get id.
	 *
	 * @param string $user
	 * @return string $id
	 */
	function identifyUser($user) {
		// input id, output email
		if(is_numeric($user)) {
			$result = mysql_query(
				'select email
				from users
				where id_user='.$user
			);
			queryCount();
			$row = mysql_fetch_array($result);
			if ($row)
				$id = $row['email'];
		} else {
			// input email, output id
			$result = mysql_query(
				'select id_user
				from users
				where lower(trim(email))='.strtolower(trim($user))
			);
			queryCount();
			$row = mysql_fetch_array($result);
			if ($row)
				$id = $row['id_user'];
		}
		return $id;
	}

}
?>
