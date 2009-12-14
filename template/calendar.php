<?php
/**
 * @file
 * Display calendar.
 */

$calendarsArray = $DB->view('calendars');

/**
 * Display calendar.
 * @return null
 */
function display_calendar() {
	global $calendar, $calendarsArray;
?>
<h2>Calendar</h2>
<p class="cat_desc">Events calendar. Non-weekly events or events that span across multiple days belong here.</p>

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
	foreach($calendarsArray as $cal) {
		if($cal['id_calendar'] == $calendar['edit']['req']) {
			display_calendar_edit();
		} else {
			// admin controls
			if ($_SESSION['id_user'] == $cal['id_user'] ||
			$_SESSION['id_group'] == 1) {
				$controls = sprintf(
				'<button name="calendar[edit][req]" value="%s">Edit</button>
				<button name="calendar[delete][req]" value="%1$s">Delete</button>',
				$cal['id_calendar']
				);
			} else
				unset($controls);
			if($_SESSION['login'])
				$controls = sprintf('<td>%s</td>', $controls);
			// list
			echo sprintf(
			'<tr>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				%s
			</tr>',
			$cal['title'],
			Date::from_sql($cal['date_start']),
			Date::from_sql($cal['date_end']),
			$controls
			);
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
	global $calendar, $calendarsArray;
	$cal = $calendar['edit']['req'];
?>
<tr class="editing">
	<td>
		<input type="text" name="calendar[edit][title]"
			value="<?php echo $calendarsArray[$cal]['title'] ?>">
	</td>
	<td>
		<input type="text" name="calendar[edit][date_start]"
			value="<?php echo Date::from_sql($calendarsArray[$cal]['date_start']) ?>">
	</td>
	<td>
		<input type="text" name="calendar[edit][date_end]"
			value="<?php echo Date::from_sql($calendarsArray[$cal]['date_end']) ?>">
	</td>
	<td>
		<button name="calendar[edit][submit]"
			value="<?php echo $cal ?>">Edit event</button>
	</td>
</tr>
<?php
}

?>
