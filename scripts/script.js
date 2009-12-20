// mootools
window.addEvent('domready', function(){

	// mooeditable
	MooEditable.Actions.extend({
		formatBlock: {
			title: 'Block Formatting',
			type: 'menu-list',
			options: {
				list: [
					{text: 'Paragraph', value: 'p'},
					{text: 'Code', value: 'pre'},
					{text: 'Heading 2', value: 'h2'},
					{text: 'Heading 3', value: 'h3'},
					{text: 'Heading 4', value: 'h4'},
					{text: 'Heading 5', value: 'h5'},
					{text: 'Heading 6', value: 'h6'}
				]
			},
			states: {
				tags: ['p', 'pre', 'h2', 'h3', 'h4', 'h5', 'h6']
			},
			command: function(menulist, name){
				var argument = '<' + name + '>';
				this.focus();
				this.execute('formatBlock', false, argument);
			}
		}
	});

	$$('textarea').mooEditable({
		actions: 'bold italic strikethrough | formatBlock justifyleft justifyright justifycenter justifyfull | insertunorderedlist insertorderedlist indent outdent | undo redo removeformat | createlink unlink | urlimage charmap insertHorizontalRule | toggleview | \
		tableadd tableedit tablerowadd tablerowedit tablerowspan tablerowsplit tablerowdelete tablecoladd tablecoledit tablecolspan tablecolsplit tablecoldelete',
		externalCSS: 'scripts/mooeditable.css'
	});

	// site scripts
	$$('tr:odd').setStyle('background', '#f6f6f6');
});
