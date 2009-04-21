<ul id="menu">
	<li><a href=".">Home</a></li>

	<?php if ($_SESSION['login']) { ?>
	<li><a href="?p=users">Users</a></li>
	<?php } ?>
</ul>
