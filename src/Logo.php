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
		$wp_customize->add_setting( 'hide_site_name', array(
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
		) );
		$wp_customize->add_control( 'hide_site_name', array(
			'label'   => esc_html__( 'Hide site title and tagline', 'estar' ),
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
}