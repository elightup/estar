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
		$wp_customize->add_setting( 'svg_logo', array(
			'sanitize_callback' => 'wp_kses_post',
		) );
		$wp_customize->add_control( 'svg_logo', array(
			'label'    => esc_html__( 'SVG Logo', 'thefour' ),
			'section'  => 'title_tagline',
			'type'     => 'textarea',
			'priority' => 9, // After default logo.
		) );
	}

	public function output() {
		$logo = $this->get_logo();
		if ( empty( $logo ) ) {
			return;
		}
		$tag = $this->get_output_tag();
		if ( empty( $tag ) ) {
			echo wp_kses_post( $logo );
		} else {
			echo '<' . esc_html( $tag ) . ' class="logo">' . $logo . '</' . esc_html( $tag ) . '>';
		}
	}

	private function get_logo() {
		return apply_filters( 'estar_logo', get_theme_mod( 'svg_logo', get_custom_logo() ) );
	}

	private function get_output_tag() {
		return apply_filters( 'estar_logo_tag', 'div' );
	}
}