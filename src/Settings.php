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
		$control = self::$customize_manager->get_control( $name );

		$value = get_theme_mod( $name, null );

		// Haven't set in the Customizer.
		if ( null === $value ) {
			return $setting->default;
		}

		// Respect the checkbox value.
		if ( 'checkbox' === $control->type ) {
			return $value;
		}

		// Other field types: use default value if it's empty.
		return $value ?: $setting->default;
	}
}