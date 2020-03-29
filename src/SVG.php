<?php
namespace EStar;

class SVG {
	public static function get_allowed_tags() {
		$allowed_tags = apply_filters( 'estar_svg_allowed_tags', [
			'svg' => [
				'class'           => true,
				'aria-hidden'     => true,
				'aria-labelledby' => true,
				'role'            => true,
				'width'           => true,
				'height'          => true,
				'fill'            => true,
				'xmlns'           => true,
				'viewbox'         => true,
			],
			'path' => [
				'd'              => true,
				'fill'           => true,
				'fill-rule'      => true,
				'stroke'         => true,
				'stroke-width'   => true,
				'stroke-linecap' => true,
			],
			'g' => [
				'd'    => true,
				'fill' => true,
			],
			'defs' => [],
			'linearGradient' => [
				'id'            => true,
				'x1'            => true,
				'x2'            => true,
				'y1'            => true,
				'y2'            => true,
				'gradientUnits' => true,
			],
			'stop' => [
				'stop-color' => true,
				'offset'     => true,
			],
		] );

		return array_merge( wp_kses_allowed_html( 'post' ), $allowed_tags );
	}
}