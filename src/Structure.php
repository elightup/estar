<?php
namespace EStar;

class Structure {
	public function __construct() {
		add_action( 'estar_header', [ $this, 'render_header' ] );
		add_action( 'estar_footer', [ $this, 'render_footer' ] );
	}

	public function render_header() {
		if ( true === apply_filters( 'estar_header_enabled', true ) ) {
			get_template_part( 'template-parts/header' );
		}
	}

	public function render_footer() {
		if ( true === apply_filters( 'estar_footer_enabled', true ) ) {
			get_template_part( 'template-parts/footer' );
		}
	}
}