(function ( document, customize, WebFont, settings ) {
	'use strict';

	if ( typeof settings === 'undefined' ) {
		return;
	}

	var style = document.querySelector( '#estar-fonts' );

	function loadFont( id ) {
		var fontFamily = customize.get()[id + '_font_family'];
		if ( ! fontFamily ) {
			return;
		}
		WebFont.load({
			google: {
				families: [fontFamily + ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic:cyrillic,greek,latin,greek-ext,cyrillic-ext,latin-ext,vietnamese']
			}
		});
	}

	function buildCSS( id ) {
		var rules = [],
			properties = [
				'font_family',
				'font_style',
				'font_size',
				'line_height',
				'letter_spacing',
				'text_transform',
			];

		properties.forEach( function( property ) {
			var value = customize.get()[id + '_' + property];
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
					var fontWeight = value,
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
					var unit = customize.get()[id + '_' + property + '_unit'];
					unit = unit || 'px';
					value += unit;
					break;
				case 'line_height':
					var lhUnit = customize.get()[id + '_' + property + '_unit'];
					value += lhUnit;
					break;
			}
			rules.push( property.replace( '_', '-' ) + ': ' + value );
		} );

		return rules.length ? settings[id].selector + ' { ' + rules.join( '; ' ) + ' }' : '';
	}

	function listenForChange( id ) {
		var properties = [
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

		var refreshCSS = function () {
			loadFont( id );

			var css = style.innerHTML,
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

	Object.keys( settings ).forEach( listenForChange );
})( document, wp.customize, WebFont, EStar_Fonts_Settings );
