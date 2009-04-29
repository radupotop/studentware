<?php
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
	$filtered_data['about'] = $html_filter->process($filtered_data['about']);
	$query =
		'update users set ' .
		'id_group = ' . $filtered_data['id_group'] . ', ' .
		'first_name = "' . $filtered_data['first_name'] . '", ' .
		'fam_name = "' . $filtered_data['fam_name'] . '", ' .
		'email = "' . $filtered_data['email'] . '", ' .
		'pass = "' . $filtered_data['pass'] . '", ' .
		'about= "' . $filtered_data['about'] . '" ' .
		'where id_user = ' . $row['id_user']
	;
	mysql_query($query);
	unset($valid);
	header('Location: ' . current_page());
}

}
?>
