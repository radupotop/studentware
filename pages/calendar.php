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
	global $calendar;
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
		<?php if($_SESSION['login']) { ?>
		<th>Manage</th>
		<?php } ?>
	</tr>
</thead>
<tbody>
<?php
	$result = mysql_query(
		'select *
		from calendars
		order by date_start'
	);
	while ($row = mysql_fetch_array($result)) {
		if($row['id_calendar'] == $calendar['edit']['req']) {
			display_calendar_edit();
		} else {
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
		if (
			// if users owns element or if user is admin display edit & delete
			$_SESSION['id_user'] == $row['id_user'] ||
			$_SESSION['id_group'] == 1
		) {
		echo
		'<td>'.
		'		<button name="calendar[edit][req]" value="'
					.$row['id_calendar'].'">Edit</button>' .
		'		<button name="calendar[delete][req]" value="'
					.$row['id_calendar'].'">Delete</button>'.
		'</td>';
		} else if ($_SESSION['login']) {
			echo
			'<td></td>';
		}
		echo '	</tr>'."\n";
		}
	}

if($_SESSION['login']) {
?>
	<tr>
		<td>
			<input type="text" name="calendar[add][title]">
		</td>
		<td>
			<input type="text" name="calendar[add][date_start]">
		</td>
		<td>
			<input type="text" name="calendar[add][date_end]">
		</td>
		<td>
			<button name="calendar[add][submit]" value="true">Add event</button>
		</td>
	</tr>
<?php } ?>
</tbody>
</table>
</form>
<?php
	return;
}
display_calendar();

/**
 * Display calendar edit.
 * @return null
 */
function display_calendar_edit() {
	global $calendar;
	$result = mysql_query(
		'select *
		from calendars
		where id_calendar='.$calendar['edit']['req']
	);
	$row = mysql_fetch_array($result);
?>
<tr class="editing">
	<td>
		<input type="text" name="calendar[edit][title]"
			value="<?php echo $row['title'] ?>">
	</td>
	<td>
		<input type="text" name="calendar[edit][date_start]"
			value="<?php echo Date::from_sql($row['date_start']) ?>">
	</td>
	<td>
		<input type="text" name="calendar[edit][date_end]"
			value="<?php echo Date::from_sql($row['date_end']) ?>">
	</td>
	<td>
		<button name="calendar[edit][submit]"
			value="<?php echo $row['id_calendar'] ?>">Edit event</button>
	</td>
</tr>
<?php
}

?>
