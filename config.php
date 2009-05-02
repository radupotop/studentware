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
	'url'  => 'http://cmyk.wooptoo.com/priv/licenta/'
);

/**
 * Allowed HTML tags.
 */
$tags = array (
	'forum' => array('strong', 'em', 'span', 'br', 'cite'),
	'pages' => array('h2', 'h3', 'strong', 'em', 'span', 'br', 'cite')
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
