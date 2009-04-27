<?php
$delete_user = filter_input(INPUT_POST, 'delete_user', FILTER_VALIDATE_INT);

if ($delete_user>1) {
	mysql_query('
		delete from users
		where id_user = ' . $delete_user . '
	');
	header('Location: ' . current_page());
}
?>
