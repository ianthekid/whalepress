<?php

/**
 * AJAX callback - run bash scripts via shell_exec()
 */
function headless_scripts() {
  $cmd = SCRIPTS_DIR .'/' .$_REQUEST['script'];

  echo shell_exec($cmd.' 2>&1');
  //Always die in functions echoing ajax content
  die();
}
add_action('wp_ajax_headless_scripts', 'headless_scripts');


/**
 * Plugin Menu page: Bash Scripts
 */
function headless_scripts_page() {
  $scripts = [[
      'action'  => 'aws_s3_upload',
      'script'  => 'aws_s3_upload.sh',
      'name'    => 'Upload to AWS S3',
      'info'    => 'Upload (sync) <code>'.ABSPATH.'wp-content/</code> to S3 Bucket. This will replace all contents of S3 Bucket.'
    ], [
      'action'  => 'theme_update',
      'script'  => 'theme_update.sh',
      'name'    => 'Update Theme',
      'info'    => 'Runs <code>git pull</code> for repo, and any build command, set in <code>.env</code>'
  ]];

?>
  <div class="wrap">
    <h1>Bash Scripts</h1>
    <section class="mt-5">

      <table class="table">
      <thead>
        <tr>
          <th></th>
          <th>Docker Script</th>
          <th></th>
          <th>Last Used</th>
        </tr>
      </thead>
      <tbody>

      <?php foreach($scripts as $s) : ?>

        <tr>
          <th></th>
          <td>
            <h4 class="pt-3"><?=$s['name']; ?></h4>
            <?=$s['info']; ?><br/>
            <div class="badge badge-light mt-1 p-2"><?=SCRIPTS_DIR.'/'.$s['script']; ?></div>
          </td>
          <td>
            <button class="btn btn-primary btn-sm headless_action" data-script="<?=$s['script']; ?>">
              Run Script
            </button>
          </td>
          <td><em><?=date("m-d-Y"); ?></em></td>
        </tr>

      <?php endforeach; ?>

      </tbody>
      </table>
    </section>
    <section class="row mt-5">
      <div class="col-11 mx-auto">
        <!-- AJAX results from Bash Scripts -->
        <h4>Shell Console Output</h4>
        <code id="update_status" class="p-3 mt-3"></code>
      </div>
    </section>
  </div>

<?
}

/**
 * Plugin Menu: Main settings page
 */
function headlessWP_settings_page() {

  
  echo '<div class="wrap">';
  echo '<h1>Theme Panel</h1>';
  echo BASE_DIR.'<br/>';
  echo '<h5>.env</h5>';
  echo "SITEURL - ".$_ENV["SITEURL"]."<br/>";
  echo "DOMAIN - ".$_ENV["DOMAIN"]."<br/>";
  echo "THEME_REPO - ".$_ENV["THEME_REPO"]."<br/>";
  echo "THEME_NAME - ".$_ENV["THEME_NAME"]."<br/>";
  echo "BUILD_CMD - ".$_ENV["BUILD_CMD"]."<br/>";
  echo "AWS_KEY - ".$_ENV["AWS_KEY"]."<br/>";
  echo "AWS_SECRET - ".$_ENV["AWS_SECRET"]."<br/>";
  echo "AWS_REGION - ".$_ENV["AWS_REGION"]."<br/>";
  echo "S3BUCKET - ".$_ENV["S3BUCKET"]."<br/>";
  echo "DB_HOST - ".$_ENV["DB_HOST"]."<br/>";
  echo "DB_INSTANCE - ".$_ENV["DB_INSTANCE"]."<br/>";
  echo "DB_NAME - ".$_ENV["DB_NAME"]."<br/>";
  echo "DB_USER - ".$_ENV["DB_USER"]."<br/>";
  echo "DB_PASS - ".$_ENV["DB_PASS"]."<br/>";
  echo "WP_TITLE - ".$_ENV["WP_TITLE"]."<br/>";
  echo "WP_USER - ".$_ENV["WP_USER"]."<br/>";
  echo "WP_PASS - ".$_ENV["WP_PASS"]."<br/>";
  echo "WP_EMAIL - ".$_ENV["WP_EMAIL"]."<br/>";
  

  echo '<form method="post" action="options.php">';

  settings_fields("section");
  do_settings_sections("theme-options");
  submit_button();

  echo '</form>';
  echo '</div>';
}

add_action("admin_menu", function () {
  add_menu_page("HeadlessWP", "HeadlessWP", "manage_options", "headlesswp-panel", "headlessWP_settings_page", null, 99);
  add_submenu_page( "headlesswp-panel", "Bash Scripts", "Bash Scripts", "manage_options", "bash", "headless_scripts_page", null );
});