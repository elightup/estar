<?php
namespace EStar;

class Layout {
	public static function setup() {
		add_filter( 'body_class', [ __CLASS__, 'add_body_classes' ] );
	}

	public static function add_body_classes( $classes ) {
		$classes[] = esc_attr( self::get_layout() );
		return $classes;
	}

	public static function has_sidebar() {
		$layout = self::get_layout();
		return false === strpos( $layout, 'no-sidebar' );
	}

	public static function get_layout() {
		if ( is_page() ) {
			$layout = get_theme_mod( 'page_layout', 'no-sidebar' );
		} elseif ( is_single() ) {
			$layout = get_theme_mod( 'post_layout', 'sidebar-right' );
		} else {
			$layout = get_theme_mod( 'archive_layout', 'sidebar-right' );
		}

		return apply_filters( 'estar_layout', $layout );
	}
}