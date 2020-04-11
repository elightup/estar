<?php
namespace EStar\Integration;

class WooCommerce {
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'add_theme_support' ] );
		add_action( 'template_redirect', [ $this, 'setup_hooks' ] );
		add_filter( 'body_class', [ $this, 'add_body_classes' ] );
	}

	public function add_theme_support() {
		add_theme_support( 'woocommerce', [
			'thumbnail_image_width' => 245,
		] );

		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	public function setup_hooks() {
		// Remove content wrapper.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

		// No sidebar for single products.
		if ( is_product() ) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
		}
	}

	public function add_body_classes( $classes ) {
		if ( ! is_woocommerce() ) {
			return $classes;
		}
		$classes = array_diff( $classes, [
			'singular',
			'sidebar-right', 'sidebar-left', 'no-sidebar',
			'thumbnail-before-header', 'thumbnail-after-header', 'thumbnail-header-background',
			'entry-header-left', 'entry-header-right', 'entry-header-center',

			'archive',
			'list-horizontal', 'list-vertical', 'grid', 'grid-card',
		] );
		return $classes;
	}
}