<?php
/**
 * @file
 * Config file.
 */

/**
 * Site config.
 */
$site = array (
	'name' => 'Info 3',
	'desc' => 'grupa 2231',
	'url'  => '.',
	// id of home page
	'home' => '1',
	// Registration
	'reg' => array (
		'enabled' => true,
		// sha1sum of code
		'code' => ''
	)
);

/**
 * Files section config.
 * Configure path to files, max file size, allowed file types
 */
$files = array (
	'path' => 'files/',
	'size' => '31000000',
	'type' => array (
		// Images
		'image/png',
		'image/gif',
		'image/jpeg', 'image/pjpeg',
		'image/svg+xml',
		// Archives
		'application/zip',
		'application/x-gzip',
		'application/rar',
		// Audio Video
		'audio/mpeg',
		'video/mpeg',
		'audio/ogg',
		'video/ogg',
		'application/ogg',
		'video/mp4',
		'video/x-msvideo',
		'video/x-ms-wmv',
		'video/quicktime',
		'video/x-flv',
		// Source code
		'text/x-csrc',
		'text/x-chdr',
		'text/x-c++src',
		'text/x-c++hdr',
		'text/x-python',
		'text/x-java',
		'text/x-sh',
		// Documents
		'text/html',
		'application/xml',
		'application/xhtml+xml',
		'application/pdf',
		'application/postscript',
		'application/msword',
		'application/vnd.ms-excel',
		'application/vnd.ms-powerpoint',
		'application/vnd.oasis.opendocument.text',
		'application/vnd.oasis.opendocument.presentation',
		'application/vnd.oasis.opendocument.spreadsheet',
		'application/vnd.oasis.opendocument.graphics',
		'text/plain'
	)
);

/**
 * Allowed HTML tags.
 */
$tags = array (
	'h2', 'h3', 'h4', 'h5', 'h6',
	'strong', 'em', 'br',
	'cite', 'blockquote', 'code', 'pre',
	'sub', 'sup', 'del', 'ins',
	'div', 'p', 'span', 'img', 'a',
	'ul', 'ol', 'li',
	'dl', 'dt', 'dd',
	'abbr', 'acronym', 'hr'
);
$attr = array (
	'href', 'src', 'lang',
	'title', 'alt',
	'rel', 'rev',
	'id', 'class', 'name',
	'style', 'width', 'height', 'align'
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
	//database prefix - not working yet
	'pref' => ''
);

/**
 * Application config.
 */
$app = array (
	'site' => 'http://bitbucket.org/wooptoo/studentware/',
	'ver' => '0.3.3',
	'log' => array (
		'enabled' => false,
		'path' => 'all.log'
	)
);

/**
 * Mailing list config. & credentials
 */
$mailing_list = array (
	'enabled' => true,
	'email' => 'example@gmail.com',
	'server' => 'imap.gmail.com',
	'user' => '',
	'pass' => '',
	// Do not change this if you don't know what you are doing
	'param' => '/notls/norsh/novalidate-cert/ssl'
);
?>
