<?php
namespace EStar;

class Page {
	private $sanitizer;

	public function __construct( $sanitizer ) {
		$this->sanitizer = $sanitizer;
		add_action( 'customize_register', [ $this, 'register' ] );
		add_filter( 'body_class', [ $this, 'add_body_classes' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->add_section( 'page', [
			'title'    => esc_html__( 'Page', 'estar' ),
			'priority' => '1400',
		] );

		$wp_customize->add_setting( 'page_layout', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'no-sidebar',
		] );
		$wp_customize->add_control( 'page_layout', [
			'label'   => esc_html__( 'Layout', 'estar' ),
			'section' => 'page',
			'type'    => 'select',
			'choices' => [
				'sidebar-right' => __( 'Sidebar Right', 'estar' ),
				'sidebar-left'  => __( 'Sidebar Left', 'estar' ),
				'no-sidebar'    => __( 'No Sidebar', 'estar' ),
			],
		] );
	}

	public function add_body_classes( $classes ) {
		if ( ! is_page() ) {
			return $classes;
		}
		$classes[] = 'singular';
		$classes[] = get_theme_mod( 'page_layout', 'no-sidebar' );
		return $classes;
	}
}