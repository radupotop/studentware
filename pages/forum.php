<?php
/**
 * @file
 * Forum and its configuration.
 */
	$topic = filter_input(INPUT_GET, 'topic', FILTER_VALIDATE_INT);
?>
<div id="forum">

<div id="topics">
<h2>Topics</h2>
<?php
	View::topics();
?>
</div>

<div id="posts">
<?php
	View::posts();
	View::posts_add();

	Action::posts_add();
?>
</div>

</div>
