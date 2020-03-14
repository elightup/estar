/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function( window, document, i18n ) {
	function toggleMenu() {
		const container = document.querySelector( '.site-navigation' ),
			menu = container.querySelector( 'ul' ),
			button = container.querySelector( 'button' );

		menu.setAttribute( 'aria-expanded', 'false' );
		button.addEventListener( 'click', () => {
			if ( container.classList.contains( 'is-open' ) ) {
				button.setAttribute( 'aria-expanded', 'false' );
				menu.setAttribute( 'aria-expanded', 'false' );
			} else {
				button.setAttribute( 'aria-expanded', 'true' );
				menu.setAttribute( 'aria-expanded', 'true' );
			}
			container.classList.toggle( 'is-open' );
		} );
	}

	// @link https://www.w3.org/WAI/tutorials/menus/flyout/
	function toggleSubmenu() {
		const container = document.querySelector( '.site-navigation' );

		// Add toggle button.
		[...container.querySelectorAll( '.menu-item-has-children > a' )].forEach( a => {
			const button = `<button class="submenu-toggle"><span class="screen-reader-text">${i18n.submenuToggle.replace( '%s', a.text )}</span></span></button>`;
			a.insertAdjacentHTML( 'afterend', button );
		} );

		// Toggle submenu.
		container.addEventListener( 'click', e => {
			if ( ! e.target.classList.contains( 'submenu-toggle' ) ) {
				return;
			}
			e.preventDefault();
			if ( e.target.parentNode.classList.contains( 'is-open' ) ) {
				e.target.previousElementSibling.setAttribute( 'aria-expanded', 'false' );
				e.target.setAttribute( 'aria-expanded', 'false' );
			} else {
				console.log( 'asf' );
				e.target.previousElementSibling.setAttribute( 'aria-expanded', 'true' );
				e.target.setAttribute( 'aria-expanded', 'true' );
			}
			e.target.parentNode.classList.toggle( 'is-open' );
		} );
	}

	if ( window.screen.width < 1024 ) {
		toggleMenu();
		toggleSubmenu();
	}
} )( window, document, EStar );
