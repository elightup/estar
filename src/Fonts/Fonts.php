<?php
namespace EStar\Fonts;

class Fonts {
	public function __construct() {
		add_action( 'init', [ $this, 'init' ] );
	}

	public function init() {
		$elements = self::get_elements();
		if ( empty( $elements ) ) {
			return;
		}

		new Customizer;
		new CSS;
	}

	public static function get_elements() {
		$elements = [
			'site_title' => [
				'title'    => __( 'Site Title', 'estar' ),
				'selector' => '.site-title',
			],
			'site-description' => [
				'title'    => __( 'Site Description', 'estar' ),
				'selector' => '.site-description',
			],
			'body' => [
				'title'    => __( 'Body', 'estar' ),
				'selector' => 'body',
			],
			'heading_1' => [
				'title'    => __( 'Heading 1', 'estar' ),
				'selector' => 'h1',
			],
			'heading_2' => [
				'title'    => __( 'Heading 2', 'estar' ),
				'selector' => 'h2',
			],
			'heading_3' => [
				'title'    => __( 'Heading 3', 'estar' ),
				'selector' => 'h3',
			],
			'heading_4' => [
				'title'    => __( 'Heading 4', 'estar' ),
				'selector' => 'h4',
			],
		];
		return apply_filters( 'estar_fonts_elements', $elements );
	}

	public static function get_labels() {
		return [
			'panel'          => __( 'Fonts', 'estar' ),
			'system_fonts'   => __( 'System Fonts', 'estar' ),
			'sans_serif'     => __( 'Sans Serif', 'estar' ),
			'serif'          => __( 'Serif', 'estar' ),
			'google_fonts'   => __( 'Google Fonts', 'estar' ),
			'font_family'    => __( 'Font Family', 'estar' ),
			'font_style'     => __( 'Font Style', 'estar' ),
			'no_change'      => __( '- No change -', 'estar' ),
			'100'            => __( 'Thin 100', 'estar' ),
			'100italic'      => __( 'Thin 100 Italic', 'estar' ),
			'200'            => __( 'Extra-Light 200', 'estar' ),
			'200italic'      => __( 'Extra-Light 200 Italic', 'estar' ),
			'300'            => __( 'Light 300', 'estar' ),
			'300italic'      => __( 'Light 300 Italic', 'estar' ),
			'400'            => __( 'Normal 400', 'estar' ),
			'400italic'      => __( 'Normal 400 Italic', 'estar' ),
			'500'            => __( 'Medium 500', 'estar' ),
			'500italic'      => __( 'Medium 500 Italic', 'estar' ),
			'600'            => __( 'Semi-Bold 600', 'estar' ),
			'600italic'      => __( 'Semi-Bold 600 Italic', 'estar' ),
			'700'            => __( 'Bold 700', 'estar' ),
			'700italic'      => __( 'Bold 700 Italic', 'estar' ),
			'800'            => __( 'Extra-Bold 800', 'estar' ),
			'800italic'      => __( 'Extra-Bold 800 Italic', 'estar' ),
			'900'            => __( 'Ultra-Bold 900', 'estar' ),
			'900italic'      => __( 'Ultra-Bold 900 Italic', 'estar' ),
			'font_size'      => __( 'Font Size', 'estar' ),
			'line_height'    => __( 'Line Height', 'estar' ),
			'letter_spacing' => __( 'Letter Spacing', 'estar' ),
			'text_transform' => __( 'Text Transform', 'estar' ),
			'none'           => __( 'None', 'estar' ),
			'lowercase'      => __( 'lowercase', 'estar' ),
			'uppercase'      => __( 'UPPERCASE', 'estar' ),
			'capitalize'     => __( 'Capitalize', 'estar' ),
		];
	}
}
