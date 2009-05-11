<?php
/**
 * @file
 * Input home
 */

	$home['edit']['req'] = filter_var($_POST['home']['edit']['req'],
		FILTER_VALIDATE_INT);
	$html_filter = new InputFilter($tags['pages']);

/**
 * Edit home page
 * @return null
 */
function input_home_edit() {
	if($_SESSION['id_group'] == 1) {
		global $html_filter;
		$title = filter_var($_POST['home']['edit']['title'], FILTER_UNSAFE_RAW);
		$body = $html_filter->process($_POST['home']['edit']['body']);
		$submit = filter_var($_POST['home']['edit']['submit'],
			FILTER_VALIDATE_INT);
	}
	if($title && $body && $submit) {
		mysql_query(
			'update pages set '.
			'id_user = "'.$_SESSION['id_user'].'", '.
			'date_modified = "'.Date::to_sql('now').'", '.
			'title = "'.$title.'", '.
			'body = "'.$body.'" '.
			'where id_page='.$submit.' and is_home = 1'
		);
	}
	return;
}
input_home_edit();

?>
