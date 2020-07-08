<?php
/*
Plugin Name:  WhalePress Scripts
Description:  WhalePress - Headless WordPress Docker Scripts
Version:      1.0.0
Author:       Ian Ray
*/

if(! defined('ABSPATH')){ return; }

/**
 * .env
 */
require_once(__DIR__ . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(ABSPATH);
$dotenv->load();

/**
 * Plugin instance
 */
require_once( 'lib/class-whalepress.php' );
require_once( 'lib/class-whalepress-settings.php' );

/**
 * Returns the main instance of plugin (lib/class-whalepress.php)
 *
 * @since  1.0.0
 * @return object WhalePress
 */
function WhalePress () {
	$instance = WhalePress::instance( __FILE__, '1.0.0' );
	if ( is_null( $instance->settings ) ) {
		$instance->settings = WhalePress_Scripts::instance( $instance );
  }
  return $instance;
}

WhalePress();
