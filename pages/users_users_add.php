	<tr>
		<td>
		<select title="Group" name="id_group" id="id_group">
			<option value="1">Admin</option>
			<option value="2">Teacher</option>
			<option value="3" selected="selected">Student</option>
		</select>
		</td>
		<td>
		<input title="First name" name="first_name" type="text" id="first_name">
		</td>
		<td>
		<input title="Family name" name="fam_name" type="text" id="fam_name">
		</td>
		<td>
		<input title="Email" name="email" type="text" id="email">
		</td>
		<td>
		<input title="Password" name="pass" type="password" id="pass">
		</td>
		<td>
		<input title="About" name="about" type="text" id="about">
		</td>
		<td>
		<input name="add_user" type="submit" value="Add user">
		</td>
	</tr>

<?php
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
	$filtered_data['about'] = $html_filter->process($filtered_data['about']);
	mysql_query('
		insert into users values (null, ' .
		$filtered_data['id_group'] . ', "' .
		$filtered_data['first_name'] . '", "' .
		$filtered_data['fam_name'] . '", "' .
		$filtered_data['email'] . '", "' .
		$filtered_data['pass'] . '", "' .
		$filtered_data['about'] . '")
	');
	unset($valid);
	header('Location: ' . current_page());
}
?>
