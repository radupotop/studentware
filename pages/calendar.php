<?php
/**
 * @file
 * Display calendar.
 */

/**
 * Display calendar.
 * @return null
 */
function display_calendar() {
?>
<h2>Calendar</h2>
<form action="<?php echo current_page(true); ?>" method="post"
	enctype="multipart/form-data">
<table>
<thead>
	<tr>
		<th>Event</th>
		<th>Starts on</th>
		<th>Ends on</th>
		<?php if($_SESSION['id_group'] == 1) { ?>
		<th>Manage</th>
		<?php } ?>
	</tr>
</thead>
<tbody>
<?php
	$result = mysql_query(
		'select *
		from calendar
		order by date_start'
	);
	while ($row = mysql_fetch_array($result)) {
		echo
		'	<tr>'."\n".
		'		<td>'.$row['title'].'</td>'."\n".
		'		<td>'.Date::from_sql($row['date_start']).'</td>'."\n".
		'		<td>';
		if ($row['date_end'] != '0000-00-00 00:00:00') {
			echo Date::from_sql($row['date_end']);
		}
		echo
				'</td>'."\n";
		if($_SESSION['id_group'] == 1) {
		echo
		'<td>'.
		'		<button name="cal[edit][req]" value="' . $row['id_cal'] .
						'">Edit</button>' .
		'		<button name="cal[delete][req]" value="' . $row['id_cal'] .
						'">Delete</button>'.
		'</td>';
		}
		echo '	</tr>'."\n";
	}
?>
</tbody>
</table>
</form>
<?php
	return;
}
display_calendar();
?>
