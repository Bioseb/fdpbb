jQuery(document).ready(function($) {
	"use strict";

	function hootGeneratorInit() {


		/*** Init ***/

		var mce_selection = '',
			insertButton = $('.hoot-sc-generator-button'),
			hootGenerator = $('#hoot-sc-generator'),
			scListItems = hootGenerator.find('.hoot-sc-generator-list a'),
			scSectionHead = hootGenerator.find('.hoot-sc-generator-content > h2 span'),
			scSections = hootGenerator.find('.hoot-sc-section'),
			currentSC = scSections.first().data('shortcode');
		// Store target editor
		window.hoot_scGenerator_targetEditor = insertButton.data('target');


		/*** Init Magnific Popup ***/

		insertButton.magnificPopup({
			type: 'inline',
			midClick: true,
			alignTop: true,
			closeBtnInside: true,
			callbacks: {
				open: function () {
					// Change z-index
					$('body').addClass('hoot-mfp-shown');
					// Get selection
					mce_selection = (typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor != null && tinyMCE.activeEditor.hasOwnProperty('selection')) ?
						tinyMCE.activeEditor.selection.getContent({ format: "text" }) :
						'';
					// Populate Main Content
					//if (typeof mce_selection !== 'undefined' && mce_selection !== '') $('#su-generator-content').val(mce_selection);
				},
				close: function () {
					// Clear selection
					mce_selection = '';
					// Change z-index
					$('body').removeClass('hoot-mfp-shown');
				}
			}
		});


		/*** Shortcode Sections ***/

		scListItems.first().addClass('current');
		scListItems.on('click', function (e) {
			e.preventDefault();
			currentSC = $(this).data('shortcode');
			scListItems.removeClass('current');
			$(this).addClass('current');
			scSectionHead.html( $(this).html() );
			scSections.hide();
			scSections.filter('.hoot-sc-section-' + currentSC).show();
		});


		/*** Insert shortcode ***/

		hootGenerator.on('click', '.hoot-sc-generator-insert', function (e) {
			e.preventDefault();

			// Prepare data
			var shortcode = prepare_sc();

			// Close popup
			$.magnificPopup.close();

			// Save original activeeditor
			window.hoot_wpActiveEditor = window.wpActiveEditor;
			// Set new active editor
			window.wpActiveEditor = window.hoot_scGenerator_targetEditor;
			// Insert shortcode
			//if (window.hoot_scGenerator_targetEditor === 'content')
			window.wp.media.editor.insert(shortcode);
			// else {
			// var $target = $('textarea#' + window.hoot_scGenerator_targetEditor);
			// if ($target.length > 0) $target.val($target.val() + shortcode);
			// }
			// Restore previous editor
			window.wpActiveEditor = window.hoot_wpActiveEditor;

		});


		/*** Prepare Shortcode ***/

		function prepare_sc() {
			var section = scSections.filter('.hoot-sc-section-' + currentSC),
				attributeSections = section.find('[data-sctype="attribute"]'),
				contentSections = section.find('[data-sctype="content"]');

			return single_sc(currentSC, attributeSections, contentSections, false);
		}

		// Create Single Shortcode syntax
		function single_sc(shortcode, attributeSections, contentSections, isGroupIterator, groupSC) {
			var output = '';

			// Fields ID part
			if ( isGroupIterator ) {
				var scNamePart = 'subscname',
					scFieldPart = 'scfield-' + groupSC + '\\[' + shortcode + '\\]\\[' + isGroupIterator + '\\]';
			} else {
				var scNamePart = 'scname',
					scFieldPart = 'scfield-' + shortcode;
			}

			// Start Shortcode
			output += '[' + shortcode;

			// Add Attributes
			if (attributeSections.length > 0) {
				attributeSections.each(function( index ) {
					var attname = $(this).data(scNamePart),
						attfield = $(this).find('[name=hoot-' + scFieldPart + '\\[' + attname + '\\]]'),
						attvalue = getFieldValue(attfield);
					if (attvalue)
						output += ' ' + attname + '="' + attvalue + '"';
				});
			}
			output += ']';

			// Add Content, and closing shortcode tag if there is content
			if (contentSections.length > 0) {
				contentSections.first().each(function() {
					var contentvalue = '';

					// If content is group
					if ( $(this).hasClass('section-group') ) {
						var subSC = $(this).data(scNamePart);
						$(this).find('.hoot-of-group').each(function(){
							var subGroupIteration = $(this).data('iteration'),
								subAttributeSections = $(this).find('[data-subsctype="attribute"]'),
								subContentSections = $(this).find('[data-subsctype="content"]');
							contentvalue += "\n" + single_sc(subSC, subAttributeSections, subContentSections, subGroupIteration, shortcode);
						});
						contentvalue += "\n";
					}

					// If content is not a group
					else {
						var contentfield = $(this).find('[name=hoot-' + scFieldPart + '\\[content\\]]');
						contentvalue = getFieldValue(contentfield);
					}

					if (contentvalue)
						output += contentvalue;
				});
				output += '[/' + shortcode + ']';
			}

			return output;
		}

		// Get a Field Value
		function getFieldValue( field ) {
			if (field.length > 0) {
				if ( field.is(':radio') || field.is(':checkbox') )
					return field.filter(':checked').val();
				else // input, select, textarea
					return field.val();
			}
			return '';
		}

	}

	// Hoot Shortcode Generator
	hootGeneratorInit();

});