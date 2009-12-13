<?php
/**
 * Session handling class.
 * @class Session
 */
class Session {

	function __construct() {
		session_name('Studentware');
		session_start();
	}

	/**
	 * Login. Set session global variables with user's data.
	 *
	 * @param string $email
	 * @param string $pass
	 * @return bool $status - true if login was successful, false if not.
	 */
	function login($email, $pass) {
		$pass = hash('sha1', $pass);
		$query = sprintf('select * from users where email="%s" and pass="%s"',
			esc($email), esc($pass));
		$result = mysql_query($query);
		queryCount();
		$row = mysql_fetch_assoc($result);
		if ($row) {
			$_SESSION['login'] = true;
			$_SESSION['id_user'] = $row['id_user'];
			$_SESSION['id_group'] = $row['id_group'];
			$_SESSION['first_name'] = $row['first_name'];
			$_SESSION['fam_name'] = $row['fam_name'];
			$_SESSION['email'] = $row['email'];
			$status = true;
		} else
			$status = false;
		return $status;
	}

	/**
	 * Logout. Unset session global variables.
	 */
	function logout() {
		unset($_SESSION);
		setcookie(session_name(), '', 0, '/');
		session_destroy();
		return;
	}

	/**
	 * Update session cookie with latest user info.
	 */
	function update($idGroup=null, $firstName=null, $famName=null, $email=null){
		if($idGroup)
			$_SESSION['id_group'] = $idGroup;
		if($firstName)
			$_SESSION['first_name'] = $firstName;
		if($famName)
			$_SESSION['fam_name'] = $famName;
		if($email)
			$_SESSION['email'] = $email;
		return;
	}
}
?>
