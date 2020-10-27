<?php
namespace EStar;

use EStar\Customizer\Sections\Link;

class Customizer {
	private $sanitizer;

	public function __construct( $sanitizer ) {
		$this->sanitizer = $sanitizer;

		add_action( 'customize_register', [ $this, 'register' ] );
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue' ] );
		add_action( 'customize_preview_init', [ $this, 'enqueue_preview_js' ] );

		add_filter( 'body_class', [ $this, 'add_body_classes' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		// Links.
		$wp_customize->register_section_type( Link::class );
		$wp_customize->add_section( new Link( $wp_customize, 'estar', [
			'title'    => esc_html__( 'Need help setting up your site?', 'estar' ),
			'url'      => esc_url( apply_filters( 'estar_docs_url', 'https://gretathemes.com/docs/estar/?utm_source=WordPress&utm_medium=link&utm_campaign=estar' ), 'estar' ),
			'priority' => 0,
		] ) );

		// Header.
		$wp_customize->get_section( 'title_tagline' )->title = esc_html__( 'Header', 'estar' );
		$wp_customize->get_section( 'title_tagline' )->priority = self::get_priority( 'header' );

		$wp_customize->add_setting( 'header_width', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'wide',
		] );
		$wp_customize->add_control( 'header_width', [
			'label'    => esc_html__( 'Header width', 'estar' ),
			'section'  => 'title_tagline',
			'type'     => 'select',
			'priority' => 1,
			'choices'  => [
				'full'   => esc_html__( 'Full width', 'estar' ),
				'wide'   => esc_html__( 'Wide', 'estar' ),
				'narrow' => esc_html__( 'Narrow', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'menu_position', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'right',
		] );
		$wp_customize->add_control( 'menu_position', [
			'label'    => esc_html__( 'Menu position', 'estar' ),
			'section'  => 'title_tagline',
			'type'     => 'select',
			'priority' => 2,
			'choices'  => [
				'right'  => esc_html__( 'Right', 'estar' ),
				'bottom' => esc_html__( 'Bottom', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'show_site_name', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
			'default'           => true,
		] );
		$wp_customize->add_control( 'show_site_name', [
			'label'   => esc_html__( 'Show site title and tagline', 'estar' ),
			'section' => 'title_tagline',
			'type'    => 'checkbox',
		] );

		$wp_customize->add_setting( 'header_sticky', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
			'default'           => true,
		] );
		$wp_customize->add_control( 'header_sticky', [
			'label'   => esc_html__( 'Make header sticky', 'estar' ),
			'section' => 'title_tagline',
			'type'    => 'checkbox',
		] );

		$wp_customize->add_setting( 'header_search', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
			'default'           => true,
		] );
		$wp_customize->add_control( 'header_search', [
			'label'   => esc_html__( 'Show search button', 'estar' ),
			'section' => 'title_tagline',
			'type'    => 'checkbox',
		] );

		$wp_customize->add_setting( 'header_search_form', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
			'default'           => false,
		] );
		$wp_customize->add_control( 'header_search_form', [
			'label'   => esc_html__( 'Show search form', 'estar' ),
			'section' => 'title_tagline',
			'type'    => 'checkbox',
		] );

		$wp_customize->add_setting( 'highlight_last_item', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
			'default'           => false,
		] );
		$wp_customize->add_control( 'highlight_last_item', [
			'label'   => esc_html__( 'Highlight last menu item as button', 'estar' ),
			'section' => 'title_tagline',
			'type'    => 'checkbox',
		] );

		// Footer.
		$wp_customize->add_section( 'footer', [
			'title'    => esc_html__( 'Footer', 'estar' ),
			'priority' => self::get_priority( 'footer' ),
		] );

		$wp_customize->add_setting( 'footer_copyright', [
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
			// Translators: %1$s - Current year, %2$s - Blog name, %3$s - Theme name, %4$s - Theme shop name.
			'default'           => sprintf( __( 'Copyright &copy; %1$s %2$s. Theme %3$s by %4$s.', 'estar' ), gmdate( 'Y' ), get_bloginfo( 'name' ), '<a href="https://gretathemes.com/wordpress-themes/estar/">eStar</a>', 'GretaThemes' ),
		] );
		$wp_customize->add_control( 'footer_copyright', [
			'label'   => esc_html__( 'Copyright Text', 'estar' ),
			'section' => 'footer',
			'type'    => 'textarea',
		] );
	}

	public function enqueue() {
		wp_enqueue_style( 'estar-customizer', get_template_directory_uri() . '/src/Customizer/assets/link.css', '1.0.0' );
		wp_enqueue_script( 'estar-customizer', get_template_directory_uri() . '/src/Customizer/assets/link.js', ['customize-controls'], '1.0.0', true );
	}

	public function enqueue_preview_js() {
		wp_enqueue_script( 'estar-customizer-preview', get_template_directory_uri() . '/js/customizer.js', ['customize-preview'], '1.0.0', true );
	}

	public function add_body_classes( $classes ) {
		if ( get_theme_mod( 'header_sticky', true ) ) {
			$classes[] = 'header-sticky';
		}
		if ( ! get_theme_mod( 'show_site_name', true ) ) {
			$classes[] = 'hide-site-name';
		}
		$classes[] = 'header-' . get_theme_mod( 'header_width', 'wide' );
		if ( get_theme_mod( 'header_search_form', false ) ) {
			$classes[] = 'header-search-form';
		}
		if ( get_theme_mod( 'highlight_last_item', false ) ) {
			$classes[] = 'header-highlight-last-item';
		}
		$classes[] = 'menu-' . get_theme_mod( 'menu_position', 'right' );

		return $classes;
	}

	public static function get_priority( $id ) {
		$priorities = [
			'colors'  => 1000,
			'fonts'   => 1100,
			'header'  => 1200,
			'archive' => 1300,
			'post'    => 1400,
			'page'    => 1500,
			'footer'  => 1600,
		];
		return $priorities[ $id ];
	}
}