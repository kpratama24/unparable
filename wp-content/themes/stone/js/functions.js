/**
 * Functionality specific to stone.
 *
 * Provides helper functions to enhance the theme experience.
 */

( function( $ ) {
	var body    = $( 'body' ),
	    _window = $( window ),
		nav, button, menu;

	nav = $( '#site-navigation' );
	button = nav.find( '.menu-toggle' );
	menu = nav.find( '.nav-menu' );

	/**
	 * Enables menu toggle for small screens.
	 */
	( function() {
		if ( ! nav || ! button ) {
			return;
		}

		// Hide button if menu is missing or empty.
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		button.on( 'click.stone', function() {
			nav.toggleClass( 'toggled-on' );
			if ( nav.hasClass( 'toggled-on' ) ) {
				$( this ).attr( 'aria-expanded', 'true' );
				menu.attr( 'aria-expanded', 'true' );
			} else {
				$( this ).attr( 'aria-expanded', 'false' );
				menu.attr( 'aria-expanded', 'false' );
			}
		} );

		// Fix sub-menus for touch devices.
		if ( 'ontouchstart' in window ) {
			menu.find( '.menu-item-has-children > a, .page_item_has_children > a' ).on( 'touchstart.stone', function( e ) {
				var el = $( this ).parent( 'li' );

				if ( ! el.hasClass( 'focus' ) ) {
					e.preventDefault();
					el.toggleClass( 'focus' );
					el.siblings( '.focus' ).removeClass( 'focus' );
				}
			} );
		}

		// Better focus for hidden submenu items for accessibility.
		menu.find( 'a' ).on( 'focus.stone blur.stone', function() {
			$( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
		} );
	} )();

	/**
	 * @summary Add or remove ARIA attributes.
	 * Uses jQuery's width() function to determine the size of the window and add
	 * the default ARIA attributes for the menu toggle if it's visible.
	 * @since Stone 1.0
	 */
	function onResizeARIA() {
		if ( 599 > _window.width() ) {
			button.attr( 'aria-expanded', 'false' );
			menu.attr( 'aria-expanded', 'false' );
			button.attr( 'aria-controls', 'primary-menu' );
		} else {
			button.removeAttr( 'aria-expanded' );
			menu.removeAttr( 'aria-expanded' );
			button.removeAttr( 'aria-controls' );
		}
	}

	_window
		.on( 'load.stone', onResizeARIA )
		.on( 'resize.stone', function() {
			onResizeARIA();
	} );

	/**
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
	_window.on( 'hashchange.stone', function() {
		var element = document.getElementById( location.hash.substring( 1 ) );

		if ( element ) {
			if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
				element.tabIndex = -1;
			}

			element.focus();
		}
	} );

} )( jQuery );