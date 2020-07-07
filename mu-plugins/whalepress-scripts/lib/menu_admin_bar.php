<?php

add_action( 'wp_before_admin_bar_render', function() {
  global $wp_admin_bar;

  // generate parent node
  $args_parent = array(
    'id' => 'headlessMenu',
    'title' => 'HeadlessWP'
  );
  $wp_admin_bar->add_node( $args_parent );

  // generate subnodes
  $menu_nodes = [[
      'id'=>'awsUpdate',
      'title'=>'S3 Update',
      'href' => get_template_directory_uri().'/script.php?sh=aws_s3_upload',
      'parent'=>'headlessMenu'
    ], [
      'id'=>'themeUpdate',
      'title'=>'Update Theme',
      'href' => get_template_directory_uri().'/script.php?sh=theme_update',
      'parent'=>'headlessMenu'
    ], [
        'id'=>'another',
        'title'=>'Loaded works',
        'href' => get_template_directory_uri().'/script.php?sh=another',
        'parent'=>'headlessMenu'
  ]];

  foreach($menu_nodes as $node) {
    $wp_admin_bar->add_node($node);
  }

}, 999 );
