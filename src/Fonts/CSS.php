<?php
/**
 * Output CSS for custom fonts in the <head>.
 */
namespace EStar\Fonts;

class CSS {
	private $elements;
	private $fonts;

	public function __construct() {
		$this->elements = Fonts::get_elements();
		$this->fonts    = include __DIR__ . '/fonts.php';
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
		add_action( 'wp_head', [ $this, 'output' ], 20 );
	}

	public function enqueue() {
		$fonts  = [];
		$subset = [];
		foreach ( $this->elements as $id => $element ) {
			$family = get_theme_mod( "{$id}_font_family" );

			// Don't import system fonts.
			if ( ! $family || in_array( $family, ['serif', 'sans-serif'] ) ) {
				continue;
			}
			$font = $this->get_font_settings( $family );
			if ( ! $font ) {
				continue;
			}
			$fonts[ $family] = isset( $fonts[ $family] ) ? $fonts[ $family] : [];
			$fonts[ $family ][] = get_theme_mod( "{$id}_font_style" );
			$subset           = array_merge( $subset, $font['subsets'] );
		}
		if ( ! $fonts ) {
			return;
		}
		foreach ( $fonts as $family => $styles ) {
			$styles = implode( ',', array_filter( $styles ) );
			$fonts[ $family ] = $styles ? "$family:$styles" : $family;
		}

		$fonts_url = add_query_arg(
			[
				'family'  => rawurlencode( implode( '|', $fonts ) ),
				'subset'  => rawurlencode( implode( ',', array_unique( $subset ) ) ),
				'display' => 'swap',
			],
			'https://fonts.googleapis.com/css'
		);

		wp_enqueue_style( 'estar-custom-fonts', $fonts_url );
	}

	public function output() {
		$css = [];
		foreach ( $this->elements as $id => $element ) {
			$css[] = $this->get_css( $id, $element );
		}
		$css = array_filter( $css );

		// Only include custom colors in customizer or frontend.
		if ( is_customize_preview() || $css ) {
			echo "<style id='estar-fonts'>\n", wp_strip_all_tags( implode( "\n", $css ) ), "\n</style>\n";
		}
	}

	/**
	 * Get CSS for a single element.
	 *
	 * @param  string $id      Element ID.
	 * @param  array  $element Element parameter.
	 *
	 * @return string
	 */
	private function get_css( $id, $element ) {
		$rules      = [];
		$selector   = $element['selector'];
		$properties = array(
			'font_family',
			'font_style',
			'font_size',
			'line_height',
			'letter_spacing',
			'text_transform',
		);
		foreach ( $properties as $property ) {
			$value = get_theme_mod( "{$id}_{$property}" );
			if ( ! $value ) {
				continue;
			}
			switch ( $property ) {
				case 'font_family':
					if ( 'sans-serif' === $value ) {
						$value = 'var(--font-sans)';
					} elseif ( 'serif' === $value ) {
						$value = 'var(--font-serif)';
					} elseif ( $font = $this->get_font_settings( $value ) ) {
						$value = sprintf( '"%s", %s', $value, $font['category'] );
					}
					break;
				case 'font_style':
					$font_weight = $value;
					$font_style  = 'normal';
					if ( false !== strpos( $value, 'italic' ) ) {
						$font_weight = str_replace( 'italic', '', $value );
						$font_style  = 'italic';
					}
					$rules[] = "font-weight: $font_weight";
					if ( $font_style ) {
						$rules[] = "font-style: $font_style";
					}
					continue 2;
				case 'font_size':
				case 'letter_spacing':
					$value .= get_theme_mod( "{$id}_{$property}_unit", 'px' );
					break;
				case 'line_height':
					$value .= get_theme_mod( "{$id}_{$property}_unit" );
					break;
			}
			$rules[] = sprintf( '%s: %s', str_replace( '_', '-', $property ), $value );
		}

		return $rules ? "$selector { " . implode( '; ', $rules ) . ' }' : '';
	}

	private function get_font_settings( $family ) {
		foreach ( $this->fonts as $font ) {
			if ( $font['family'] === $family ) {
				return $font;
			}
		}
		return null;
	}
}
