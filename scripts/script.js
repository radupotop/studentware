window.addEvent('domready', function(){
	$('textarea').mooEditable({
		//actions: 'bold italic underline strikethrough | formatBlock justifyleft justifyright justifycenter justifyfull | insertunorderedlist insertorderedlist indent outdent | undo redo | createlink unlink | urlimage | toggleview'
		actions: 'bold italic | formatBlock justifyleft justifyright justifycenter justifyfull | insertunorderedlist insertorderedlist indent outdent | undo redo | createlink unlink | urlimage | toggleview',
		baseCSS: 'html { height: 100%; cursor: text }\
			body{ font: normal .75em Verdana, sans-serif; border: 0; }'
	});
});
