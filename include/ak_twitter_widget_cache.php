<?php
/**
 * Class for creating Twitter Data Cache
 */

class Ak_Twitter_Widget_Cache {
	public function get_data() {
		return get_transient( 'twitter_stream' );
	}

	public function set_data( $data ) {
		set_transient( 'twitter_stream', $data, 60 * MINUTE_IN_SECONDS );

		return $this;
	}
}
