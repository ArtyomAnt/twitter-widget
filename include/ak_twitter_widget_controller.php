<?php 
/**
 * Class for handling Ajax Queries
 */

class Ak_Twitter_Widget_Controller {
	public function __construct() {
		add_action( 'wp_ajax_handle_request', array( $this, 'handle_request' ) );
		add_action( 'wp_ajax_nopriv_handle_request', array( $this, 'handle_request' ) );
	}

	public function handle_request() {
		$action = $_REQUEST['ak_widget_action'];

		if (! method_exists( $this, $action ) ) {
			wp_send_json_error( array( 'error' => 'Not Allowed!' ) );
		}

		$this->$action();
	}

	private function get_tweets() {
		$twitter_data = Ak_Twitter_Widget::$container["twitter_cache"]->get_data();
		
		$tweets = Ak_Twitter_Widget::$container["twitter_api"]->get_tweets();

		Ak_Twitter_Widget::$container["twitter_cache"]->set_data( $tweets );

		wp_send_json_success ( array( 'response' => $tweets ) );
	}
}