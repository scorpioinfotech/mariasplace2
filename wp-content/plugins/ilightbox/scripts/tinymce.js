function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function getSelectionHtml() {
    return window.tinyMCE.activeEditor.selection.getContent();
}

function ilshortcodesubmit() {
	
	var tagtext,
	selected = getSelectionHtml(),
	contentText = (selected.length > 0) ? selected : ' Insert you content here ';
	
	var il_shortcode = document.getElementById('ilshortcode_panel'),
	il_shortcode_binds = document.getElementById('ilshortcode_binds');
	
	// who is active ?
	if (il_shortcode.className.indexOf('current') != -1) {
		var il_shortcodeid = document.getElementById('ilshortcode_tag').value;

		tagtext='[ilightbox id="' + il_shortcodeid + '"][/ilightbox]';
	} else if (il_shortcode_binds.className.indexOf('current') != -1) {
		var il_shortcodeid = document.getElementById('ilshortcode_tag2').value;

		tagtext='[ilightbox id="' + il_shortcodeid + '"]' + contentText + '[/ilightbox]';
	}

	if(window.tinyMCE) {
		//TODO: For QTranslate we should use here 'qtrans_textarea_content' instead 'content'
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		//Peforms a clean up of the current editor HTML. 
		//tinyMCEPopup.editor.execCommand('mceCleanup');
		//Repaints the editor. Sometimes the browser has graphic glitches. 
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}