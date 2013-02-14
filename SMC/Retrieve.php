<?php

class SMC_Retrieve {

	private static $instance;

	public function __construct() {

		self::$instance = $this;

		include_once( ABSPATH . WPINC . '/class-IXR.php' );
		include_once( ABSPATH . WPINC . '/class-wp-http-ixr-client.php' );

		$this->test();

	}

	private function test() {

		$client = new WP_HTTP_IXR_CLIENT( 'http://agrilife.org/communications/xmlrpc.php' );

		$user = XMLRPC_USER;
		$pass = XMLRPC_PASS;

		$hello = $client->query( 'wp.getPosts', array(
			0,
			$user,
			$pass,
			array(
				'post_status' => 'draft',
				'post_type' => 'account',
			),
		) );
/*		if ( $client->isError() ) {
			print_r( $client->getErrorMessage());
		}
*/
		$accounts = $client->getResponse();

		foreach ( $accounts as $a ) {

			$custom_fields = $a['custom_fields'];

			$fields = $this->parse_fields( $custom_fields );

			$new_accounts[$a['post_title']] = $fields;

		}

		set_transient( 'smc_accounts', $new_accounts, 60*60*24 );

		print_r( get_transient( 'smc_accounts' ));

	}

	private function parse_fields( $fields ) {

		$parsed = array();
		foreach ( $fields as $f ) {
			$parsed[$f['key']] = $f['value'];
		}

		return $parsed;

	}

}