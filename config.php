<?php
/**
 * @file
 * Config file.
 */

/**
 * Site config.
 */
$site = array (
	'name' => 'studentware',
	'desc' => '',
	'url'  => 'http://cmyk.wooptoo.com/priv/licenta/',
	'files' => 'files/'
);

/**
 * Allowed HTML tags.
 */
$tags = array (
	'forum' => array('strong', 'em', 'br', 'cite', 'code'),
	'pages' => array('h2', 'h3', 'h4', 'h5', 'h6', 'strong', 'em', 'br',
		'cite', 'blockquote', 'code', 'pre', 'img',
		'ul', 'ol', 'li')
);

/**
 * Database config.
 */
$db = array (
	'host' => 'localhost',
	'user' => 'root',
	'pass' => '',
	'name' => 'licenta',
	'char' => 'utf8',
	'pref' => '' //database prefix - not working yet
);
?>
