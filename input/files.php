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
	global $site;
	$title = filter_var($_POST['upload']['add']['title'], FILTER_UNSAFE_RAW);
	$submit = $_POST['upload']['add']['submit'];
	if($_SESSION['login'] && $title && $submit) {
	if (
		($_FILES['upload_add']['error'] == 0)
	&&	($_FILES['upload_add']['size'] < 31000000)
	&&	(
		($_FILES['upload_add']['type'] == 'image/png')
	||	($_FILES['upload_add']['type'] == 'image/gif')
	||	($_FILES['upload_add']['type'] == 'image/jpeg')
	||	($_FILES['upload_add']['type'] == 'image/pjpeg')
	||	($_FILES['upload_add']['type'] == 'text/plain')
	||	($_FILES['upload_add']['type'] == 'application/pdf')
	||	($_FILES['upload_add']['type'] == 'application/msword')
	||	($_FILES['upload_add']['type'] == 'application/zip')
	||	($_FILES['upload_add']['type'] == 'application/x-gzip')
	||	($_FILES['upload_add']['type'] == 'audio/mpeg')
	||	($_FILES['upload_add']['type'] == 'video/mpeg')
	||	($_FILES['upload_add']['type'] == 'audio/ogg')
	||	($_FILES['upload_add']['type'] == 'video/ogg')
	||	($_FILES['upload_add']['type'] == 'application/ogg')
	||	($_FILES['upload_add']['type'] == 'video/x-msvideo')
	||	($_FILES['upload_add']['type'] == 'video/x-ms-wmv')
	||	($_FILES['upload_add']['type'] == 'video/quicktime')
	//	Open Document Format
	||	($_FILES['upload_add']['type'] == 'application/vnd.oasis.opendocument.text')
	||	($_FILES['upload_add']['type'] == 'application/vnd.oasis.opendocument.presentation')
	||	($_FILES['upload_add']['type'] == 'application/vnd.oasis.opendocument.spreadsheet')
	||	($_FILES['upload_add']['type'] == 'application/vnd.oasis.opendocument.graphics')
	)
	) {
		move_uploaded_file($_FILES['upload_add']['tmp_name'],
			$site['files'] . $_FILES['upload_add']['name']);
		$hash = rename_to_hash($site['files'], $_FILES['upload_add']['name']);
		mysql_query(
			'insert into files
			values (null, "' . $_SESSION['id_user'] . '",
			"' . Date::to_sql('now') . '", "' . $title . '", "' . $hash . '")'
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
	global $site;
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
			&&	($_FILES['upload_edit']['size'] < 31000000)
			&&	(
				($_FILES['upload_edit']['type'] == 'application/zip')
			||	($_FILES['upload_edit']['type'] == 'image/png')
			||	($_FILES['upload_edit']['type'] == 'image/jpeg')
			)
		) {
			move_uploaded_file($_FILES['upload_edit']['tmp_name'],
				$site['files'] . $_FILES['upload_edit']['name']);
			$hash = rename_to_hash($site['files'],
				$_FILES['upload_edit']['name']);
			mysql_query(
				'update files set '.
				'id_user = '.$_SESSION['id_user'].', '.
				'date_modified = "'.Date::to_sql('now').'", '.
				'title = "'.$title.'", '.
				'filename = "'.$hash.'" '.
				'where id_file = '.$submit
			);
			@unlink($site['files'] . $row['filename']);
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
	global $site;
	$delete = filter_var($_POST['upload']['delete']['req'],FILTER_VALIDATE_INT);
	if ($_SESSION['login'] && $delete) {
		$result = mysql_query(
			'select filename
			from files
			where id_file=' . $delete
		);
		$row = mysql_fetch_array($result);
		@unlink($site['files'] . $row['filename']);
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
	global $site;
	$download = filter_input(INPUT_GET, 'download', FILTER_VALIDATE_INT);
	if($download) {
		$result = mysql_query(
			'select *
			from files
			where id_file=' . $download
		);
		$row = mysql_fetch_array($result);
		$download_name = $row['title'] . extension($row['filename']);
		$file = $site['files'] . $row['filename'];
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
