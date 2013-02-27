<?php

class SMC_Shortcode {

	private static $instance;

	public function __construct() {

		self::$instance = $this;

		add_action( 'wp', array( $this, 'init' ) );

	}

	public function init() {

		add_shortcode( 'smc_display', array( $this, 'display_shortcode' ) );

	}

	public function display_shortcode( $atts, $content = null ) {

		$smc_display = new SMC_Display;

		extract( shortcode_atts( array(
				'org' => '',
			),
			$atts )
		);

		$accounts = $smc_display->show_accounts( $org );

		return $accounts;

	}

}