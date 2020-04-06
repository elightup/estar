<?php
namespace EStar\Fonts;

use EStar\Customizer as Base;
use EStar\Customizer\Controls\CheckboxList;
use EStar\Customizer\Controls\Heading;

class Customizer {
	private $elements;
	private $wp_customize;
	private $section;

	public function __construct() {
		$this->elements = Fonts::get_elements();

		add_action( 'customize_register', [ $this, 'register' ] );
		add_action( 'customize_preview_init', [ $this, 'enqueue_preview_scripts' ] );
	}

	public function register( $wp_customize ) {
		if ( empty( $this->elements ) ) {
			return;
		}

		$this->wp_customize = $wp_customize;

		$this->wp_customize->add_panel( 'estar_fonts', [
			'title'    => __( 'Fonts', 'estar' ),
			'priority' => Base::get_priority( 'fonts' ),
		] );

		$this->register_global_settings();

		array_walk( $this->elements, [ $this, 'register_element_settings' ] );
	}

	private function register_global_settings() {
		$this->section = 'font_global';

		$this->wp_customize->add_section( $this->section, [
			'title' => __( 'Global', 'estar' ),
			'panel' => 'estar_fonts',
		] );

		$this->wp_customize->add_setting( 'base_heading' );
		$this->wp_customize->add_control( new Heading( $this->wp_customize, 'base_heading', [
			'label'   => __( 'Base Font', 'estar' ),
			'section' => $this->section,
			'panel'   => 'estar_fonts',
		] ) );

		$this->register_font_family( 'base' );
		$this->register_line_height( 'base' );

		$this->wp_customize->add_setting( 'headings_heading' );
		$this->wp_customize->add_control( new Heading( $this->wp_customize, 'headings_heading', [
			'label'   => __( 'Headings Font', 'estar' ),
			'section' => $this->section,
			'panel'   => 'estar_fonts',
		] ) );

		$this->register_font_family( 'headings' );
		$this->register_line_height( 'headings' );

		$this->wp_customize->add_setting( 'subsets_heading' );
		$this->wp_customize->add_control( new Heading( $this->wp_customize, 'subsets_heading', [
			'label'   => __( 'Subsets', 'estar' ),
			'section' => $this->section,
			'panel'   => 'estar_fonts',
		] ) );

		$this->register_font_subsets( 'global' );
	}

	private function register_element_settings( $element, $id ) {
		$this->section = "font_$id";

		$this->wp_customize->add_section( $this->section, [
			'title' => $element['title'],
			'panel' => 'estar_fonts',
		] );

		// Font family are set in the Global section.
		// $this->register_font_family( $id );

		$this->register_font_style( $id );
		$this->register_font_size( $id );
		$this->register_line_height( $id );
		$this->register_letter_spacing( $id );
		$this->register_text_transform( $id );
	}

