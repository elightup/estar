<?php
namespace EStar;

class Logo {
	private $sanitizer;

	public function __construct( $sanitizer ) {
		$this->sanitizer = $sanitizer;
	}
	public function setup() {
		add_action( 'after_setup_theme', [ $this, 'add_theme_support' ] );
		add_action( 'customize_register', [ $this, 'add_customizer_settings' ] );
		add_filter( 'body_class', [ $this, 'add_body_classes' ] );
	}

	public function add_theme_support() {
		add_theme_support( 'custom-logo' );
	}

	public function add_customizer_settings( $wp_customize ) {
		$wp_customize->add_setting( 'svg_logo', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_svg' ],
		] );
		$wp_customize->add_control( 'svg_logo', [
			'label'    => esc_html__( 'SVG Logo', 'thefour' ),
			'section'  => 'title_tagline',
			'type'     => 'textarea',
			'priority' => 9, // After default logo.
		] );

		$wp_customize->add_setting( 'hide_site_name', array(
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
		) );
		$wp_customize->add_control( 'hide_site_name', array(
			'label'   => esc_html__( 'Hide site title and tagline', 'thefour' ),
			'section' => 'title_tagline',
			'type'    => 'checkbox',
			'priority' => 20, // After tagline.
		) );
	}

	public function add_body_classes( $classes ) {
		if ( get_theme_mod( 'hide_site_name' ) ) {
			$classes[] = 'hide-site-name';
		}
		return $classes;
	}

	public static function output() {
		printf( '<a href="%s" class="logo" rel="home">%s</a>', esc_url( home_url( '/' ) ), wp_kses( self::get_logo(), SVG::get_allowed_tags() ) );
	}

	private static function get_logo() {
		$logo = get_theme_mod( 'svg_logo' );
		$logo = $logo ?: self::get_wordpress_logo();
		return apply_filters( 'estar_logo', $logo );
	}

	private static function get_wordpress_logo() {
		$logo_id = get_theme_mod( 'custom_logo' );
		if ( ! $logo_id ) {
			return null;
		}
		$logo = wp_get_attachment_image_src( $logo_id, 'full', false );
		if ( empty( $logo ) ) {
			return null;
		}
		return sprintf( '<img src="%s" width="%s" height="%s" alt="%s">', $logo[0], $logo[1], $logo[2], get_bloginfo( 'name' ) );
	}
}