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
				'</td>'."\n".
		'		<td></td>'."\n".
		'	</tr>'."\n";
	}
?>
</tbody>
</table>
<?php
	return;
}
display_calendar();
?>
