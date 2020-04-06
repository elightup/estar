<?php
namespace EStar;

class Customizer {
	private $sanitizer;

	public function __construct( $sanitizer ) {
		$this->sanitizer = $sanitizer;

		add_action( 'customize_register', [ $this, 'register' ] );
		add_action( 'customize_preview_init', [ $this, 'enqueue_preview_js' ] );

		add_filter( 'body_class', [ $this, 'add_body_classes' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		// Header.
		$wp_customize->get_section( 'title_tagline' )->title = esc_html__( 'Header', 'estar' );
		$wp_customize->get_section( 'title_tagline' )->priority = self::get_priority( 'header' );

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

	public function enqueue_preview_js() {
		wp_enqueue_script( 'estar-customizer', get_template_directory_uri() . '/js/customizer.js', ['customize-preview'], '1.0.0', true );
	}

	public function add_body_classes( $classes ) {
		if ( get_theme_mod( 'header_sticky', true ) ) {
			$classes[] = 'header-sticky';
		}
		if ( ! get_theme_mod( 'show_site_name', true ) ) {
			$classes[] = 'hide-site-name';
		}
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