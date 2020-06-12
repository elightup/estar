<?php
namespace EStar\Integration;

class TheEventsCalendar {
	public function __construct() {
        add_filter( 'estar_layout', [ $this, 'events_layout' ] );
    }

    public function events_layout( $layout ) {
        if ( is_post_type_archive( 'tribe_events' ) ) {
            $layout = 'no-sidebar';
        }
        return $layout;
    }
}