function include_js (js_file) {
	document.write ('<script type="text/javascript" src="scripts/' + js_file + '"></script>');
}
include_js('mootools.js');
include_js('mooeditable/MooEditable.js');
include_js('mooeditable/MooEditable.UI.MenuList.js');
include_js('mooeditable/MooEditable.Extras.js');
include_js('script.js');
