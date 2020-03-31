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
}