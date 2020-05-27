<?php
namespace EStar;

class Menu {
	public function __construct() {
		add_filter( 'nav_menu_link_attributes', [ $this, 'add_menu_link_attributes' ], 10, 4 );
		add_filter( 'walker_nav_menu_start_el', [ $this, 'add_dropdown_icons' ], 10, 4 );
	}

	/**
	 * Adjustments to menu attributes to support WCAG 2.0 recommendations for flyout and dropdown menus.
	 * @link https://www.w3.org/WAI/tutorials/menus/flyout/
	 */
	public function add_menu_link_attributes( $atts, $item, $args, $depth ) {
		$item_has_children = in_array( 'menu-item-has-children', $item->classes );
		if ( $item_has_children ) {
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';
		}
		return $atts;
	}

	public function add_dropdown_icons( $output, $item, $depth, $args ) {
		if ( isset( $args->theme_location ) && 'menu-1' === $args->theme_location && in_array( 'menu-item-has-children', $item->classes, true ) ) {
			// Translators: %s - Menu item title.
			$output = '<div class="menu-text">' . $output . '<button class="sub-menu-toggle" aria-expanded="false"><span class="screen-reader-text">' . esc_html( sprintf( __( 'Show submenu for %s', 'estar' ), $item->title ) ) . '</span></button></div>';
		}
		return $output;
	}
}