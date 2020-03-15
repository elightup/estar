<?php
namespace EStar\Colors;

class CSS {
	private $elements;

	public function __construct() {
		$this->elements = Colors::get_elements();
		add_action( 'wp_head', [ $this, 'output' ] );
	}

	public function output() {
		$css = [];

		foreach ( $this->elements as $id => $element ) {
			$color = get_theme_mod( $id );
			if ( $color ) {
				$css[] = sprintf( '--%s: %s;', $id, $color );
			}
		}

		// Only include custom colors in customizer or frontend.
		if ( is_customize_preview() || $css ) {
			echo "<style id='estar-colors'>\n:root {\n", esc_html( implode( "\n", $css ) ), "\n}\n</style>\n";
		}
	}
}
