<?php
namespace EStar\Integration;

class ElementorPro {
	public function __construct() {
		add_action( 'elementor/theme/register_locations', [ $this, 'register_core_locations' ] );
		add_action( 'elementor/theme/register_locations', [ $this, 'register_extra_locations' ] );
	}

	public function register_core_locations( $manager ) {
		$locations = ['header', 'footer', 'single', 'archive'];
		foreach ( $locations as $location ) {
			$manager->register_location( $location, [
				'hook'         => "estar_$location",
				'remove_hooks' => ["EStar\Structure::render_$location"],
			] );
		}
	}

	public function register_extra_locations( $manager ) {
		$locations = [
			'estar_header_before'        => __( 'Before Header', 'estar' ),
			'estar_header_after'         => __( 'After Header', 'estar' ),
			'estar_footer_before'        => __( 'Before Footer', 'estar' ),
			'estar_footer_after'         => __( 'After Footer', 'estar' ),
			'estar_sidebar_top'          => __( 'Sidebar Top', 'estar' ),
			'estar_sidebar_bottom'       => __( 'Sidebar Bottom', 'estar' ),
			'loop_start'                 => __( 'Before Loop', 'estar' ),
			'loop_end'                   => __( 'After Loop', 'estar' ),
			'estar_entry_before'         => __( 'Before Entry', 'estar' ),
			'estar_entry_after'          => __( 'After Entry', 'estar' ),
			'estar_entry_header_before'  => __( 'Before Entry Header', 'estar' ),
			'estar_entry_header_after'   => __( 'After Entry Header', 'estar' ),
			'estar_entry_content_before' => __( 'Before Entry Content', 'estar' ),
			'estar_entry_content_after'  => __( 'After Entry Content', 'estar' ),
			'estar_entry_footer_before'  => __( 'Before Entry Footer', 'estar' ),
			'estar_entry_footer_after'   => __( 'After Entry Footer', 'estar' ),
			'estar_comments_before'      => __( 'Before Comments', 'estar' ),
			'estar_comments_after'       => __( 'After Comments', 'estar' ),
		];

		foreach ( $locations as $hook => $label ) {
			$manager->register_location( $hook, [
				'label'    => $label,
				'multiple' => true,
				'hook'     => $hook,
			] );
		}
	}
}