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
?>
