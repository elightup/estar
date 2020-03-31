<?php
namespace EStar;

class Post {
	public static function date() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		echo $time_string; // WPCS: OK.
	}

	public static function author() {
		$byline = sprintf(
			'<span class="author vcard">%s <a class="url fn n" href="%s">%s</a></span>',
			get_avatar( get_the_author_meta( 'user_email' ), 24 ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
		echo $byline; // WPCS: OK.
	}
}