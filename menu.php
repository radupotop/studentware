<h2 class="hidden">Menu</h2>
<ul id="menu">
	<li><a href=".">Home</a></li>
	<li><a href="?p=pages">Pages</a></li>
	<li><a href="?p=forum">Forum</a></li>
	<li><a href="?p=files">Files</a></li>
	<li><a href="?p=schedule">Schedule</a></li>
	<li><a href="?p=calendar">Calendar</a></li>

	<?php if ($_SESSION['login']) { ?>
	<li><a href="?p=users">Users</a></li>
	<?php } ?>
</ul>
