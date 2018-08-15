"use strict";

(function ($) {

	/*** Scrollpoints ***/

	$.fn.hootScroller = function (options) {

		var hootScrollSpeed = 500,
			hootScrollPadding = 50;
		if( 'undefined' != typeof hootData && 'undefined' != typeof hootData.customScrollerSpeed )
			hootScrollSpeed = hootData.customScrollerSpeed;
		if( 'undefined' != typeof hootData && 'undefined' != typeof hootData.customScrollerPadding )
			hootScrollPadding = hootData.customScrollerPadding;

		// Options
		var settings = $.extend({
			urlLoad: false,                 // value: boolean
			speed: hootScrollSpeed,         // value: integer
			padding: hootScrollPadding,     // value: integer
		}, options);

		// Scroll to hash
		if (typeof hootScrollToHash == 'undefined') {
			var hootScrollToHash = function( target ) {
				target = target.replace("#scrollpoint-", "#"); // replace first occurence
				if ( target.length > 1 ){
					var $target = $( target );
					if ( $target.length ) {
						var destin = $target.offset().top - settings.padding;
						$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destin}, settings.speed );
						return true;
					}
				}
				return false;
			};
		};

		return this.each(function () {
			if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.scroller || 'enable' == hootData.scroller ) {

				if ( settings.urlLoad ) {
					if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.scrollerPageLoad || 'enable' == hootData.scrollerPageLoad ) {
						var target = window.location.hash;
						if ( target ) {
							target = target.split("&");
							target = target[0].split("?");
							target = target[0].split("=");
							hootScrollToHash(target[0]);
						}
					}
				} else {

					var $self = $(this),
						executed = '',
						parseHref = $self.attr('href');

					if(typeof parseHref != 'undefined')
						parseHref = parseHref.replace(/#([A-Za-z0-9\-\_]+)/g,'#scrollpoint-$1');
					else
						return; // Bugfix: We can break the $.each() loop at a particular iteration by making the callback function return false. Returning non-false is the same as a continue statement in a for loop; it will skip immediately to the next iteration.

					// Add namespace so when new page is loaded, the hashtag has unique namespace (this ways the script overtakes browser behavior to scroll to hashtag on pageload)
					if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.scrollerPageLoad || 'enable' == hootData.scrollerPageLoad )
						$self.attr('href', parseHref);

					$self.on('click', function(e) {
						// Only if href points to current url
						// $self.context.pathname is empty in IE11, so we need to scrape off this test
						// if ( $self.context.pathname == window.location.pathname ) {
							executed = '';
							if ( $self.context.hash )
								executed = hootScrollToHash( $self.context.hash );
							if ( !executed && $self.attr('data-scrollto') )
								executed = hootScrollToHash( $self.attr('data-scrollto') );
							if ( executed )
								e.preventDefault();
						// }
					});

				}

			}
		});

	};

}(jQuery));