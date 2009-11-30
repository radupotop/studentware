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

	/**
	 * Add a new user.
	 *
	 * @param int $idGroup
	 * @param string $firstName
	 * @param string $famName
	 * @param string $email
	 * @param string $pass
	 * @param string $about
	 *
	 * @return int $idUser - id of added user
	 */
	function addUser($idGroup=int, $firstName, $famName, $email, $pass, $about=null) {
		// check if user exists
		if($idUser = $this->getUserId($email))
			return $idUser;

		$pass = hash('sha1', $pass);
		$query = sprintf(
			'insert into users values (null, %s, "%s", "%s", "%s", "%s", "%s")',
			$idGroup, esc($firstName), esc($famName), esc($email), $pass,
			esc($about)
		);
		$result = mysql_query($query);
		queryCount();

		// check again if user exists and return its ID
		if($result)
			if($idUser = $this->getUserId($email))
				_log('users: added user with id='.$idUser);
		return $idUser;
	}
}
?>
