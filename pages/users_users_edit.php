<?php
if($edit_user) {
?>
	<tr id="editable">
		<td>
		<select title="Group" name="id_group">
			<option value="1">Admin</option>
			<option value="2">Teacher</option>
			<option value="3" selected="selected">Student</option>
		</select>
		</td>
		<td>
		<input title="First name" name="first_name" type="text"
			value="<?php echo $row['first_name']; ?>">
		</td>
		<td>
		<input title="Family name" name="fam_name" type="text"
			value="<?php echo $row['fam_name']; ?>">
		</td>
		<td>
		<input title="Email" name="email" type="text"
			value="<?php echo $row['email']; ?>">
		</td>
		<td>
		<input title="Password" name="pass" type="password">
		</td>
		<td>
		<input title="About" name="about" type="text"
			value="<?php echo $row['about']; ?>">
		</td>
		<td>
		<input name="submit_edit_user" type="submit" value="Edit user">
		</td>
	</tr>

<?php
}

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

?>
