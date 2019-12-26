<?php
/**
 * Class for creating Twitter Api
 */

class Ak_Twitter_Widget_Api {
	public $cb;
	public $timestamp;

	private $consumer_token;
	private $consumer_secret;
	private $access_token;
	private $access_secret;

	public function __construct($consumer_token, $consumer_secret, $access_token, $access_secret) {
		$this->consumer_token = $consumer_token;
		$this->consumer_secret = $consumer_secret;
		$this->access_token = $access_token;
		$this->access_secret = $access_secret;

		$this->make_auth();
	}

	private function make_auth() {
		 \Codebird\Codebird::setConsumerKey($this->consumer_token, $this->consumer_secret);
		 $this->cb = \Codebird\Codebird::getInstance();
		 $this->cb->setToken($this->access_token, $this->access_secret);
	}

	public function twitter_callback( $message ) {
		if ($message !== null) {
			print_r($message);
			flush();
		}
		// close streaming after 1 minute for this simple sample
  		// don't rely on globals in your code!
  		if (time() - $this->timestamp >= 30) {
    		return true;
  		}

  		return false;
	}

	public function get_tweets() {
		$this->timestamp = time();
		$this->cb->setConnectionTimeout(2000);
		$this->cb->setTimeout(5000);

		$this->cb->setStreamingCallback( array( $this, 'twitter_callback' ) );

		$this->cb->setReturnFormat(CODEBIRD_RETURNFORMAT_ARRAY);
		
		return $this->cb->statuses_userTimeline( array(
			'screen_name' => 'mhmtozek',
			'count' => 5
		) );
	}
}