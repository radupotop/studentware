<h2 class="hidden">Menu</h2>
<ul id="menu">
	<li><a href=".">Home</a></li>
	<li><a href="?page=pages">Pages</a></li>
	<li><a href="?page=forum">Forum</a></li>
	<li><a href="?page=files">Files</a></li>
	<li><a href="?page=schedule">Schedule</a></li>
	<li><a href="?page=calendar">Calendar</a></li>

	<?php if ($_SESSION['login']) { ?>
	<li><a href="?page=users">Users</a></li>
	<?php } ?>
</ul>
