<?php
/**
 * @file
 * Calendar input.
 */

	$calendar['edit']['req'] =
		filter_var($_POST['calendar']['edit']['req'], FILTER_VALIDATE_INT);

/**
 * Input add calendar
 * @return null
 */
function input_add_calendar() {
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
	$query ='insert into calendars
		values(
			null,
			"'.Date::to_sql($calendar['add']['date_start']).'",
			"'.Date::to_sql($calendar['add']['date_end']).'",
			"'.esc($calendar['add']['title']).'"
		)';
		mysql_query ($query);
	}

	return;
}
input_add_calendar();


/**
 * Input edit calendar
 * @return null
 */
function input_edit_calendar() {
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
		mysql_query (
			'update calendars set
			date_start="'.Date::to_sql($calendar['edit']['date_start']).'",
			date_end="'.Date::to_sql($calendar['edit']['date_end']).'",
			title="'.esc($calendar['edit']['title']).'"
			where id_calendar='.$calendar['edit']['submit']
		);
	}

	return;
}
input_edit_calendar();



/**
 * Input delete calendar.
 * @return null
 */
function input_delete_calendar() {
	$calendar['delete']['req'] =
		filter_var($_POST['calendar']['delete']['req'],FILTER_VALIDATE_INT);
	if ($_SESSION['login'] && $calendar['delete']['req']) {
		mysql_query(
			'delete from calendars
			where id_calendar='.$calendar['delete']['req']
		);
	}
	return;
}
input_delete_calendar();
?>
