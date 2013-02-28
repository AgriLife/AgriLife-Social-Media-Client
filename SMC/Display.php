<?php

class SMC_Display {

	/**
	 * The object instance
	 * 
	 * @var object
	 */
	private static $instance;

	/**
	 * The accounts returned via XML-RPC
	 * 
	 * @var array
	 */
	private $accounts = array();

	/**
	 * Start the engine!
	 */
	public function __construct() {

		self::$instance = $this;

		// Get the accounts from the transient cache
		$this->accounts = get_transient( 'smd_accounts' );

	}

	/**
	 * Renders the account listing
	 *
	 * @since 1.0
	 * @param  string $org The department/organization type
	 * @return void
	 */
	public function show_accounts( $org ) {

		$accounts = $this->accounts;

		echo '<div class="social-accounts">';
		echo '<ul>';
		foreach ( $accounts as $a ) {
			// Show only accounts matching the org type
			if ( array_search( $org, $a ) ) {
				echo '<li>';
				echo '<h3 class="dept-name">' . $a['account-name'] . '</h3>';
				echo '<ul>';
				echo $this->parse_accounts( $a );
				echo '</ul>';
				echo '</li>';
			}
		}
		echo '</ul>';
		echo '</div>';

	}

	/**
	 * Parse each account into a list item
	 * @param  array $account The account information
	 * @return string         The account list item
	 */
	private function parse_accounts( $account ) {

		// Remove account name and type from the array
		// Leaves only the social media accounts
		$account = array_slice( $account, 2 );

		$output = '';
		
		foreach ( $account as $k => $v ) {
			$output .= '<li class="social-media-item">';
			$output .= '<a class="' . $k . '" href="' . $v . '">' . $k . '</a>';
			$output .= '</li>';
		}

		return $output;

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