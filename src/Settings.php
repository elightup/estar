<?php
namespace EStar;

class Settings {
	private static $customize_manager;

	public static function setup() {
		add_action( 'customize_register', [ __CLASS__, 'save_customize_manager' ], 99 );
	}

	public static function save_customize_manager( $wp_customize ) {
		self::$customize_manager = $wp_customize;
	}

	public static function get( $name ) {
		$setting = self::$customize_manager->get_setting( $name );
		$value   = get_theme_mod( $name );
		return $value ?: $setting->default;
	}
}