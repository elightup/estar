<?php
namespace EStar;

class Customizer {
	private $sanitizer;

	public function __construct( $sanitizer ) {
		$this->sanitizer = $sanitizer;

		add_action( 'customize_register', [ $this, 'register' ] );
		add_action( 'customize_preview_init', [ $this, 'enqueue_preview_js' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		// Header.
		$wp_customize->add_section( 'header', [
			'title'    => esc_html__( 'Header', 'estar' ),
			'priority' => self::get_priority( 'header' ),
		] );

		$wp_customize->add_setting( 'header_search', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
			'default'           => true,
		] );
		$wp_customize->add_control( 'header_search', [
			'label'   => esc_html__( 'Show search button', 'estar' ),
			'section' => 'header',
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