<?php
namespace EStar\Integration;

class WooCommerce {
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'add_theme_support' ] );
		add_action( 'template_redirect', [ $this, 'setup_hooks' ] );
		add_filter( 'body_class', [ $this, 'add_body_classes' ] );
	}

	public function add_theme_support() {
		add_theme_support( 'woocommerce' );

		// add_theme_support( 'woocommerce', [
		// 	'thumbnail_image_width' => 150,
		// 	'single_image_width'    => 300,

		// 	'product_grid'          => [
		// 		'default_rows'    => 3,
		// 		'min_rows'        => 2,
		// 		'max_rows'        => 8,
		// 		'default_columns' => 4,
		// 		'min_columns'     => 2,
		// 		'max_columns'     => 5,
		// 	],
		// ] );

		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	public function setup_hooks() {
		// Remove content wrapper.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

		// No sidebar for single products.
		if ( is_single() ) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
		}
	}

	public function add_body_classes( $classes ) {
		if ( ! is_singular( 'product' ) ) {
			return $classes;
		}
		$classes = array_diff( $classes, [
			'singular',
			'sidebar-right', 'sidebar-left', 'no-sidebar',
			'thumbnail-before-header', 'thumbnail-after-header', 'thumbnail-header-background',
			'entry-header-left', 'entry-header-right', 'entry-header-center',
		] );
		return $classes;
	}
}