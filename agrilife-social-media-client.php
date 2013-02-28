<?php

/*
Plugin Name: AgriLife Social Media Client
Plugin URI: https://github.com/AgriLife/AgriLife-Social-Media-Client
Description: Pulls registered social media accounts and displays them using a widget or shortcode.
Version: 1.0
Author: J. Aaron Eaton
Author URI: http://channeleaton.com
*/

/**
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 */


// Plugin Definitions
define( 'SMC_PLUGIN_NAME', 'AgriLife Social Media Client' );
define( 'SMC_PLUGIN_DIR', 'agrilife-social-media-client' );
define( 'SMC_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'SMC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Register the autoloading function
spl_autoload_register( 'AgriLife_SM_Client::autoload' );

/**
 * The main plugin class
 */
class AgriLife_SM_Client {

	/**
	 * The class instance
	 *
	 * @since 1.0
	 * @var object
	 */
	private static $instance;

	/**
	 * The plugin version number
	 *
	 * @since 1.0
	 * @var string
	 */
	public static $version = '1.0';

	/**
	 * Class constructor
	 */
	public function __construct() {

		// Save this instance of the class
		self::$instance = $this;

		// Fire off the init function
		add_action( 'init', array( $this, 'init' ) );

	}

	/**
	 * Instantiates the required classes
	 *
	 * @since 1.0
	 * @return void
	 */
	public function init() {

		$smc_settings = new SMC_Settings;
		$smc_retrieve = new SMC_Payload;
		$smc_shortcode = new SMC_Shortcode;

	}

	/**
	 * Autoloads the requested class. PSR-0 compliant
	 *
	 * @since 1.0
	 * @param  string $classname The name of the class
	 */
	public static function autoload( $classname ) {

	  $filename = dirname( __FILE__ ) .
	    DIRECTORY_SEPARATOR .
	    str_replace( '_', DIRECTORY_SEPARATOR, $classname ) .
	    '.php';
	    
	  if ( file_exists( $filename ) )
	  	require $filename;

	}

	/**
	 * Returns the class instance
	 *
	 * @since 1.0
	 * @return object The class instance
	 */
	public static function get_instance() {

		return self::$instance;

	}

}

// Instantiate the plugin
new AgriLife_SM_Client;
