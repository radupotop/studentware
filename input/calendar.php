<?php
/**
 * @file
 * Calendar input.
 */

	$calendar['edit']['req'] =
		filter_var($_POST['calendar']['edit']['req'], FILTER_VALIDATE_INT);
	$DB = new DB;

/**
 * Input add calendar
 * @return null
 */
function input_add_calendar() {
	global $DB;
	$calendar['add']['title'] =
		filter_var($_POST['calendar']['add']['title'],FILTER_UNSAFE_RAW);
	$calendar['add']['date_start'] =
		$_POST['calendar']['add']['date_start'];
	$calendar['add']['date_end'] =
		$_POST['calendar']['add']['date_end'];
	$calendar['add']['submit'] =
		$_POST['calendar']['add']['submit'];

	if($_SESSION['login']
	&& $calendar['add']['title']
	&& $calendar['add']['date_start']
	&& $calendar['add']['submit']) {
		$add = array(
			'id_user' => $_SESSION['id_user'],
			'date_start' => Date::to_sql($calendar['add']['date_start']),
			'date_end' => Date::to_sql($calendar['add']['date_end']),
			'title' => $calendar['add']['title']
		);
		$DB->add('calendars', $add);
	}

	return;
}
input_add_calendar();


/**
 * Input edit calendar
 * @return null
 */
function input_edit_calendar() {
	global $DB;
	$calendar['edit']['title'] =
		filter_var($_POST['calendar']['edit']['title'],FILTER_UNSAFE_RAW);
	$calendar['edit']['date_start'] =
		$_POST['calendar']['edit']['date_start'];
	$calendar['edit']['date_end'] =
		$_POST['calendar']['edit']['date_end'];
	$calendar['edit']['submit'] =
		$_POST['calendar']['edit']['submit'];

	if($_SESSION['login']
	&& $calendar['edit']['title']
	&& $calendar['edit']['date_start']
	&& $calendar['edit']['submit']) {
		$edit = array(
			'date_start' => Date::to_sql($calendar['edit']['date_start']),
			'date_end' => Date::to_sql($calendar['edit']['date_end']),
			'title' => $calendar['edit']['title']
		);
		$DB->edit('calendars',$edit,'id_calendar',$calendar['edit']['submit']);
	}

	return;
}
input_edit_calendar();



/**
 * Input delete calendar.
 * @return null
 */
function input_delete_calendar() {
	global $DB;
	$calendar['delete']['req'] =
		filter_var($_POST['calendar']['delete']['req'],FILTER_VALIDATE_INT);
	if ($_SESSION['login'] && $calendar['delete']['req'])
		$DB->delete('calendars', 'id_calendar', $calendar['delete']['req']);
	return;
}
input_delete_calendar();
?>
