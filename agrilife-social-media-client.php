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


define( 'PLUGIN_NAME', 'AgriLife Social Media Client' );
define( 'PLUGIN_DIR', 'agrilife-social-media-client' );

spl_autoload_register( 'AgriLife_SM_Client::autoload' );

class AgriLife_SM_Client {

	private static $instance;

	public static $version = '1.0';

	public function __construct() {

		self::$instance = $this;

		add_action( 'init', array( $this, 'init' ) );

	}

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

	public static function get_instance() {

		return self::$instance;

	}

}

new AgriLife_SM_Client;
