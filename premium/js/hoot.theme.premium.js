jQuery(document).ready(function($) {
	"use strict";

	/*** Lightbox ***/

	if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.lightbox || 'enable' == hootData.lightbox ) {
		if (typeof $.fn.lightGallery != 'undefined') {

			// Add lightbox to Images
			if ( 'undefined' == typeof hootData.lightboxImg || 'enable' == hootData.lightboxImg ) {

				$('.woocommerce .entry.product > .images a').addClass('no-lightbox'); // Remove lightbox from woocommerce images, and let woo's lightbox take over

				//$("a[href$='.jpg'], a[href$='.png'], a[href$='.jpeg'], a[href$='.gif']").each(function(i){
				$('a[href]').filter(function() {
					var href = $(this).attr('href'),
						islb = href.match(/(jpg|gif|png)$/);
					// if ( !islb ) islb = /\/\/(?:www\.)?youtu(?:\.be|be\.com)\/(?:watch\?v=|embed\/)?([a-z0-9\-\_\%]+)/i.test(href); // matches https://www.youtube.com/channel/ as well...
					if ( !islb ) islb = /\/\/(?:www\.)?youtu(?:\.be\/|be\.com\/(?:watch\?v=|embed\/)+)/i.test(href);
					// if ( !islb ) islb = /\/\/(?:www\.)?vimeo.com\/([0-9a-z\-_]+)/i.test(href);
					if ( !islb ) islb = /\/\/(?:www\.)?vimeo.com\/([0-9\-_]+)/i.test(href);
					if ( !islb ) islb = /\/\/(?:www\.)?dai.ly\/([0-9a-z\-_]+)/i.test(href);
					if ( !islb ) islb =  /\/\/(?:www\.)?(?:vk\.com|vkontakte\.ru)\/(?:video_ext\.php\?)(.*)/i.test(href);
					return islb;
					}).each(function(i){
					var self    = $(this),
						href    = self.attr('href'),
						caption = '',
						child   = self.children('img'),
						alt     = self.attr('data-alt'),
						title   = self.attr('title');
					if ( !title ) title = self.attr('data-title');
					if ( !title ) title = child.attr('data-title');
					if ( !alt ) alt = child.attr('alt');

					self.attr('data-src', href).attr('data-lightbox','yes');
					if(title)   caption += '<h4>'+title+'</h4>';
					if(alt)     caption += '<p>'+alt+'</p>';
					if(caption) caption = '<div class="customHtml">'+caption+'</div>';
					if(caption) self.attr('data-sub-html', caption);

					// Add lightbox if this is not a WordPress Gallery image, not a Jetpack Tiled Gallery or explicitly told not to use lightbox
					if(!self.parent('.gallery-icon').length && !self.parent('.tiled-gallery-item').length && !self.is('.no-lightbox') && !(self.closest('.lightGallery').length)) {
						$(self.parent()).addClass('apply-lightbox');
					}
				});
				$('.apply-lightbox').lightGallery({
					selector : "a[data-lightbox='yes']" // this
				});

			}

			// Add lightbox to WordPress Gallery and Jetpack Tiled Gallery
			if ( 'undefined' == typeof hootData.lightboxWpGal || 'enable' == hootData.lightboxWpGal ) {
				$(".gallery").each(function(i){
					var galID = $(this).attr('id');
					$(this).lightGallery({
						selector : "#"+galID+" .gallery-icon > a[href$='.jpg'], #"+galID+" .gallery-icon > a[href$='.png'], #"+galID+" .gallery-icon > a[href$='.jpeg'], #"+galID+" .gallery-icon > a[href$='.gif']"
					});
				});
				$(".tiled-gallery").each(function(i){
					var galID = 'hoot-tiled-gallery-' + i;
					$(this).addClass( galID );
					$(this).lightGallery({
						selector : "."+galID+" .tiled-gallery-item > a[href$='.jpg'], ."+galID+" .tiled-gallery-item > a[href$='.png'], ."+galID+" .tiled-gallery-item > a[href$='.jpeg'], ."+galID+" .tiled-gallery-item > a[href$='.gif']"
					});
				});
			}

		}
	}

	/*** LightGallery (for brevity) ***/

	if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.lightGallery || 'enable' == hootData.lightGallery ) {
		if (typeof $.fn.lightGallery != 'undefined') {
			$(".lightGallery").lightGallery({
				selector : 'a'
			});
		}
	}

	/*** Isotope for Archive Mosaic Type ***/

	if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.isotope || 'enable' == hootData.isotope ) {
		if (typeof $.fn.isotope != 'undefined') {
			var $mosaic = $(".archive-mosaic").first().parent(),
				mosaic_relayout = function() { $mosaic.isotope( 'layout' ); };
			$mosaic.isotope({
				itemSelector: '.archive-mosaic'
			});
			//$(window).load(function() { $mosaic.isotope( 'layout' ); });
			$(window).load(mosaic_relayout); // bug fix for cases when images are without width/height atts
		}
	}

	/*** Shortcodes ***/

	/* Toggles */
	if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.scToggle || 'enable' == hootData.scToggle ) {
		$('.shortcode-toggle-head').click( function() {
			$( this ).siblings( '.shortcode-toggle-box' ).slideToggle( 'fast' );
			$( this ).toggleClass( 'shortcode-toggle-active' );
			$( this ).children( 'i' ).toggleClass( 'fa-plus fa-minus' );
		});
	}

	/* Tabset */
	if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.scTabset || 'enable' == hootData.scTabset ) {
		$('.shortcode-tabset').each(function(i){
			var self    = $(this),
				nav     = self.find('.shortcode-tabset-nav > li'),
				box     = self.children('.shortcode-tabset-box'),
				tabs    = box.children('div');

			nav.click( function() {
				var navself = $(this),
					tabid   = navself.data('tab'),
					tabself = tabs.filter('[data-tab="'+tabid+'"]');

				tabs.removeClass('current');
				tabself.addClass('current');
				nav.removeClass('current');
				navself.addClass('current');
			});
		});
	}

	/* Scroller (Divider) */
	if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.scScroller || 'enable' == hootData.scScroller ) {
		$('.shortcode-divider > a').on('click', function(e) {
			e.preventDefault();
			var target = $(this).attr('href');
			var destin = $(target).offset().top;
			if( target != '#page-wrapper')
				destin -= 50;
			$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destin}, 500 );
		});
	}

});