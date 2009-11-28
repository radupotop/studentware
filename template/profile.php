<?php
/**
 * @file
 * User profile page.
 */

if ($_SESSION['login']) {

	function display_profile() {
?>
<div id="profile">
<h2>Profile</h2>
<p class="cat_desc">Edit your personal info and settings.</p>

<form action="<?php echo current_page(true); ?>" method="post">
<div>
	<label for="profile_first_name">First name</label>
	<input name="profile[first_name]" type="text" id="profile_first_name"><br>

	<label for="profile_fam_name">Family name</label>
	<input name="profile[fam_name]" type="text" id="profile_fam_name"><br>

	<label for="profile_email">Email</label>
	<input name="profile[email]" type="text" id="profile_email">
	 (this is also your login name)<br>

	<label for="profile_pass">Password</label>
	<input name="profile[pass]" type="password" id="profile_pass"><br>

	<label for="profile_pass_verif">Password</label>
	<input name="profile[pass_verif]" type="password" id="profile_pass_verif">
	 (verify)<br>

	<label for="textarea">About you</label><br><br>
	<textarea name="profile[about]" rows="10" cols="80" id="textarea">
		</textarea><br>

	<input name="profile[submit]" type="submit" value="Submit">
</div>
</form>

</div>
<?php
	return;
	}
	display_profile();
}
?>
