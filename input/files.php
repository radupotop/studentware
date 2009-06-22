<?php
/**
 * @file
 * Input files.
 */

	$upload['edit']['req'] = filter_var($_POST['upload']['edit']['req'],
		FILTER_VALIDATE_INT);

/**
 * Input files add.
 * @return bool - whether add succeded or not
 */
function input_files_add() {
	global $files;
	$title = filter_var($_POST['upload']['add']['title'], FILTER_UNSAFE_RAW);
	$submit = $_POST['upload']['add']['submit'];
	if($_SESSION['login'] && $title && $submit) {
	if (
		($_FILES['upload_add']['error'] == 0)
	&&	($_FILES['upload_add']['size'] < $files['size'])
	&&	in_array($_FILES['upload_add']['type'], $files['type'])
	) {
		move_uploaded_file($_FILES['upload_add']['tmp_name'],
			$files['path'] . $_FILES['upload_add']['name']);
		$hash = rename_to_hash($files['path'], $_FILES['upload_add']['name']);
		mysql_query(
			'insert into files
			values (null, "' . $_SESSION['id_user'] . '",
			"'.Date::to_sql('now').'", "'.esc($title).'", "'.esc($hash).'")'
		);
		return true;
	}
	else
		return false;
	}
}
input_files_add();

/**
 * Input files edit.
 * @return null
 */
function input_files_edit() {
	global $files;
	$title =  filter_var($_POST['upload']['edit']['title'], FILTER_UNSAFE_RAW);
	$submit = filter_var($_POST['upload']['edit']['submit'],
		FILTER_VALIDATE_INT);
	if ($_SESSION['login'] && $title && $submit) {
		$result = mysql_query(
			'select *
			from files
			where id_file = '.$submit
		);
		$row = mysql_fetch_array($result);

		if (
			($_FILES['upload_edit']['error'] == 0)
		&&	($_FILES['upload_edit']['size'] < $files['size'])
		&&	in_array($_FILES['upload_edit']['type'], $files['type'])
		) {
			move_uploaded_file($_FILES['upload_edit']['tmp_name'],
				$files['path'] . $_FILES['upload_edit']['name']);
			$hash = rename_to_hash($files['path'],
				$_FILES['upload_edit']['name']);
			mysql_query(
				'update files set '.
				'id_user = '.$_SESSION['id_user'].', '.
				'date_modified = "'.Date::to_sql('now').'", '.
				'title = "'.esc($title).'", '.
				'filename = "'.esc($hash).'" '.
				'where id_file = '.$submit
			);
			@unlink($files['path'] . $row['filename']);
			return true;
		} else {
			return false;
		}
	}
}
input_files_edit();

/**
 * Delete files. First delete file on disk then erase record from database.
 * @return null
 */
function input_files_delete() {
	global $files;
	$delete = filter_var($_POST['upload']['delete']['req'],FILTER_VALIDATE_INT);
	if ($_SESSION['login'] && $delete) {
		$result = mysql_query(
			'select filename
			from files
			where id_file=' . $delete
		);
		$row = mysql_fetch_array($result);
		@unlink($files['path'] . $row['filename']);
		mysql_query(
			'delete from files
			where id_file=' . $delete
		);
	}
	return;
}
input_files_delete();

/**
 * Handles downloads - force the browser to display the save dialog.
 * @return null
 */
function input_files_download() {
	global $files;
	$download = filter_input(INPUT_GET, 'download', FILTER_VALIDATE_INT);
	if($download) {
		$result = mysql_query(
			'select *
			from files
			where id_file=' . $download
		);
		$row = mysql_fetch_array($result);
		$download_name = $row['title'] . extension($row['filename']);
		$file = $files['path'] . $row['filename'];
		//header('Content-type: ' . mime_content_type($file));
		header('Content-Disposition: attachment;
			filename="' . $download_name . '"');
		readfile($file);
		exit;
	}
	return;
}
input_files_download();


?>
