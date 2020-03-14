<?php
namespace EStar;

class TemplateFunctions {
	public function __construct() {
		add_filter( 'body_class', [ $this, 'add_body_classes' ] );
		add_filter( 'post_class', [ $this, 'add_post_classes' ] );
		add_filter( 'get_the_archive_title', [ $this, 'change_archive_title' ] );
		add_filter( 'excerpt_more', [ $this, 'continue_reading_link' ] );
		add_filter( 'the_content_more_link', [ $this, 'continue_reading_link' ] );

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
}