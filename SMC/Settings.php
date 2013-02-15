<?php

/**
 * Creates the plugin settings
 *
 * @todo Super-admins should have only access to this setting
 */
class SMC_Settings {

	private static $instance;

	public function __construct() {

		$this->set_default();

		add_action( 'admin_init', array( $this, 'initialize_options' ) );
		add_action( 'admin_init', array( $this, 'make_options' ) );
		add_action( 'admin_init', array( $this, 'register_options' ) );

	}

	private function set_default() {

		$option = get_option( 'debug_mode', 'none' );

		if ( $option == 'none' )
			update_option( 'debug_mode', 0  );

	}

	public function initialize_options() {

		add_settings_section( 
			'smd_section',
			'Social Media Directory Options',
			array( $this, 'options_callback' ),
			'general'
		);

	}

	public function options_callback() {

	}

	public function make_options() {

		add_settings_field( 
			'debug_mode',
			'Debug mode',
			array( $this, 'debug_mode_field' ),
			'general',
			'smd_section',
			array(
				'Activate debug mode to bypass the transient cache',
			)
		);

	}

	public function debug_mode_field( $args ) {

		// Get the option. Set debug mode to off if option doesn't exist
		$option = get_option( 'debug_mode', 0 );

		$html = '<select id="debug_mode" name="debug_mode">';
		$html .= '<option value="0"' . selected( $option, 0, false ) . '>Off</option>';
		$html .= '<option value="1"' . selected( $option, 1, false ) . '>On</option>';
		$html .= '</select>';

		$html .= '<label for="debug_mode"> ' . $args[0] . '</label>';

		echo $html;

	}

	public function register_options() {

		register_setting( 
			'general',
			'debug_mode'
		);

	}

}