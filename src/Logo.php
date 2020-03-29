<?php
namespace EStar;

class Logo {
	public function setup() {
		add_action( 'after_setup_theme', [ $this, 'add_theme_support' ] );
		add_action( 'customize_register', [ $this, 'add_customizer_settings' ] );
	}

	public function add_theme_support() {
		add_theme_support( 'custom-logo' );
	}

	public function add_customizer_settings( $wp_customize ) {
		$wp_customize->add_setting( 'svg_logo' );
		$wp_customize->add_control( 'svg_logo', [
			'label'    => esc_html__( 'SVG Logo', 'thefour' ),
			'section'  => 'title_tagline',
			'type'     => 'textarea',
			'priority' => 9, // After default logo.
		] );
	}

	public function output() {
		printf( '<a href="%s" class="logo" rel="home">%s</a>', esc_url( home_url( '/' ) ), $this->get_logo() );
	}

	private function get_logo() {
		$logo = get_theme_mod( 'svg_logo' );
		$logo = $logo ? wp_kses( $logo, SVG::get_allowed_tags() ) : $this->get_wordpress_logo();
		return apply_filters( 'estar_logo', $logo );
	}

	private function get_wordpress_logo() {
		$logo_id = get_theme_mod( 'custom_logo' );
		if ( ! $logo_id ) {
			return null;
		}
		$logo = wp_get_attachment_image_src( $logo_id, 'full', false );
		if ( empty( $logo ) ) {
			return null;
		}
		return sprintf( '<img src="%s" width="%s" height="%s" alt="%s">', esc_url( $logo[0] ), intval( $logo[1] ), intval( $logo[2] ), esc_attr( get_bloginfo( 'name' ) ) );
	}
}