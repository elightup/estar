( function ( document, customize, WebFont, settings ) {
	'use strict';

	if ( typeof settings === 'undefined' ) {
		return;
	}

	let style = document.querySelector( '#estar-fonts' );

	function loadFont( id ) {
		const fontFamily = customize.get()[id + '_font_family'];
		if ( ! fontFamily || fontFamily === 'sans-serif' || fontFamily === 'serif' ) {
			return;
		}
		WebFont.load( {
			google: {
				families: [fontFamily + ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic:cyrillic,greek,latin,greek-ext,cyrillic-ext,latin-ext,vietnamese']
			}
		} );
	}

	function buildCSS( id ) {
		let rules = [],
			properties = [
				'font_family',
				'font_style',
				'font_size',
				'line_height',
				'letter_spacing',
				'text_transform',
			];

		properties.forEach( function( property ) {
			let value = customize.get()[id + '_' + property];
			if ( ! value ) {
				return;
			}

			switch ( property ) {
				case 'font_family':
					if ( 'sans-serif' === value ) {
						value = 'var(--font-sans)';
					} else if ( 'serif' === value ) {
						value = 'var(--font-serif)';
					}
					break;
				case 'font_style':
					let fontWeight = value,
						fontStyle  = 'normal';
					if ( -1 !== value.indexOf( 'italic' ) ) {
						fontWeight = value.replace( 'italic', '' );
						fontStyle  = 'italic';
					}
					fontWeight = 'regular' === fontWeight ? '400' : fontWeight;
					rules.push( 'font-weight: ' + fontWeight );
					rules.push( 'font-style: ' + fontStyle );
					return;
				case 'font_size':
				case 'letter_spacing':
					let unit = customize.get()[id + '_' + property + '_unit'];
					unit = unit || 'px';
					value += unit;
					break;
				case 'line_height':
					let lhUnit = customize.get()[id + '_' + property + '_unit'];
					value += lhUnit;
					break;
			}
			rules.push( property.replace( '_', '-' ) + ': ' + value );
		} );

		return rules.length ? settings[id].selector + ' { ' + rules.join( '; ' ) + ' }' : '';
	}

	function listenForChange( id ) {
		const properties = [
			'font_family',
			'font_style',
			'font_size',
			'font_size_unit',
			'line_height',
			'line_height_unit',
			'letter_spacing',
			'letter_spacing_unit',
			'text_transform',
		];

		const refreshCSS = function () {
			loadFont( id );

			let css = style.innerHTML,
				rule = buildCSS( id ),
				regex = new RegExp( settings[id].selector + ' { .*? }', 'g' );

			if ( regex.test( css ) ) {
				css = css.replace( regex, rule );
			} else {
				css += "\n" + rule;
			}
			style.innerHTML = css;
		};

		properties.forEach( function( property ) {
			customize( id + '_' + property, function ( setting ) {
				setting.bind( refreshCSS );
			} );
		} );
	}

	settings.base = {selector: 'body'};
	settings.headings = {selector: 'h1,h2,h3,h4,h5,h6'};

	Object.keys( settings ).forEach( listenForChange );
} )( document, wp.customize, WebFont, EStar_Fonts_Settings );
