<?php
namespace EStar\Fonts;

class Customizer {
	private $elements;

	public function __construct() {
		$this->elements = Fonts::get_elements();

		add_action( 'customize_register', [ $this, 'register' ] );
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_controls_scripts' ] );
		add_action( 'customize_preview_init', [ $this, 'enqueue_preview_scripts' ] );
	}

	public function register( $wp_customize ) {
		if ( empty( $this->elements ) ) {
			return;
		}

		$wp_customize->add_panel( 'estar_fonts', [
			'title' => __( 'Fonts', 'estar' ),
		] );

		array_walk( $this->elements, [ $this, 'register_element_settings' ], $wp_customize );
	}

	public function register_element_settings( $element, $id, $wp_customize ) {
		// Section.
		$wp_customize->add_section( "{$id}_font", [
			'title' => $element['title'],
			'panel' => 'estar_fonts',
		] );

		// Font family.
		$wp_customize->add_setting( "{$id}_font_family", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( new FontFamilyControl( $wp_customize, "{$id}_font_family", [
			'label'   => __( 'Font Family', 'estar' ),
			'section' => "{$id}_font",
			'panel'   => 'estar_fonts',
		] ) );

		// Font style.
		$wp_customize->add_setting( "{$id}_font_style", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( "{$id}_font_style", [
			'label'   => __( 'Font Style', 'estar' ),
			'type'    => 'select',
			'choices' => [
				''          => __( '- No change -', 'estar' ),
				'100'       => __( 'Thin 100', 'estar' ),
				'100italic' => __( 'Thin 100 Italic', 'estar' ),
				'200'       => __( 'Extra-Light 200', 'estar' ),
				'200italic' => __( 'Extra-Light 200 Italic', 'estar' ),
				'300'       => __( 'Light 300', 'estar' ),
				'300italic' => __( 'Light 300 Italic', 'estar' ),
				'regular'   => __( 'Normal 400', 'estar' ),
				'italic'    => __( 'Normal 400 Italic', 'estar' ),
				'500'       => __( 'Medium 500', 'estar' ),
				'500italic' => __( 'Medium 500 Italic', 'estar' ),
				'600'       => __( 'Semi-Bold 600', 'estar' ),
				'600italic' => __( 'Semi-Bold 600 Italic', 'estar' ),
				'700'       => __( 'Bold 700', 'estar' ),
				'700italic' => __( 'Bold 700 Italic', 'estar' ),
				'800'       => __( 'Extra-Bold 800', 'estar' ),
				'800italic' => __( 'Extra-Bold 800 Italic', 'estar' ),
				'900'       => __( 'Ultra-Bold 900', 'estar' ),
				'900italic' => __( 'Ultra-Bold 900 Italic', 'estar' ),
			],
			'section' => "{$id}_font",
			'panel'   => 'estar_fonts',
		] );

		// Languages.
		$wp_customize->add_setting( "{$id}_font_subsets", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( new CheckboxListControl( $wp_customize, "{$id}_font_subsets", [
			'label'   => __( 'Languages', 'estar' ),
			'choices' => [
				'cyrillic'     => __( 'Cyrillic', 'estar' ),
				'cyrillic-ext' => __( 'Cyrillic Extended', 'estar' ),
				'greek'        => __( 'Greek', 'estar' ),
				'greek-ext'    => __( 'Greek Extended', 'estar' ),
				'latin'        => __( 'Latin', 'estar' ),
				'latin-ext'    => __( 'Latin Extended', 'estar' ),
				'vietnamese'   => __( 'Vietnamese', 'estar' ),
			],
			'section' => "{$id}_font",
			'panel'   => 'estar_fonts',
		] ) );

		// Font size.
		$wp_customize->add_setting( "{$id}_font_size", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( "{$id}_font_size", [
			'label'      => __( 'Font Size', 'estar' ),
			'type'       => 'number',
			'section'    => "{$id}_font",
			'panel'      => 'estar_fonts',
			'input_atts' => ['step' => 'any'],
		] );
		$wp_customize->add_setting( "{$id}_font_size_unit", [
			'default'           => 'px',
			'sanitize_callback' => 'estar_sanitize_select',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( "{$id}_font_size_unit", [
			'type'    => 'select',
			'choices' => [
				'px'  => 'px',
				'em'  => 'em',
				'rem' => 'rem',
				'%'   => '%',
			],
			'section' => "{$id}_font",
			'panel'   => 'estar_fonts',
		] );

		// Line height.
		$wp_customize->add_setting( "{$id}_line_height", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( "{$id}_line_height", [
			'label'      => __( 'Line Height', 'estar' ),
			'type'       => 'number',
			'section'    => "{$id}_font",
			'panel'      => 'estar_fonts',
			'input_atts' => ['step' => 'any'],
		] );
		$wp_customize->add_setting( "{$id}_line_height_unit", [
			'sanitize_callback' => 'estar_sanitize_select',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( "{$id}_line_height_unit", [
			'type'    => 'select',
			'choices' => [
				''    => '-',
				'px'  => 'px',
				'em'  => 'em',
				'rem' => 'rem',
				'%'   => '%',
			],
			'section' => "{$id}_font",
			'panel'   => 'estar_fonts',
		] );

		// Letter spacing.
		$wp_customize->add_setting( "{$id}_letter_spacing", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( "{$id}_letter_spacing", [
			'label'      => __( 'Letter Spacing', 'estar' ),
			'type'       => 'number',
			'section'    => "{$id}_font",
			'panel'      => 'estar_fonts',
			'input_atts' => ['step' => 'any'],
		] );
		$wp_customize->add_setting( "{$id}_letter_spacing_unit", [
			'default'           => 'px',
			'sanitize_callback' => 'estar_sanitize_select',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( "{$id}_letter_spacing_unit", [
			'type'    => 'select',
			'choices' => [
				'px'  => 'px',
				'em'  => 'em',
				'rem' => 'rem',
				'%'   => '%',
			],
			'section' => "{$id}_font",
			'panel'   => 'estar_fonts',
		] );

		// Text transform.
		$wp_customize->add_setting( "{$id}_text_transform", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( "{$id}_text_transform", [
			'label'   => __( 'Text Transform', 'estar' ),
			'type'    => 'select',
			'choices' => [
				''           => __( '- No change -', 'estar' ),
				'normal'     => __( 'None', 'estar' ),
				'lowercase'  => __( 'lowercase', 'estar' ),
				'uppercase'  => __( 'UPPERCASE', 'estar' ),
				'capitalize' => __( 'Capitalize', 'estar' ),
			],
			'section' => "{$id}_font",
			'panel'   => 'estar_fonts',
		] );
	}

	/**
	 * Enqueue scripts and styles for styling controls in the customizer.
	 */
	public function enqueue_controls_scripts() {
		wp_enqueue_style( 'estar-fonts-controls', get_template_directory_uri() . '/src/Fonts/assets/controls.css', [], '1.0.0' );
		wp_enqueue_script( 'estar-fonts-controls', get_template_directory_uri() . '/src/Fonts/assets/controls.js', ['jquery', 'customize-preview'], '1.0.0', true );
	}

	/**
	 * Enqueue scripts for live previewing.
	 */
	public function enqueue_preview_scripts() {
		wp_register_script( 'webfont', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js', [], '1.6.26', true );
		wp_enqueue_script( 'estar-fonts-preview', get_template_directory_uri() . '/src/Fonts/assets/preview.js', ['jquery', 'customize-preview', 'webfont'], '1.0.0', true );
		wp_localize_script( 'estar-fonts-preview', 'EStar_Fonts_Settings', $this->elements );
	}
}
