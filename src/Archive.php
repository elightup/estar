<?php
namespace EStar;

class Archive {
	private $sanitizer;

	public function __construct( $sanitizer ) {
		$this->sanitizer = $sanitizer;

		add_action( 'customize_register', [ $this, 'register' ] );

		add_filter( 'body_class', [ $this, 'add_body_classes' ] );

		add_filter( 'excerpt_more', [ $this, 'continue_reading_link' ] );
		add_filter( 'the_content_more_link', [ $this, 'continue_reading_link' ] );

		add_filter( 'excerpt_length', [ $this, 'change_excerpt_length' ] );

		add_filter( 'get_the_archive_title', [ $this, 'change_archive_title' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->add_section( 'archive', [
			'title'    => esc_html__( 'Archive', 'estar' ),
			'priority' => '1200',
		] );

		$wp_customize->add_setting( 'archive_layout', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'list-horizontal sidebar-right',
		] );
		$wp_customize->add_control( 'archive_layout', [
			'label'   => esc_html__( 'Layout', 'estar' ),
			'section' => 'archive',
			'type'    => 'select',
			'choices' => [
				'list-horizontal sidebar-right' => __( 'List (Horizontal) - Sidebar Right', 'estar' ),
				'list-horizontal sidebar-left'  => __( 'List (Horizontal) - Sidebar Left', 'estar' ),
				'list-horizontal no-sidebar'    => __( 'List (Horizontal) - No Sidebar', 'estar' ),
				'list-vertical sidebar-right'   => __( 'List (Vertical) - Sidebar Right', 'estar' ),
				'list-vertical sidebar-left'    => __( 'List (Vertical) - Sidebar Left', 'estar' ),
				'list-vertical no-sidebar'      => __( 'List (Vertical) - No Sidebar', 'estar' ),
				'grid sidebar-right'            => __( 'Grid - Sidebar Right', 'estar' ),
				'grid sidebar-left'             => __( 'Grid - Sidebar Left', 'estar' ),
				'grid no-sidebar'               => __( 'Grid - No Sidebar', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'archive_content', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'excerpt',
		] );
		$wp_customize->add_control( 'archive_content', [
			'label'   => esc_html__( 'Content Display', 'estar' ),
			'section' => 'archive',
			'type'    => 'select',
			'choices' => [
				'content' => __( 'Content', 'estar' ),
				'excerpt' => __( 'Excerpt', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'archive_excerpt_length', [
			'sanitize_callback' => 'absint',
			'default'           => 55,
		] );
		$wp_customize->add_control( 'archive_excerpt_length', [
			'label'   => esc_html__( 'Excerpt Length', 'estar' ),
			'section' => 'archive',
			'type'    => 'number',
		] );

		$wp_customize->add_setting( 'archive_continue_text', [
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => __( 'Continue reading', 'estar' ),
		] );
		$wp_customize->add_control( 'archive_continue_text', [
			'label'   => esc_html__( 'Continue Reading Text', 'estar' ),
			'section' => 'archive',
			'type'    => 'text',
		] );
	}

	public function add_body_classes( $classes ) {
		if ( is_singular() ) {
			return $classes;
		}
		$classes[] = 'archive hfeed'; // .hfeed is required for hAtom.
		$classes[] = get_theme_mod( 'archive_layout', 'list-horizontal sidebar-right' );
		return $classes;
	}

	public function continue_reading_link() {
		$text = get_theme_mod( 'archive_continue_text', __( 'Continue reading', 'estar' ) );
		$text .= the_title( ' <span class="screen-reader-text">', '</span>', false );
		return '<p class="more"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . wp_kses_post( $text ) . '</a></p>';
	}

	public function change_excerpt_length( $length ) {
		return get_theme_mod( 'archive_excerpt_length', 55 );
	}

	public function change_archive_title( $title ) {
		if ( is_category() || is_tag() || is_tax() ) {
			$title = single_term_title( '', false );
		}
		return $title;
	}
}