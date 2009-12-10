<?php
/**
 * @file
 * Display register.
 */
if ($_SESSION['login']==false && $site['reg']['enabled']) {

	function display_register() {
?>
<div id="register">
<h2>Register</h2>

<form action="<?php echo current_page(true); ?>" method="post">
<div>
	<label for="register_first_name">First name</label>
	<input name="register[first_name]" type="text" id="register_first_name"><br>

	<label for="register_fam_name">Family name</label>
	<input name="register[fam_name]" type="text" id="register_fam_name"><br>

	<label for="register_email">Email</label>
	<input name="register[email]" type="text" id="register_email">
	 (this is also your login name)<br>

	<label for="register_pass">Password</label>
	<input name="register[pass]" type="password" id="register_pass"><br>

	<label for="register_pass_verif">Password</label>
	<input name="register[pass_verif]" type="password" id="register_pass_verif">
	 (verify)<br>

	<label for="register_code">Code</label>
	<input name="register[code]" type="password" id="register_code">
	 (given to you at class)<br>

	<input name="register[submit]" type="submit" value="Register">
</div>
</form>

</div>
<?php
	return;
	}
	display_register();
}
?>
