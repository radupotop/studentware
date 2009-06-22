<?php
/**
 * @file
 * Input processing for pages.
 */
	$pag = filter_input(INPUT_GET, 'pag', FILTER_VALIDATE_INT); // current page
	$html_filter = new InputFilter($tags, $attr);
	$page['edit']['req'] =
		filter_var($_POST['page']['edit']['req'], FILTER_VALIDATE_INT);

/**
 * Edit page
 * @return null
 */
function input_page_edit() {
	global $html_filter;
	if($_SESSION['login'] && $page['edit']['req']) {
		$page['edit']['title'] =
			filter_var($_POST['page']['edit']['title'], FILTER_UNSAFE_RAW);
		$page['edit']['body'] =
			$html_filter->process($_POST['page']['edit']['body']);
		$page['edit']['submit'] =
			filter_var($_POST['page']['edit']['submit'], FILTER_VALIDATE_INT);
	}
	if($page['edit']['title']
	&& $page['edit']['body']
	&& $page['edit']['submit']) {
		mysql_query(
			'update pages set '.
			'id_user = "'.$_SESSION['id_user'].'", '.
			'date_modified = "'.Date::to_sql('now').'", '.
			'title = "'.esc($page['edit']['title']).'", '.
			'body = "'.esc($page['edit']['body']).'" '.
			'where id_page='.$page['edit']['submit']
		);
	}
	return;
}
input_page_edit();

/**
 * Delete page.
 * @return null
 */
function input_page_delete() {
	$page['delete']['req'] =
		filter_var($_POST['page']['delete']['req'], FILTER_VALIDATE_INT);
	if ($_SESSION['login'] && $page['delete']['req']) {
		mysql_query (
			'delete from pages
			where id_page='.$page['delete']['req']
		);
	}
	return;
}
input_page_delete();
?>
