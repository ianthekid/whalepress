<?php
if(! defined('ABSPATH')){ return; }

class WhalePress_Scripts {

  private static $_instance = null;
  public $parent = null;
  
	/**
	 * Constructor function.
	 * @access  public
	 * @return  void
	 */
  public function __construct( $parent ) {
		$this->parent = $parent;

    //Plugin Menu Pages
    add_action("admin_menu", function () {
      $svg = file_get_contents( $this->parent->dir . 'assets/icon.svg');
      $icon = 'data:image/svg+xml;base64,' . base64_encode($svg);
    
      add_menu_page(
        "WhalePress", 
        "WhalePress", 
        "manage_options", 
        "whalepress-panel", 
        array( $this, 'whalepress_settings_page' ),
        $icon, 
        99
      );
      add_submenu_page( 
        "whalepress-panel", 
        "Docker Scripts", 
        "Docker Scripts", 
        "manage_options", 
        "docker", 
        array( $this, 'whalepress_scripts_page' ),
        null
      );
    });
    
  }


  /**
   * Plugin Menu page: Docker Scripts
   */
  function whalepress_scripts_page() {
    $scripts = [[
        'trigger' => 'aws_s3_upload',
        'script'  => 'aws_s3_upload.sh',
        'name'    => 'Upload to AWS S3',
        'info'    => 'Upload (sync) <code>'.ABSPATH.'wp-content/</code> to S3 Bucket. This will replace all contents of S3 Bucket.'
      ], [
        'trigger' => 'theme_update',
        'script'  => 'theme_update.sh',
        'name'    => 'Update Theme',
        'info'    => 'Runs <code>git pull</code> for repo, and any build command, set in <code>.env</code>'
    ]];

  ?>
    <div class="wrap">
      <section class="mt-2">
        <table class="table">
        <thead>
          <tr>
            <th class="border-top-0"><h2>Docker Scripts</h2></th>
            <th class="border-top-0"></th>
            <th class="border-top-0">Last Used</th>
          </tr>
        </thead>
        <tbody>

        <?php 
          foreach($scripts as $s) :
            $activity = get_option('whalepress_'.$s['trigger']);
            $last_run = $activity ? date("Y-m-d H:i:s", $activity) : '';
        ?>

          <tr>
            <td>
              <h5 class="pt-3"><?=$s['name']; ?></h5>
              <?=$s['info']; ?><br/>
              <div class="badge badge-light mt-1 p-2">
                <?=$this->parent->docker.'/'.$s['script']; ?>
              </div>
            </td>
            <td>
              <button 
                class="btn btn-primary btn-sm whalepress_action" 
                data-script="<?=$s['script']; ?>"
                data-trigger="<?=$s['trigger']; ?>"
              >
                Run Script
              </button>
            </td>
            <td><em><?=$last_run ?></em></td>
          </tr>

        <?php endforeach; ?>

        </tbody>
        </table>
      </section>
      <section class="row mt-5 mx-1">
        <!-- AJAX results from Bash Scripts -->
        <h4>Shell Console Output</h4>
        <code id="update_status" class="p-3 mt-3 mr-3"></code>
      </section>
    </div>

  <?
  }

  /**
   * Plugin Menu: Main settings page
   */
  function whalepress_settings_page() {
    ?>
    <div class="wrap">
    <h1>WhalePress</h1>
    <p>WordPress in a Docker Container on EC2.</p>

    <section class="row mt-5 mx-1">
      <h4>Environment Variables</h4>
      <h5></h5>
      <div class="badge badge-light mt-1 p-2">
        <?=ABSPATH .' .env'; ?>
      </div>

      <code class="w-100 p-3 mt-2 mr-3">
      <?php
        $env_vars = ['SITEURL', 'DOMAIN', 'THEME_REPO', 'THEME_NAME', 'BUILD_CMD', 'AWS_KEY', 'AWS_SECRET', 'AWS_REGION', 'S3BUCKET', 'DB_HOST', 'DB_INSTANCE', 'DB_NAME', 'DB_USER', 'DB_PASS', 'WP_TITLE', 'WP_USER', 'WP_PASS', 'WP_EMAIL'];
        foreach($env_vars as $var) 
          echo "$var=$_ENV[$var]<br/>";
      ?>
      </code>

    </section>

    <?php
  }


  /**
   * Settings Instance - Ensures only one instance of is loaded or can be loaded.
   * @static
   * @return Settings instance
   */
	public static function instance( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

}