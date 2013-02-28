<?php

/**
 * Creates a shortcode to display social media accounts
 */
class SMC_Shortcode {

	/**
	 * The object instance
	 * 
	 * @var object
	 */
	private static $instance;

	/**
	 * Start the engine!
	 */
	public function __construct() {

		self::$instance = $this;

		add_action( 'wp', array( $this, 'init' ) );

	}

	/**
	 * Registers the shortcode with WordPress
	 *
	 * @since 1.0
	 * @return void
	 */
	public function init() {

		add_shortcode( 'smc_display', array( $this, 'display_shortcode' ) );

	}

	/**
	 * Renders the shortcode on the front-end
	 * @param  array  $atts    The attributes passed through the shortcode
	 * @param  string $content The content between wrapped shortcodes
	 * @return string          The markup and content
	 */
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