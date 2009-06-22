/*
Script: MooEditable.Extras.js
	Extends MooEditable to include more (simple) toolbar buttons.

License:
	MIT-style license.
*/

MooEditable.Actions.extend({

	formatBlock: {
		title: 'Block Formatting',
		type: 'menu-list',
		options: {
			list: [
				{text: 'Paragraph', value: 'p'},
				{text: 'Heading 2', value: 'h2'},
				{text: 'Heading 3', value: 'h3'},
				{text: 'Heading 4', value: 'h4'},
				{text: 'Heading 5', value: 'h5'},
				{text: 'Heading 6', value: 'h6'}
			]
		},
		states: {
			tags: ['p', 'h2', 'h3', 'h4', 'h5', 'h6']
		},
		command: function(menulist, name){
			var argument = '<' + name + '>';
			this.execute('formatBlock', false, argument);
			this.focus();
		}
	},

	justifyleft:{
		title: 'Align Left',
		states: {
			css: {'text-align': 'left'}
		}
	},

	justifyright:{
		title: 'Align Right',
		states: {
			css: {'text-align': 'right'}
		}
	},

	justifycenter:{
		title: 'Align Center',
		states: {
			tags: ['center'],
			css: {'text-align': 'center'}
		}
	},

	justifyfull:{
		title: 'Align Justify',
		states: {
			css: {'text-align': 'justify'}
		}
	}

});
