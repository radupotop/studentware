<?php
/**
 * Add, edit, delete: users, topics, etc.
 * @class Action
 */
class Action {

	/**
	 * Add posts.
	 * @return null
	 */
	function posts_add() {
		$post = $_POST['post'];
		$reply = $_POST['reply'];

		global $topic;
		global $html_filter;

		$post = $html_filter->process($post);

		if($reply && $post) {
			mysql_query(
				'insert into posts
				values (null, ' . $topic . ', ' . $_SESSION['id_user'] . ', "' .
				Date::to_sql('now') . '", "' . $post . '")'
			);
			mysql_query(
				'update topics
				set date_modified="' . Date::to_sql('now') . '"
				where id_topic=' . $topic
			);
			header('Location: ' . current_page());
		}
	return;
	}

	/**
	 * Logout.
	 * @return null
	 */
	function logout() {
		if ($_SESSION['login']) {
			$logout = $_POST['logout'];
			if ($logout) {
				session_destroy();
				setcookie(session_name(), '', 0, '/');
				header('Location: ' . current_page());
			}
		}
	return;
	}

	/**
	 * Login.
	 * @return null
	 */
	function login() {
		if ($_SESSION['login']==false) {
			$email = $_POST['email'];
			$pass = $_POST['pass'];
			$login = $_POST['login'];

			if ($login) {
				$pass = sha1($pass);
				$result = mysql_query(
					'select * from users
					where email = "' . $email . '" and pass = "' . $pass . '"'
				);
				$row = mysql_fetch_array($result);
				if ($row) {
					$_SESSION['login'] = true;
					$_SESSION['id_user'] = $row['id_user'];
					$_SESSION['id_group'] = $row['id_group'];
					$_SESSION['first_name'] = $row['first_name'];
					$_SESSION['fam_name'] = $row['fam_name'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['pass'] = $row['pass'];
					$_SESSION['about'] = $row['about'];
					header('Location: ' . current_page());
				} else {
					View::login_error();
				}
			}
		}
	return;
	}


} // end class.
?>
