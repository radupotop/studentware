<?php
/**
 * @file
 * Display files.
 */

/**
 * Display upload.
 * @return null
 */
function display_upload() {
	if($_SESSION['login']) {
?>
<div id="upload">
<form action="<?php echo current_page(true); ?>" method="post"
	enctype="multipart/form-data">
	<p>
		<label for="upload_title">File title</label>
		<input type="text" name="upload[title]" id="upload_title">
		<input type="file" name="upload">
		<input type="submit" name='upload[submit]' value="Upload">
	</p>
</form>
</div>
<?php
	}
}
display_upload();
?>
