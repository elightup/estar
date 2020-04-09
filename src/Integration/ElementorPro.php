<?php
namespace EStar\Integration;

class ElementorPro {
	public function __construct() {
		add_action( 'elementor/theme/register_locations', [ $this, 'register_locations' ] );
		add_action( 'estar_header', [ $this, 'render_header' ], 5 );
		add_action( 'estar_footer', [ $this, 'render_footer' ], 5 );
	}

	public function register_locations( $manager ) {
		$manager->register_all_core_location();

		$manager->register_location( 'header_before', [
			'label'    => __( 'Before Header', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_header_before',
		] );
		$manager->register_location( 'header_after', [
			'label'    => __( 'After Header', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_header_after',
		] );

		$manager->register_location( 'footer_before', [
			'label'    => __( 'Before Footer', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_footer_before',
		] );
		$manager->register_location( 'footer_after', [
			'label'    => __( 'After Footer', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_footer_after',
		] );

		$manager->register_location( 'sidebar_top', [
			'label'    => __( 'Sidebar Top', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_sidebar_top',
		] );
		$manager->register_location( 'sidebar_bottom', [
			'label'    => __( 'Sidebar Bottom', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_sidebar_bottom',
		] );

		$manager->register_location( 'loop_start', [
			'label'    => __( 'Before Loop', 'estar' ),
			'multiple' => true,
			'hook'     => 'loop_start',
		] );
		$manager->register_location( 'loop_end', [
			'label'    => __( 'After Loop', 'estar' ),
			'multiple' => true,
			'hook'     => 'loop_end',
		] );

		$manager->register_location( 'entry_before', [
			'label'    => __( 'Before Entry', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_entry_before',
		] );
		$manager->register_location( 'entry_after', [
			'label'    => __( 'After Entry', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_entry_after',
		] );
		$manager->register_location( 'entry_header_before', [
			'label'    => __( 'Before Entry Header', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_entry_header_before',
		] );
		$manager->register_location( 'entry_header_after', [
			'label'    => __( 'After Entry Header', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_entry_header_after',
		] );
		$manager->register_location( 'entry_content_before', [
			'label'    => __( 'Before Entry Content', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_entry_content_before',
		] );
		$manager->register_location( 'entry_content_after', [
			'label'    => __( 'After Entry Content', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_entry_content_after',
		] );
		$manager->register_location( 'entry_footer_before', [
			'label'    => __( 'Before Entry Footer', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_entry_footer_before',
		] );
		$manager->register_location( 'entry_footer_after', [
			'label'    => __( 'After Entry Footer', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_entry_footer_after',
		] );
		$manager->register_location( 'comments_before', [
			'label'    => __( 'Before Comments', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_comments_before',
		] );
		$manager->register_location( 'comments_after', [
			'label'    => __( 'After Comments', 'estar' ),
			'multiple' => true,
			'hook'     => 'estar_comments_after',
		] );
	}

	public function render_header() {
		if ( elementor_theme_do_location( 'header' ) ) {
			add_filter( 'estar_header_enabled', '__return_false' );
		}
	}

	public function render_footer() {
		if ( elementor_theme_do_location( 'footer' ) ) {
			add_filter( 'estar_footer_enabled', '__return_false' );
		}
	}
}