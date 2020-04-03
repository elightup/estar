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
			'priority' => Customizer::get_priority( 'page' ),
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

		$wp_customize->add_setting( 'page_thumbnail', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'thumbnail-before-header',
		] );
		$wp_customize->add_control( 'page_thumbnail', [
			'label'   => esc_html__( 'Page Thumbnail', 'estar' ),
			'section' => 'page',
			'type'    => 'select',
			'choices' => [
				'thumbnail-header-background' => __( 'As page Header Background', 'estar' ),
				'thumbnail-before-header'     => __( 'Before page Header', 'estar' ),
				'thumbnail-after-header'      => __( 'After page Header', 'estar' ),
				'no-thumbnail'                => __( 'Do not display', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'page_header_align', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'left',
		] );
		$wp_customize->add_control( 'page_header_align', [
			'label'   => esc_html__( 'Page Header Alignment', 'estar' ),
			'section' => 'page',
			'type'    => 'select',
			'choices' => [
				'left'   => __( 'Left', 'estar' ),
				'right'  => __( 'Right', 'estar' ),
				'center' => __( 'Center', 'estar' ),
			],
		] );
	}

	public function add_body_classes( $classes ) {
		if ( ! is_page() ) {
			return $classes;
		}
		$classes[] = 'singular';
		$classes[] = get_theme_mod( 'page_layout', 'no-sidebar' );

		$thumbnail = get_theme_mod( 'page_thumbnail', 'thumbnail-before-header' );
		if ( has_post_thumbnail() || 'thumbnail-header-background' !== $thumbnail ) {
			$classes[] = $thumbnail;
		}
		$classes[] = 'entry-header-' . get_theme_mod( 'page_header_align', '' );
		return $classes;
	}

}