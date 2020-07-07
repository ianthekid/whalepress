<?php
/*
Plugin Name:  WhalePress Scripts
Description:  WhalePress - Headless WordPress Docker Scripts
Version:      1.0.0
Author:       Ian Ray
*/

if(! defined('ABSPATH')){ return; }

/**
 * Global Constants
 */
//plugin_dir_path( __FILE__ );
define( 'BASE_DIR', plugin_dir_url(__FILE__) );
define( 'SCRIPTS_DIR', '/shared/scripts' );


/**
 * .env
 */
require_once(__DIR__ . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(SCRIPTS_DIR);
$dotenv->load();


/**
 * Add plugin menus
 */
require_once( 'lib/menu_admin_bar.php' );
require_once( 'lib/menu_admin_menu.php' );


/**
 * Load stylesheets, etc.
 */
function headlesswp_assets() {
  //CSS
  wp_register_style( 'bootstrap-styles',  BASE_DIR . 'assets/bootstrap.min.css', array() );
  wp_register_style( 'headlesswp-admin-styles',  BASE_DIR . 'assets/style.css', array(), '0.1.0' );
  wp_enqueue_style( 'bootstrap-styles' );
  wp_enqueue_style( 'headlesswp-admin-styles' );

  //JS
  wp_register_script( 'bootstrap-scripts', BASE_DIR . 'assets/bootstrap.min.js', array(), false, true );
  wp_register_script( 'headlesswp-admin-scripts', BASE_DIR . 'assets/scripts.js', array(), false, true );
  wp_enqueue_script ( 'bootstrap-scripts' );
  wp_enqueue_script ( 'headlesswp-admin-scripts' );
}
add_action( 'admin_enqueue_scripts', 'headlesswp_assets' );
