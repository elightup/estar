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
		$wp_customize->add_setting( 'hide_go_to_top', array(
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
		) );
		$wp_customize->add_control( 'hide_go_to_top', array(
			'label'   => esc_html__( 'Hide go to top button', 'estar' ),
			'section' => 'footer',
			'type'    => 'checkbox',
		) );
	}

	public function output() {
		if ( get_theme_mod( 'hide_go_to_top' ) ) {
			return;
		}
		echo '<a href="#" class="go-to-top">' . $this->icons->get( 'cheveron-up' ) . '</a>';
	}
}
