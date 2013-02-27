<?php

class SMC_Display {

	private static $instance;

	private $accounts = array();

	public function __construct() {

		self::$instance = $this;

		$this->accounts = get_transient( 'smd_accounts' );

	}

	public function show_accounts( $org ) {

		$accounts = $this->accounts;

		echo '<div class="social-accounts">';
		echo '<ul>';
		foreach ( $accounts as $a ) {
			if ( array_search( $org, $a ) ) {
				echo '<li>';
				echo '<span class="dept-name">' . $a['account-name'] . '</span>';
				echo '<ul>';
				echo $this->parse_accounts( $a );
				echo '</ul>';
				echo '</li>';
			}
		}
		echo '</ul>';
		echo '</div>';

	}

	private function parse_accounts( $account ) {

		$account = array_slice( $account, 2 );

		$output = '';
		
		foreach ( $account as $k => $v ) {
			$output .= '<li class="' . $k . '"><a href="' . $v . '">' . $k . '</a></li>';
		}

		return $output;

	}

}