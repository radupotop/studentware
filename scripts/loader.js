function include_js (js_file) {
	document.write ('<script type="text/javascript" src="scripts/' + js_file + '"></script>');
}
include_js('mootools.js');
include_js('script.js');
