<?php
/**
 * @file
 * Input home
 */

	$home['edit']['req'] = filter_var($_POST['home']['edit']['req'],
		FILTER_VALIDATE_INT);

/**
 * Edit home page
 * @return null
 */
function input_home_edit() {
	return;
}
?>
