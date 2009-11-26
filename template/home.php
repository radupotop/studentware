<?php
/**
 * @file
 * Home page.
 * This is defined in config.php
 */
?>

<form action="<?php echo current_page(true) ?>" method="post">
<div id="home">
<?php

/**
 * Display home edit
 * @return null
 */
function display_home_edit() {
	$result = mysql_query(
		'select *
		from pages
		where id_page=1'
	);
	queryCount();
	$row = mysql_fetch_array($result);
?>
	<input name="home[edit][title]" type="text" class="page_title"
		value="<?php echo $row['title'] ?>"><br><br>
	<textarea name="home[edit][body]" rows="18" cols="100"
		id="textarea"><?php echo $row['body'] ?></textarea><br>
	<button name="home[edit][submit]" value="<?php echo $row['id_page'] ?>">
		Submit</button>
<?php
	return;
}

/**
 * Display home page
 * @return null
 */
function display_home() {
	global $home;
	if($home['edit']['req']) {
		display_home_edit();
	} else {
	$result = mysql_query(
		'select *
		from pages
		where id_page=1'
	);
	queryCount();
	$row = mysql_fetch_array($result);
	//title
	echo '<h2>' . $row['title'] . '</h2>' ."\n";
	//body
	echo
		'<div id="body">'."\n".
		$row['body'];
		'</div>'."\n";
	if ($_SESSION['id_group'] == 1) {
		echo
		'<p><button name="home[edit][req]" value="'.$row['id_page'].'">
			Edit</button></p>'."\n";
	}
	}
	return;
}
display_home();
?>

</div>
</form>
