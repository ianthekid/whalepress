<?php

class WhalePress {

	private static $_instance = null;
	public $settings = null;
	public $_version;
	public $file;
  public $dir;
  public $url;
  public $docker;

	/**
	 * Constructor function.
	 * @access  public
	 * @return  void
	 */
	public function __construct( $file = '', $version = '1.0.0' ) {
		$this->_version = $version;

		// Load plugin environment variables
		$this->file   = $file;
		$this->dir    = plugin_dir_path($file);
    $this->url    = plugin_dir_url($file);
    $this->docker = '/shared/scripts';

    /* 
    ToDo: Add plugin menus
      require_once( 'menu-admin-bar.php' );
    */

		// Load admin JS & CSS
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );

		// Add Ajax functions
    add_action( 'wp_ajax_whalepress_scripts',  array( $this, 'whalepress_scripts' ) );
  } // End __construct ()


  /**
   * Admin AJAX callback - run bash scripts via shell_exec()
   */
  function whalepress_scripts() {
    //Log the last time trigger is run
    update_option( 'whalepress_'.$_REQUEST['trigger'], time() );

    //Run bash script and return shell output
    $cmd = $this->docker .'/' .$_REQUEST['script'];
    echo shell_exec($cmd.' 2>&1');
    //Always die in functions echoing ajax content
    die();
  }


  /**
   * Load scripts and stylesheets
   */
  function enqueue_assets() {
    //CSS
    wp_register_style( 'bootstrap-css',  $this->url.'assets/bootstrap.min.css', array() );
    wp_register_style( 'whalepress-css',  $this->url.'assets/style.css', array(), '0.1.0' );
    wp_enqueue_style( 'bootstrap-css' );
    wp_enqueue_style( 'whalepress-css' );

    //JS
    wp_register_script( 'bootstrap-js', $this->url.'assets/bootstrap.min.js', array('jquery'), false, true );
    wp_register_script( 'whalepress-js', $this->url.'assets/scripts.js', array('jquery'), false, true );
    wp_enqueue_script ( 'bootstrap-js' );
    wp_enqueue_script ( 'whalepress-js' );
  }


  /**
   * Main Instance - Ensures only one instance of is loaded or can be loaded.
   * @static
   * @return Main instance
   */
  public static function instance( $file = '', $version = '1.0.0' ) {
    if( is_null( self::$_instance ) ) {
      self::$_instance = new self( $file, $version );
    }
    return self::$_instance;
  } // End instance ()

}