<?php
namespace EStar\Integration;

class AMP {
	public static function is_active() {
		return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
	}
}