/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function( window, document, i18n ) {
	function toggleMenu() {
		const nav = document.querySelector( '.nav' ),
			menu = nav.querySelector( 'ul' ),
			button = nav.querySelector( 'button' );

		menu.setAttribute( 'aria-expanded', 'false' );
		button.addEventListener( 'click', () => {
			if ( nav.classList.contains( 'is-open' ) ) {
				button.setAttribute( 'aria-expanded', 'false' );
				menu.setAttribute( 'aria-expanded', 'false' );
			} else {
				button.setAttribute( 'aria-expanded', 'true' );
				menu.setAttribute( 'aria-expanded', 'true' );
			}
			nav.classList.toggle( 'is-open' );
		} );
	}

	// @link https://www.w3.org/WAI/tutorials/menus/flyout/
	function toggleSubmenu() {
		const nav = document.querySelector( '.nav' ),
			event = /iphone|ipad/gi.test( navigator.appVersion ) ? 'touchstart' : 'click';

		nav.addEventListener( event, e => {
			if ( ! e.target.classList.contains( 'submenu-toggle' ) ) {
				return;
			}
			e.preventDefault();
			const a = e.target.parentNode, li = a.parentNode;
			if ( li.classList.contains( 'is-open' ) ) {
				a.nextElementSibling.setAttribute( 'aria-expanded', 'false' );
				a.setAttribute( 'aria-expanded', 'false' );
			} else {
				a.nextElementSibling.setAttribute( 'aria-expanded', 'true' );
				a.setAttribute( 'aria-expanded', 'true' );
			}
			li.classList.toggle( 'is-open' );
		} );
	}

	if ( window.screen.width < 1024 ) {
		toggleMenu();
		toggleSubmenu();
	}
} )( window, document, EStar );
