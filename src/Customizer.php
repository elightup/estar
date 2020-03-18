<?php
namespace EStar;

class Customizer {
	public function __construct() {
		add_action( 'customize_register', [ $this, 'register' ] );
		add_action( 'customize_preview_init', [ $this, 'enqueue_preview_js' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		$wp_customize->add_section( 'footer', [
			'title'    => esc_html__( 'Footer', 'estar' ),
			'priority' => '1300',
		] );
		$wp_customize->add_setting( 'footer_copyright', array(
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'footer_copyright', array(
			'label'   => esc_html__( 'Copyright Text', 'thefour' ),
			'section' => 'footer',
			'type'    => 'textarea',
		) );
	}

	public function enqueue_preview_js() {
		wp_enqueue_script( 'estar-customizer', get_template_directory_uri() . '/js/customizer.js', ['customize-preview'], '1.0.0', true );
	}
}