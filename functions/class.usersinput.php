<?php
class UsersInput {

	/**
	 * Identify user.
	 * Find ID of user from email address.
	 *
	 * @param string $addr
	 * @return int $id_user
	 */
	static function idUser($addr) {
		$addr = strtolower(trim($addr));
		$result = mysql_query ('select * from users');
		queryCount();

		while($row = mysql_fetch_array($result)) {
			$query_addr = strtolower(trim($row['email']));
			if($addr == $query_addr) {
				$id_user = $row['id_user'];
				break;
			}
		}

		return $id_user;
	}

}
?>
