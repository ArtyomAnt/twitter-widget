<?php
/**
 * Plugin Name: WordPress Twitter Widget
 * Plugin URI: mailto:artem.kashel@gmail.com
 * Description: Test work.
 * Version: 1.0
 * Author: Artsem Kashel
 * Author URI: mailto:artem.kashel@gmail.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	wp_die("Not allowed!"); // Exit if accessed directly
}

class Ak_Twitter_Widget {
	// Service container.
	public static $container;

	private function __construct() {
		$this->load_depencies();
		
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	public function load_depencies() {
		// Include autoload for vendor packages.
		require_once( plugin_dir_path( __FILE__ ) . "vendor/autoload.php" );

		// Init Twitter Api.
		require_once( plugin_dir_path( __FILE__ ) . "include/ak_twitter_widget_api.php" );

		self::$container["twitter_api"] = new Ak_Twitter_Widget_Api(
			'sGZLspK2lB1GyeFmLOucssP1f', 
			'z1nhoLbTIW4EILPEWAuF0H58AZiLsBjRt1cJuWaipa1kdNDTPs',
			'14162809-6cnTOJRV9Xkw4G8rgfuZ8ZApT536C3oF3sJhhHE8B',
			'ReeflQKgRrgc2i5netx92dLouFRTSy8F7hw1ApBsAUTdE'
		);

		// Init Twitter Cache.
		require_once( plugin_dir_path( __FILE__ ) . "include/ak_twitter_widget_cache.php" );
		self::$container["twitter_cache"] = new Ak_Twitter_Widget_Cache();

		// Init Twitter Cache.
		require_once( plugin_dir_path( __FILE__ ) . "include/ak_twitter_widget_controller.php" );
		$controller = new Ak_Twitter_Widget_Controller();
		 
		// Register Widget.
		require_once( plugin_dir_path( __FILE__ ) . "include/ak_twitter_widget_create.php" );
		add_action( 'widgets_init', function(){
			register_widget( 'Ak_Twitter_Widget_Create' );
		});
	}

	public function load_scripts() {
		wp_enqueue_style( 'ak-twitter-widget-css', plugin_dir_url( __FILE__ ) . 'assets/ak-twitter-widget.css', array(), '1.0', 'all' );
		wp_enqueue_script( 'ak-twitter-widget-js', plugin_dir_url( __FILE__ ) . 'assets/ak-twitter-widget.js', array( 'jquery' ), '1.0', true );

		$ak_twitter_widget_l10n = array(
			'ajax_url' => admin_url('admin-ajax.php'),
		);
		wp_localize_script('ak-twitter-widget-js', 'ak_twitter_widget_l10n', $ak_twitter_widget_l10n);
	}

	public static function init() {
		return new static();
	}
}
Ak_Twitter_Widget::init();
