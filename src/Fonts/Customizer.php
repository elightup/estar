<?php
namespace EStar\Fonts;

class Customizer {
	private $elements;
	private $labels;

	public function __construct() {
		$this->elements = Fonts::get_elements();
		$this->labels   = Fonts::get_labels();

		add_action( 'customize_register', [ $this, 'register' ] );
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_controls_scripts' ] );
		add_action( 'customize_preview_init', [ $this, 'enqueue_preview_scripts' ] );
	}

	/**
	 * Register typography settings in the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize The WP customize manager object.
	 */
	public function register( $wp_customize ) {
		if ( empty( $this->elements ) ) {
			return;
		}

		$wp_customize->add_panel( 'estar_fonts', [
			'title' => $this->labels['panel'],
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
			'label'   => $this->labels['font_family'],
			'section' => "{$id}_font",
			'panel'   => 'estar_fonts',
		] ) );

		// Font style.
		$wp_customize->add_setting( "{$id}_font_style", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control( "{$id}_font_style", [
			'label'   => $this->labels['font_style'],
			'type'    => 'select',
			'choices' => [
				''          => $this->labels['no_change'],
				'100'       => $this->labels['100'],
				'100italic' => $this->labels['100italic'],
				'200'       => $this->labels['200'],
				'200italic' => $this->labels['200italic'],
				'300'       => $this->labels['300'],
				'300italic' => $this->labels['300italic'],
				'regular'   => $this->labels['400'],
				'italic'    => $this->labels['400italic'],
				'500'       => $this->labels['500'],
				'500italic' => $this->labels['500italic'],
				'600'       => $this->labels['600'],
				'600italic' => $this->labels['600italic'],
				'700'       => $this->labels['700'],
				'700italic' => $this->labels['700italic'],
				'800'       => $this->labels['800'],
				'800italic' => $this->labels['800italic'],
				'900'       => $this->labels['900'],
				'900italic' => $this->labels['900italic'],
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
			'label'   => $this->labels['font_subsets'],
			'choices' => [
				'cyrillic'     => $this->labels['cyrillic'],
				'cyrillic-ext' => $this->labels['cyrillic-ext'],
				'greek'        => $this->labels['greek'],
				'greek-ext'    => $this->labels['greek-ext'],
				'latin'        => $this->labels['latin'],
				'latin-ext'    => $this->labels['latin-ext'],
				'vietnamese'   => $this->labels['vietnamese'],
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
			'label'      => $this->labels['font_size'],
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
			'label'      => $this->labels['line_height'],
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
			'label'      => $this->labels['letter_spacing'],
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
			'label'   => $this->labels['text_transform'],
			'type'    => 'select',
			'choices' => [
				''           => $this->labels['no_change'],
				'normal'     => $this->labels['none'],
				'lowercase'  => $this->labels['lowercase'],
				'uppercase'  => $this->labels['uppercase'],
				'capitalize' => $this->labels['capitalize'],
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
