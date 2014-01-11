/*
 * Metadata - jQuery plugin for highlight words in text or html
 * http://alexmuz.ru/jquery-highlight-plugin/
 *
 * Copyright (c) 2009 Alexander Muzychenko
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
jQuery.fn.highlight = function(words, settings) {
	var highlight_settings = {split: ' ', className: 'highlight', caseSensitive: false};
	highlight_settings = jQuery.extend(highlight_settings, settings);
	
	function wordsHighlight(node, words) {
		if (node.nodeType == 3) {
		    var regexp = new RegExp("(" + words.replace(new RegExp(highlight_settings.split, 'g'), "|") +")", (highlight_settings.caseSensitive ? "" : "i") + "g");
		    var str = jQuery('<div></div>').text(node.data).html();
		    jQuery(node).replaceWith(str.replace(regexp, '<span class="' + highlight_settings.className + '">$1</span>'));
		} else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
	        	for (var i = 0; i < node.childNodes.length; i++) {
	        		wordsHighlight(node.childNodes[i], words);
	        	}
		}
	}

	return this.each(function() {
	    wordsHighlight(this, words);
	});
};

jQuery.highlightHtml = function (html, words, settings) {
	return jQuery('<div>' + html + '</div>').highlight(words, settings).html();
}
