<?php
namespace EStar;

class GoToTop {
	private $sanitizer;
	private $icons;

	public function __construct( $sanitizer, $icons ) {
		$this->sanitizer = $sanitizer;
		$this->icons     = $icons;

		add_action( 'customize_register', [ $this, 'register' ] );
		add_action( 'wp_footer', [ $this, 'output' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->add_setting( 'go_to_top', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
			'default'           => true,
		] );
		$wp_customize->add_control( 'go_to_top', [
			'label'   => esc_html__( 'Show go to top button', 'estar' ),
			'section' => 'footer',
			'type'    => 'checkbox',
		] );
	}

	public function output() {
		if ( get_theme_mod( 'go_to_top', true ) ) {
			echo '<a href="#" class="go-to-top">' . $this->icons->get( 'cheveron-up' ) . '</a>';
		}
	}
}
