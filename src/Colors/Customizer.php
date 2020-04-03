<?php
namespace EStar\Colors;

use EStar\Customizer as Base;

class Customizer {
	private $elements;

	public function __construct() {
		$this->elements = Colors::get_elements();
		add_action( 'customize_register', [ $this, 'register' ] );
		add_action( 'customize_preview_init', [ $this, 'enqueue' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->add_section( 'estar_colors', [
			'title'    => __( 'Colors', 'estar' ),
			'priority' => Base::get_priority( 'colors' ),
		] );

		foreach ( $this->elements as $id => $element ) {
			$wp_customize->add_setting( $id, [
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			] );
			$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, $id, [
				'label'    => $element['title'],
				'section'  => 'estar_colors',
				'settings' => $id,
				'description' => isset( $element['description'] ) ? $element['description'] : '',
			] ) );
		}
	}

	public function enqueue() {
		wp_enqueue_script( 'estar-colors', get_template_directory_uri() . '/src/Colors/assets/preview.js', ['customize-preview'], '1.0.0', true );
		wp_localize_script( 'estar-colors', 'EStar_Colors_Settings', array_keys( $this->elements ) );
	}
}
