<?php
namespace EStar;

class Layout {
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

	public static function output_sidebar( $id = 'sidebar-1', $class = 'sidebar' ) {
		if ( ! is_active_sidebar( $id ) ) {
			esc_html_e( 'Please go to Customize > Widgets and add widgets to this area.', 'estar' );
			return;
		}
		echo '<aside class="' . esc_attr( $class ) . '">';
		dynamic_sidebar( $id );
		echo '</aside>';
	}
}