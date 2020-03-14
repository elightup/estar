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
		add_filter( 'walker_nav_menu_start_el', [ $this, 'add_dropdown_icons' ], 10, 4 );
	}

	public function add_body_classes( $classes ) {
		if ( is_singular() ) {
			$classes[] = 'singular';
		} else {
			$classes[] = 'archive hfeed'; // .hfeed is required for hAtom.
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

	public function add_dropdown_icons( $output, $item, $depth, $args ) {
		if ( isset( $args->theme_location ) && 'menu-1' === $args->theme_location && in_array( 'menu-item-has-children', $item->classes, true ) ) {
			$output = str_replace( '</a>', '<span class="submenu-toggle" role="button" tabindex="-1"></span></a>', $output );
		}
		return $output;
	}
}