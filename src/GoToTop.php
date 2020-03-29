<?php
namespace EStar;

class GoToTop {
	private $sanitizer;
	private $icons;

	public function __construct( $sanitizer, $icons ) {
		$this->sanitizer = $sanitizer;
		$this->icons = $icons;

		add_action( 'customize_register', [ $this, 'register' ] );
		add_action( 'wp_footer', [ $this, 'output' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->add_setting( 'go_to_top', array(
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
		) );
		$wp_customize->add_control( 'go_to_top', array(
			'label'   => esc_html__( 'Show go to top button', 'thefour' ),
			'section' => 'footer',
			'type'    => 'checkbox',
			'default' => true,
		) );
	}

	public function output() {
		if ( ! get_theme_mod( 'go_to_top', true ) ) {
			return;
		}
		echo '<a href="#" class="go-to-top">' . $this->icons->get( 'cheveron-up' ) . '</a>';
	}
}
