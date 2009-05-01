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
	static function posts_add() {
		$post = $_POST['post'];
		$reply = $_POST['reply'];

		global $topic;
		global $tags;

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
			//header('Location: ' . current_page(false));
		}
	return;
	}

	/**
	 * Logout.
	 * @return null
	 */
	static function logout() {
		if ($_SESSION['login']) {
			$logout = $_POST['logout'];
			if ($logout) {
				session_destroy();
				setcookie(session_name(), '', 0, '/');
				header('Location: ' . current_page(false));
			}
		}
	return;
	}

	/**
	 * Login.
	 * @return null
	 */
	static function login() {
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
					header('Location: ' . current_page(false));
				} else {
					View::login_error();
				}
			}
		}
	return;
	}

	/**
	 * Add users.
	 * @return null
	 */
	static function users_add() {
		$add_user = $_POST['add_user'];

		if ($add_user) {
			$input_data = array(
				'id_group' => FILTER_VALIDATE_INT,
				'first_name' => FILTER_SANITIZE_ENCODED,
				'fam_name' => FILTER_SANITIZE_ENCODED,
				'email' => FILTER_VALIDATE_EMAIL,
				'pass' => FILTER_REQUIRE_ARRAY,
				'about' => FILTER_UNSAFE_RAW,
				'add_user' => FILTER_REQUIRE_ARRAY
			);
			$filtered_data = filter_input_array(INPUT_POST, $input_data);
		}
		if (
			$filtered_data['id_group'] &&
			$filtered_data['first_name'] &&
			$filtered_data['fam_name'] &&
			$filtered_data['email'] &&
			$filtered_data['pass'] &&
			$filtered_data['add_user']
		) {
			$valid = true;
		}
		if ($valid) {
			$filtered_data['pass'] = sha1($filtered_data['pass']);
			global $tags;
			global $html_filter;
			$filtered_data['about'] =
				$html_filter->process($filtered_data['about']);
			mysql_query(
				'insert into users values (null, ' .
				$filtered_data['id_group'] . ', "' .
				$filtered_data['first_name'] . '", "' .
				$filtered_data['fam_name'] . '", "' .
				$filtered_data['email'] . '", "' .
				$filtered_data['pass'] . '", "' .
				$filtered_data['about'] . '")'
			);
			//header('Location: ' . current_page(false));
		}
	return;
	}

	/**
	 * Delete users.
	 * @return null
	 */
	static function users_delete() {
		$delete_user =
			filter_input(INPUT_POST, 'delete_user', FILTER_VALIDATE_INT);
		// do not allow deletion of user with id 1
		if ($delete_user && $delete_user != 1) {
			mysql_query(
				'delete from users
				where id_user = ' . $delete_user
			);
			//header('Location: ' . current_page(false));
		}
	return;
	}

	/**
	 * Edit users.
	 * @return null
	 */
	static function users_edit() {
		if ($submit_edit_user) {
			$input_data = array(
				'id_group' => FILTER_VALIDATE_INT,
				'first_name' => FILTER_SANITIZE_ENCODED,
				'fam_name' => FILTER_SANITIZE_ENCODED,
				'email' => FILTER_VALIDATE_EMAIL,
				'pass' => FILTER_UNSAFE_RAW,
				'about' => FILTER_UNSAFE_RAW,
				'submit_edit_user' => FILTER_REQUIRE_ARRAY
			);
			$filtered_data = filter_input_array(INPUT_POST, $input_data);
		}

		if (
			$filtered_data['id_group'] &&
			$filtered_data['first_name'] &&
			$filtered_data['fam_name'] &&
			$filtered_data['email'] &&
			$filtered_data['submit_edit_user']
		) {
			$valid = true;
		}

		if ($valid) {
			$filtered_data['pass'] = sha1($filtered_data['pass']);
			global $html_filter;
			$filtered_data['about'] =
				$html_filter->process($filtered_data['about']);
			mysql_query(
				'update users set ' .
				'id_group = ' . $filtered_data['id_group'] . ', ' .
				'first_name = "' . $filtered_data['first_name'] . '", ' .
				'fam_name = "' . $filtered_data['fam_name'] . '", ' .
				'email = "' . $filtered_data['email'] . '", ' .
				'pass = "' . $filtered_data['pass'] . '", ' .
				'about= "' . $filtered_data['about'] . '" ' .
				'where id_user = ' . $row['id_user']
			);
			//header('Location: ' . current_page(false));
		}
	return;
	}


} // end class.
?>
