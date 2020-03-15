<?php
namespace EStar\Colors;

class Colors {
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
			'color-accent' => [
				'title'       => __( 'Accent Color', 'estar' ),
				'description' => __( 'Button color, link color', 'estar' ),
			],
			'color-dark' => [
				'title'       => __( 'Dark Color', 'estar' ),
				'description' => __( 'Heading text color', 'estar' ),
			],
			'color-base' => [
				'title'       => __( 'Base Color', 'estar' ),
				'description' => __( 'Body text color', 'estar' ),
			],
			'color-gray' => [
				'title'       => __( 'Gray Color', 'estar' ),
				'description' => __( 'Post meta, comment meta', 'estar' ),
			],
			'color-light' => [
				'title'       => __( 'Light Color', 'estar' ),
				'description' => __( 'Line color, border color', 'estar' ),
			],
		];
		return apply_filters( 'estar_colors_elements', $elements );
	}
}
