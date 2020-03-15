( function ( document, customize, settings ) {
	'use strict';

	if ( typeof settings === 'undefined' ) {
		return;
	}

	const style = document.querySelector( '#estar-colors' );

	settings.forEach( function( id ) {
		const regex = new RegExp( '--' + id + ': .*?;', 'g' );

		customize( id, function ( value ) {
			value.bind( function ( to ) {
				let css = style.innerHTML,
					rule = '--' + id + ': ' + to + ';';

				if ( regex.test( css ) ) {
					css = css.replace( regex, rule );
				} else {
					css = css.replace( '}', rule + "\n}" );
				}
				style.innerHTML = css;
			} );
		} );
	} );
} )( document, wp.customize, EStar_Colors_Settings );
