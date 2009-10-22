<?php
class UsersInput {

	/**
	 * Identify user by id or email.
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
			$id = $row['email'];
		} else {
			// input email, output id
			$user = strtolower(trim($user));
			$result = mysql_query ('select * from users');
			queryCount();

			while($row = mysql_fetch_array($result)) {
				$email = strtolower(trim($row['email']));
				if($user == $email) {
					$id = $row['id_user'];
					break;
				}
			}
		}

		return $id;
	}

}
?>
