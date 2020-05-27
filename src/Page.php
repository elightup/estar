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

		$wp_customize->add_setting( 'page_thumbnail_position', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'thumbnail-before-header',
		] );
		$wp_customize->add_control( 'page_thumbnail_position', [
			'label'   => esc_html__( 'Thumbnail Position', 'estar' ),
			'section' => 'page',
			'type'    => 'select',
			'choices' => [
				'thumbnail-header-background' => __( 'As Page Header Background', 'estar' ),
				'thumbnail-before-header'     => __( 'Before Page Header', 'estar' ),
				'thumbnail-after-header'      => __( 'After Page Header', 'estar' ),
				'no-thumbnail'                => __( 'Do Not Display', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'page_header_align', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'left',
		] );
		$wp_customize->add_control( 'page_header_align', [
			'label'   => esc_html__( 'Header Alignment', 'estar' ),
			'section' => 'page',
			'type'    => 'select',
			'choices' => [
				'left'   => __( 'Left', 'estar' ),
				'right'  => __( 'Right', 'estar' ),
				'center' => __( 'Center', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'page_header_height', [
			'sanitize_callback' => 'absint',
		] );
		$wp_customize->add_control( 'page_header_height', [
			'label'       => esc_html__( 'Header Height (px)', 'estar' ),
			'section'     => 'page',
			'type'        => 'number',
			'description' => esc_html__( 'Works only when the thumbnail is set as header background.', 'estar' ),
		] );
	}

	public function add_body_classes( $classes ) {
		if ( ! is_page() ) {
			return $classes;
		}
		if ( ! is_page_template() ) {
			$classes[] = 'entry-header-' . esc_attr( get_theme_mod( 'page_header_align', 'left' ) );
		}

		return $classes;
	}

}