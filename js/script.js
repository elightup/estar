( function( window, document ) {
	function toggleMenu() {
		const nav = document.querySelector( '.nav' );
		if ( ! nav ) {
			return;
		}

		const menu = nav.querySelector( 'ul' ),
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
		const nav = document.querySelector( '.nav' );
		if ( ! nav ) {
			return;
		}

		const buttons = [...nav.querySelectorAll( '.sub-menu-toggle' )];

		buttons.forEach( button => {
			button.addEventListener( 'click', e => {
				e.preventDefault();
				const a = button.previousElementSibling, li = a.closest( 'li' );
				if ( li.classList.contains( 'is-open' ) ) {
					button.setAttribute( 'aria-expanded', 'false' );
					a.setAttribute( 'aria-expanded', 'false' );
				} else {
					button.setAttribute( 'aria-expanded', 'true' );
					a.setAttribute( 'aria-expanded', 'true' );
				}
				li.classList.toggle( 'is-open' );
			} );
		} );
	}

	function goToTop() {
		const button = document.querySelector( '.go-to-top' );
		if ( ! button ) {
			return;
		}
		button.addEventListener( 'click', e => {
			e.preventDefault();
			window.scrollTo( { top: 0, left: 0, behavior: 'smooth' } );
		} );
	}

	function openSearch() {
		const button = document.querySelector( '.search-open' ),
			input = document.querySelector( '.header-search .search-field' );

		if ( ! button ) {
			return;
		}

		button.addEventListener( 'click', e => {
			e.preventDefault();
			document.body.classList.add( 'header-search-open' );
			button.setAttribute( 'aria-expanded', 'true' );
			input.focus();
		} );
	}

	function closeSearch() {
		const button = document.querySelector( '.search-close' ),
			open = document.querySelector( '.search-open' );

		if ( ! button ) {
			return;
		}

		button.addEventListener( 'click', e => {
			e.preventDefault();
			document.body.classList.remove( 'header-search-open' );
			open.setAttribute( 'aria-expanded', 'false' );
			open.focus();
		} );
	}

	function setSidebarMargin() {
		if ( ! document.body.classList.contains( 'thumbnail-header-background' ) || document.body.classList.contains( 'no-sidebar' ) ) {
			return;
		}
		const entryHeader = document.querySelector( '.entry-header' ),
			sidebar = document.querySelector( '.sidebar' );

		if ( ! entryHeader || ! sidebar ) {
			return;
		}
		sidebar.style.paddingTop = `${entryHeader.clientHeight}px`;
	}

	toggleMenu();
	toggleSubmenu();
	goToTop();
	openSearch();
	closeSearch();
	setSidebarMargin();
} )( window, document );
