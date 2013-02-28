<?php

class SMC_Payload {

	/**
	 * The object instance
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * The information returned from the XML-RPC request
	 * 
	 * @var array
	 */
	private $payload = array();

	/**
	 * The un-parsed account custom fields
	 * 
	 * @var array
	 */
	private $custom_fields = array();

	/**
	 * The parsed accounts array
	 * 
	 * @var array
	 */
	private $accounts = array();

	/**
	 * Command to use the cache or bust it
	 * 
	 * @var boolean
	 */
	private static $use_cache = true;

	/**
	 * The plugin's transient key
	 * 
	 * @var string
	 */
	private static $transient_key = 'smd_accounts';

	/**
	 * Start the engine!
	 */
	public function __construct() {

		self::$instance = $this;

		$this->set_use_cache();

		// Include the required classes
		include_once( ABSPATH . WPINC . '/class-IXR.php' );
		include_once( ABSPATH . WPINC . '/class-wp-http-ixr-client.php' );

		// If the transient isn't expired, get and save a new one.
		if ( self::expired() ) {
			$this->retrieve();
			$this->parse();
			$this->save();
		}

	}

	/**
	 * Get the accounts from agrilife.org/communications
	 *
	 * @since 1.0
	 * @uses WP_HTTP_IXR_CLIENT
	 * @return void
	 */
	private function retrieve() {

		$client = new WP_HTTP_IXR_CLIENT( 'http://agrilife.org/communications/xmlrpc.php' );

		$user = XMLRPC_USER;
		$pass = XMLRPC_PASS;

		$hello = $client->query( 'wp.getPosts', array(
			0,
			$user,
			$pass,
			array(
				'post_status' => 'publish',
				'post_type' => 'account',
			),
		) );

		$this->error( $client );

		$payload = $client->getResponse();

		$this->payload = $payload;

	}

	/**
	 * Parses the account payload
	 *
	 * @since 1.0
	 * @return void
	 */
	private function parse() {

		$payload = $this->payload;

		$accounts = array();

		foreach ( $payload as $p ) {

			$parsed = array();
			$fields = array();

			$fields = $p['custom_fields'];
			foreach ( $fields as $f ) {
				$parsed[$f['key']] = $f['value'];
			}

			$account = array();

			$account['account-name'] = $p['post_title'];
			$account['account-type'] = $parsed['_smd_account-category'];

			if ( isset( $parsed['_smd_twitter-url'] ) )
				$account['twitter'] = $parsed['_smd_twitter-url'];

			if ( isset( $parsed['_smd_google-plus-url'] ) )
				$account['google-plus'] = $parsed['_smd_google-plus-url'];

			if ( isset( $parsed['_smd_facebook-url'] ) )
				$account['facebook'] = $parsed['_smd_facebook-url'];

			if ( isset( $parsed['_smd_flickr-url'] ) )
				$account['flickr'] = $parsed['_smd_flickr-url'];

			if ( isset( $parsed['_smd_youtube-url'] ) )
				$account['youtube'] = $parsed['_smd_youtube-url'];

			if ( isset( $parsed['_smd_instagram-url'] ) )
				$account['instagram'] = $parsed['_smd_instagram-url'];

			if ( isset( $parsed['_smd_pinterest-url'] ) )
				$account['pinterest'] = $parsed['_smd_pinterest-url'];

			if ( isset( $parsed['_smd_blog-url'] ) )
				$account['blog'] = $parsed['_smd_blog-url'];

			if ( isset( $parsed['_smd_other-url'] ) )
				$account['other'] = $parsed['_smd_other-url'];

			array_push( $accounts, $account );

		}

		$this->accounts = $accounts;

	}

	/**
	 * Saves the accounts as a transient
	 * 
	 * @return void
	 */
	private function save() {

		$accounts = $this->accounts;

		set_transient( self::$transient_key, $accounts, 60 );

	}

	/**
	 * Throws an error if there's a problem retrieving the payload
	 *
	 * @since 1.0
	 * @param  object $client The XML-RPC object
	 * @return void
	 */
	private function error( $client ) {

		if ( $client->isError() ) {
			print_r( $client->getErrorMessage() );
		} else {
			return;
		}

	}

	/**
	 * Sets $use_cache based on the option selected.
	 *
	 * @since 1.0
	 * @return void
	 */
	private function set_use_cache() {

		$option = get_option( 'debug_mode' );

		if ( 1 == $option )
			self::$use_cache = false;

	}

	/**
	 * Determines if the transient should be updated
	 *
	 * @since 1.0
	 * @return boolean
	 */
	public static function expired() {

		// Return as true if $use_cache is set to false
		// This forces the transient to update. Use with caution.
		if ( ! self::$use_cache )
			return true;

		if ( false === ( $value = get_transient( self::$transient_key ) ) )
			return true;

	}

	/**
	 * Easily retrive the object instance
	 *
	 * @since 1.0
	 * @return object
	 */
	public static function get_instance() {

		return self::$instance;

	}

}