<?php
namespace EStar;

class TemplateFunctions {
	public function __construct() {
		add_filter( 'body_class', [ $this, 'add_body_classes' ] );
		add_filter( 'post_class', [ $this, 'add_post_classes' ] );
		add_filter( 'get_the_archive_title', [ $this, 'change_archive_title' ] );
		add_filter( 'excerpt_more', [ $this, 'continue_reading_link' ] );
		add_filter( 'the_content_more_link', [ $this, 'continue_reading_link' ] );
		add_filter( 'nav_menu_link_attributes', [ $this, 'add_menu_link_attributes' ], 10, 4 );
	}

	/**
	 * Add custom CSS classes to body for easy styling.
	 *
	 * - Singular: .singular
	 * - Archive: .archive.hfeed. .hfeed is required for hAtom.
	 */
	public function add_body_classes( $classes ) {
		if ( is_singular() ) {
			$classes[] = 'singular';
		} else {
			$classes[] = 'archive hfeed';
		}
		return $classes;
	}

	public function add_post_classes( $classes ) {
		$classes[] = 'entry';
		return $classes;
	}

	public function change_archive_title( $title ) {
		if ( is_category() || is_tag() || is_tax() ) {
			$title = single_term_title( '', false );
		}
		return $title;
	}

	public function continue_reading_link() {
		$continue_reading = sprintf(
			// Translators: %s: Name of current post.
			__( 'Continue reading %s', 'estar' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		);
		return '<a class="more-link" href="' . esc_url( get_permalink() ) . '">' . wp_kses( $continue_reading, ['span' => ['class' => []]] ) . '</a>';
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

	/**
	 * Add a dropdown icon to top-level menu items.
	 *
	 * @param string $output Nav menu item start element.
	 * @param object $item   Nav menu item.
	 * @param int    $depth  Depth.
	 * @param object $args   Nav menu args.
	 * @return string Nav menu item start element.
	 */
	public function add_dropdown_icons( $output, $item, $depth, $args ) {
		// Only add class to 'top level' items on the 'primary' menu.
		if ( ! isset( $args->theme_location ) || 'menu-1' !== $args->theme_location ) {
			return $output;
		}

		if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
			// Add SVG icon to parent items.
			$icon = varia_get_icon_svg( 'keyboard_arrow_down', 24 );

			$output .= sprintf(
				'<button class="submenu-expand" tabindex="-1">%s</button>',
				$icon
			);
		}

		return $output;
	}
}