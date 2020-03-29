<?php
namespace EStar;

class SVG {
	public static function get_allowed_tags() {
		return array_merge( wp_kses_allowed_html( 'post' ), [
			'svg'  => [
				'role'    => true,
				'width'   => true,
				'height'  => true,
				'fill'    => true,
				'xmlns'   => true,
				'viewbox' => true,
			],
			'path' => [
				'd'              => true,
				'fill'           => true,
				'fill-rule'      => true,
				'stroke'         => true,
				'stroke-width'   => true,
				'stroke-linecap' => true,
			],
			'g'    => [
				'd'    => true,
				'fill' => true,
			],
		] );
	}
}