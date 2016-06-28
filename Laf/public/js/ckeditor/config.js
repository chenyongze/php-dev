/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbar = [
		{ name: 'tools', items: [ 'Maximize' ] },
		{ name: 'insert' , items:['Image', 'Mathjax', 'Table',]},
		'/', 
		// { name: 'forms' },
		// { name: 'tools' },
		// { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		// { name: 'others' },
		// '/',
		// { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		// { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		// { name: 'styles' },
		// { name: 'colors' },
		// { name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

	config.filebrowserImageUploadUrl = '/common/upload/image';
    config.filebrowserImageBrowseUrl = '/common/upload/image';
    config.filebrowserImageBrowseLinkUrl = '/common/upload/image';
    config.filebrowserUploadUrl = '/common/upload/image';
    config.imageUploadUrl='/common/upload/image';

	config.mathJaxLib = 'http://cdn.mathjax.org/mathjax/2.2-latest/MathJax.js?config=TeX-AMS_HTML';
};
