<?php
/**
 * @file
 * Input home
 */

	$home['edit']['req'] = filter_var($_POST['home']['edit']['req'],
		FILTER_VALIDATE_INT);
	$html_filter = new InputFilter($tags, $attr);

/**
 * Edit home page
 * @return null
 */
function input_home_edit() {
	global $html_filter;
	if($_SESSION['id_group'] == 1) {
		$title = filter_var($_POST['home']['edit']['title'], FILTER_UNSAFE_RAW);
		$body = $html_filter->process($_POST['home']['edit']['body']);
		$submit = filter_var($_POST['home']['edit']['submit'],
			FILTER_VALIDATE_INT);
	}
	if($title && $body && $submit) {
		mysql_query(
			'update pages set '.
			'date_modified = NOW(), '.
			'title = "'.esc($title).'", '.
			'body = "'.esc($body).'" '.
			'where id_page='.$submit
		);
	}
	return;
}
input_home_edit();

?>
