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
			'heading_5' => [
				'title'    => __( 'Heading 5', 'estar' ),
				'selector' => 'h5',
			],
			'heading_6' => [
				'title'    => __( 'Heading 6', 'estar' ),
				'selector' => 'h6',
			],
			'site_title' => [
				'title'    => __( 'Site Title', 'estar' ),
				'selector' => '.site-title',
			],
			'site-description' => [
				'title'    => __( 'Site Description', 'estar' ),
				'selector' => '.site-description',
			],
			'post_title_singular' => [
				'title'    => __( 'Post Title (Singular)', 'estar' ),
				'selector' => '.singular .entry-title',
			],
			'post_title_archive' => [
				'title'    => __( 'Post Title (Archive)', 'estar' ),
				'selector' => '.archive .entry-title',
			],
			'post_content_singular' => [
				'title'    => __( 'Post Content (Singular)', 'estar' ),
				'selector' => '.entry-content',
			],
			'post_content_archive' => [
				'title'    => __( 'Post Content (Archive)', 'estar' ),
				'selector' => '.entry-summary',
			],
		];
		return apply_filters( 'estar_fonts_elements', $elements );
	}
}
