<?php
namespace EStar\Integration;

class BBPress {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
	}

	public function enqueue_assets() {
		if ( is_bbpress() ) {
			wp_enqueue_style( 'estar-bbpress', get_template_directory_uri() . '/css/bbpress.css', [], '1.3.0' );
		}
	}
}