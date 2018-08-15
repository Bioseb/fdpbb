jQuery(document).ready(function($) {
	"use strict";

	/*** Top Button ***/
	if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.topButton || 'enable' == hootData.topButton ) {
		// Scrollpoints
		if (typeof $.fn.hootScroller != 'undefined')
			$('.fixed-goto-top').hootScroller({padding:0});
		// Waypoints
		var $top_btn = $('.waypoints-goto-top');
		if ( $top_btn.length ) {
			if (typeof Waypoint === "function") {
				var waypoints = $('#page-wrapper').waypoint(function(direction) {
					if(direction=='down')
						$top_btn.addClass('topshow');
					if(direction=='up')
						$top_btn.removeClass('topshow');
					},{offset: '-80%'});
			} else {
				$top_btn.addClass('topshow');
			}
		}
	}

	/*** Watch all links within .scrollpoints container and links with .scrollpoint ***/
	/*** Used for implementing Menu Scroll ***/
	if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.scrollpointsContainer || 'enable' == hootData.scrollpointsContainer ) {
		// Scrollpoints
		if (typeof $.fn.hootScroller != 'undefined')
			$('.scrollpointscontainer a, a.scrollpoint').hootScroller();
	}

	/*** Scroll on URL Load ***/
	// Scroll on url load has a few inherent issues. Complying with standard url hash structure, we
	// cant override browser behavior. Adopting additional methods (prepend hash tag with unique id,
	// or using query args instead of hash) leads to non standard url (what if when user changes
	// themes).
	// Hence possible solution for now: Pepend hash tag with unique id using scroller js only..
	if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.urlScroller || 'enable' == hootData.urlScroller ) {
		if (typeof $.fn.hootScroller != 'undefined')
			$('#page-wrapper').hootScroller({urlLoad:true, speed:1500});
	}

	/*** Sticky Header ***/
	if( 'undefined' == typeof hootData || 'undefined' == typeof hootData.stickyHeader || 'enable' == hootData.stickyHeader ) {
		if (typeof Waypoint === "function" && $('#header.hoot-sticky-header').length) {
			var stickyHeader = new Waypoint.Sticky({
				element: $('#header.hoot-sticky-header')[0],
				// offset: -10 // fixes bug: header gets stuck when no topbar i.e. header is at top 0 at page load
				offset: -300
			});
		}
	}

});