	private function register_font_family( $id ) {
		$this->wp_customize->add_setting( "{$id}_font_family", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$this->wp_customize->add_control( new FontFamilyControl( $this->wp_customize, "{$id}_font_family", [
			'label'   => __( 'Font Family', 'estar' ),
			'section' => $this->section,
			'panel'   => 'estar_fonts',
		] ) );
	}

	private function register_font_style( $id ) {
		$this->wp_customize->add_setting( "{$id}_font_style", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$this->wp_customize->add_control( "{$id}_font_style", [
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
			'section' => $this->section,
			'panel'   => 'estar_fonts',
		] );
	}

	private function register_font_size( $id ) {
		$this->wp_customize->add_setting( "{$id}_font_size", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$this->wp_customize->add_control( "{$id}_font_size", [
			'label'      => __( 'Font Size', 'estar' ),
			'type'       => 'number',
			'section'    => $this->section,
			'panel'      => 'estar_fonts',
			'input_atts' => ['step' => 'any'],
		] );
		$this->wp_customize->add_setting( "{$id}_font_size_unit", [
			'default'           => 'px',
			'sanitize_callback' => 'estar_sanitize_select',
			'transport'         => 'postMessage',
		] );
		$this->wp_customize->add_control( "{$id}_font_size_unit", [
			'type'    => 'select',
			'choices' => [
				'px'  => 'px',
				'em'  => 'em',
				'rem' => 'rem',
				'%'   => '%',
			],
			'section' => $this->section,
			'panel'   => 'estar_fonts',
		] );
	}

	private function register_font_subsets( $id ) {
		$this->wp_customize->add_setting( "{$id}_font_subsets", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$this->wp_customize->add_control( new CheckboxList( $this->wp_customize, "{$id}_font_subsets", [
			'label'   => '',
			'choices' => [
				'cyrillic'     => __( 'Cyrillic', 'estar' ),
				'cyrillic-ext' => __( 'Cyrillic Extended', 'estar' ),
				'greek'        => __( 'Greek', 'estar' ),
				'greek-ext'    => __( 'Greek Extended', 'estar' ),
				'latin'        => __( 'Latin', 'estar' ),
				'latin-ext'    => __( 'Latin Extended', 'estar' ),
				'vietnamese'   => __( 'Vietnamese', 'estar' ),
			],
			'section' => $this->section,
			'panel'   => 'estar_fonts',
		] ) );
	}

	private function register_line_height( $id ) {
		$this->wp_customize->add_setting( "{$id}_line_height", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$this->wp_customize->add_control( "{$id}_line_height", [
			'label'      => __( 'Line Height', 'estar' ),
			'type'       => 'number',
			'section'    => $this->section,
			'panel'      => 'estar_fonts',
			'input_atts' => ['step' => 'any'],
		] );
		$this->wp_customize->add_setting( "{$id}_line_height_unit", [
			'sanitize_callback' => 'estar_sanitize_select',
			'transport'         => 'postMessage',
		] );
		$this->wp_customize->add_control( "{$id}_line_height_unit", [
			'type'    => 'select',
			'choices' => [
				''    => '-',
				'px'  => 'px',
				'em'  => 'em',
				'rem' => 'rem',
				'%'   => '%',
			],
			'section' => $this->section,
			'panel'   => 'estar_fonts',
		] );
	}

	private function register_letter_spacing( $id ) {
		$this->wp_customize->add_setting( "{$id}_letter_spacing", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$this->wp_customize->add_control( "{$id}_letter_spacing", [
			'label'      => __( 'Letter Spacing', 'estar' ),
			'type'       => 'number',
			'section'    => $this->section,
			'panel'      => 'estar_fonts',
			'input_atts' => ['step' => 'any'],
		] );
		$this->wp_customize->add_setting( "{$id}_letter_spacing_unit", [
			'default'           => 'px',
			'sanitize_callback' => 'estar_sanitize_select',
			'transport'         => 'postMessage',
		] );
		$this->wp_customize->add_control( "{$id}_letter_spacing_unit", [
			'type'    => 'select',
			'choices' => [
				'px'  => 'px',
				'em'  => 'em',
				'rem' => 'rem',
				'%'   => '%',
			],
			'section' => $this->section,
			'panel'   => 'estar_fonts',
		] );
	}

	private function register_text_transform( $id ) {
		$this->wp_customize->add_setting( "{$id}_text_transform", [
			'sanitize_callback' => 'esc_attr',
			'transport'         => 'postMessage',
		] );
		$this->wp_customize->add_control( "{$id}_text_transform", [
			'label'   => __( 'Text Transform', 'estar' ),
			'type'    => 'select',
			'choices' => [
				''           => __( '- No change -', 'estar' ),
				'normal'     => __( 'None', 'estar' ),
				'lowercase'  => __( 'lowercase', 'estar' ),
				'uppercase'  => __( 'UPPERCASE', 'estar' ),
				'capitalize' => __( 'Capitalize', 'estar' ),
			],
			'section' => $this->section,
			'panel'   => 'estar_fonts',
		] );
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
