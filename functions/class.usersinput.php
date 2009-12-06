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
	 * Get details of an user, or of all users.
	 *
	 * @param int $id - id of user, if none is specified get all users.
	 * @return array $users - a numeric array with users' details.
	 */
	function viewUser($id='%') {
		$query = sprintf('select * from users where id_user like "%s"', $id);
		$result = mysql_query($query);
		queryCount();
		while($row = mysql_fetch_assoc($result))
			$users[$row['id_user']] = $row;
		return $users;
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

	/**
	 * Edit a user's details.
	 */
	function editUser($idUser=int, $idGroup=null, $firstName=null,
	$famName=null, $email=null, $pass=null, $about=null) {

		$query = 'update users set ';
		if($idGroup)
			$query .= sprintf('id_group = %s, ', $idGroup);
		if($firstName)
			$query .= sprintf('first_name = "%s", ', esc($firstName));
		if($famName)
			$query .= sprintf('fam_name = "%s", ', esc($famName));
		if($email)
			$query .= sprintf('email = "%s", ', esc($email));
		if($pass) {
			$pass = hash('sha1', $pass);
			$query .= sprintf('pass = "%s", ', $pass);
		}
		if($about)
			$query .= sprintf('about = "%s", ', esc($about));
		// strip the last ', '
		$query = rtrim($query, ', ');
		$query .= ' where id_user = '.$idUser;

		$status = mysql_query($query);
		queryCount();
		if ($status)
			_log('users: edited user with id='.$idUser);
		return $status;
	}

	/**
	 * Delete a user.
	 */
	function deleteUser($idUser=int) {
		// do not allow deletion of id_user = 1
		if($idUser == 1)
			return false;
		$query = 'delete from users where id_user = '.$idUser;
		$status = mysql_query($query);
		queryCount();
		if ($status)
			_log('users: deleted user with id='.$idUser);
		return $status;
	}
}
?>
