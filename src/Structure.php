<?php
namespace EStar;

class Structure {
	public static function setup() {
		add_action( 'estar_header', [ __CLASS__, 'render_header' ] );
		add_action( 'estar_footer', [ __CLASS__, 'render_footer' ] );
		add_action( 'estar_single', [ __CLASS__, 'render_single' ] );
		add_action( 'estar_archive', [ __CLASS__, 'render_archive' ] );
	}

	public static function render_header() {
		get_template_part( 'template-parts/header' );
	}

	public static function render_footer() {
		get_template_part( 'template-parts/footer' );
	}

	public static function render_single() {
		$type = is_page() ? 'page' : 'single';
		get_template_part( "template-parts/$type" );
	}

	public static function render_archive() {
		get_template_part( 'template-parts/archive' );
	}
}