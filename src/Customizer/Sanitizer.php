<?php
namespace EStar\Customizer;

class Sanitizer {
	public function sanitize_checkbox( $checked ) {
		return isset( $checked ) && true == $checked;
	}

	public function sanitize_css( $css ) {
		return wp_strip_all_tags( $css );
	}

	public function sanitize_dropdown_pages( $page_id, $setting ) {
		$page_id = absint( $page_id );

		// If $page_id is an ID of a published page, return it; otherwise, return the default.
		return 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default;
	}

	public function sanitize_email( $email, $setting ) {
		$email = sanitize_email( $email );
		return ! is_null( $email ) ? $email : $setting->default;
	}

	public function sanitize_hex_color( $hex_color, $setting ) {
		$hex_color = sanitize_hex_color( $hex_color );
		return ! is_null( $hex_color ) ? $hex_color : $setting->default;
	}

	public function sanitize_image( $image, $setting ) {
	    $mimes = array(
	        'jpg|jpeg|jpe' => 'image/jpeg',
	        'gif'          => 'image/gif',
	        'png'          => 'image/png',
	        'bmp'          => 'image/bmp',
	        'tif|tiff'     => 'image/tiff',
	        'ico'          => 'image/x-icon'
	    );

		// Return an array with file extension and mime_type.
	    $file = wp_check_filetype( $image, $mimes );

	    return $file['ext'] ? $image : $setting->default;
	}

	public function sanitize_choice( $input, $setting ) {
		$choices = $setting->manager->get_control( $setting->id )->choices;
		return isset( $choices[ $input ] ) ? $input : $setting->default;
	}

	public function sanitize_url( $url ) {
		return esc_url_raw( $url );
	}
}