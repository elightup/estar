<?php
namespace EStar\Colors;

class CSS {
	private $elements;

	public function __construct() {
		$this->elements = Colors::get_elements();
		add_action( 'wp_head', [ $this, 'output_frontend' ] );
        add_action( 'admin_head', [ $this, 'output_admin' ] );
	}

	public function output_frontend() {
		$css = $this->get_css();

		// Only include custom colors in customizer or frontend.
		if ( is_customize_preview() || $css ) {
			echo "\n<style id='estar-colors'>\n:root {\n\t", esc_html( implode( "\n\t", $css ) ), "\n}\n</style>\n";
		}
	}

	public function output_admin() {
        $screen = get_current_screen();
		$css = $this->get_css();
        if ( ! $screen || ! $screen->is_block_editor() || ! $css ) {
            return;
        }

		echo "\n<style>\n.editor-styles-wrapper.editor-styles-wrapper {\n\t", esc_html( implode( "\n\t", $css ) ), "\n}\n</style>\n";
	}

	private function get_css() {
		$css = [];

		foreach ( $this->elements as $id => $element ) {
			$color = get_theme_mod( $id );
			if ( $color ) {
				$css[] = sprintf( '--%s: %s;', $id, $color );
			}
		}

		return $css;
	}
}
