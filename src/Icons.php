<?php
namespace EStar;

class Icons {
	private $icons = [
		// chevron up - Heroicons UI
		'cheveron-up' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M8.7 14.7a1 1 0 0 1-1.4-1.4l4-4a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1-1.4 1.4L12 11.42l-3.3 3.3z"/></svg>',
	];

	public function __construct() {
		add_action( 'init', [ $this, 'filter_icons' ] );
	}

	public function filter_icons() {
		$this->icons = apply_filters( 'estar_icons', $this->icons );
	}

	public function get( $name, $default = null ) {
		if ( ! isset( $this->icons[ $name ] ) ) {
			return $default;
		}

		$icon = $this->icons[ $name ];

		// Add extra attributes to SVG code.
		$icon = str_replace( '<svg ', '<svg aria-hidden="true" role="img" focusable="false" ', $icon );
		return wp_kses( $icon, SVG::get_allowed_tags() );
	}
}