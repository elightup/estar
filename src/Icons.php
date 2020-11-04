<?php
namespace EStar;

class Icons {
	public static function get_icons() {
		return apply_filters( 'estar_icons', [
			'chevron-up'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon"><polyline points="18 15 12 9 6 15"></polyline></svg>',
			'chevron-down' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon"><polyline points="6 9 12 15 18 9"></polyline></svg>',
			'menu'         => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>',
			'search'       => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
			'shopping-bag' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>',
		] );
	}

	public static function render( $name, $display = true ) {
		$icons = self::get_icons();
		$icon  = isset( $icons[ $name ] ) ? $icons[ $name ] : null;
		$icon  = apply_filters( 'estar_icon', $icon, $icons );
		if ( $display ) {
			echo $icon;
		}
		return $icon;
	}
}
