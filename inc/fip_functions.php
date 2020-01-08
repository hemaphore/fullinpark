<?php
require(PLUGIN_FIP_DIRECTORY.'inc/admin_includes.php');
require(PLUGIN_FIP_DIRECTORY.'inc/frontend_includes.php');
require(PLUGIN_FIP_DIRECTORY.'inc/custom_post_type_metas.php');

if(!function_exists('custom_ajaxurl')):
  function custom_ajaxurl(){ echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>'; }
endif;
add_action('wp_head', 'custom_ajaxurl');

if(!function_exists('wpdocs_set_html_mail_content_type')):
  function wpdocs_set_html_mail_content_type(){  return 'text/html';  }
endif;

function fullinpark_admin_menu(){
  add_menu_page('Fullinpark', 'Fullinpark', 'manage_options', 'fullinpark_admin', 'fullinpark_admin_page', 'dashicons-admin-generic', '4');
  add_submenu_page('fullinpark_admin', 'fullinpark_countdown', 'Compteur', 'manage_options', 'fullinpark_countdown', 'fullinpark_countdown_page');
  add_submenu_page('fullinpark_admin', 'fullinpark_settings', 'Réglages', 'manage_options', 'fullinpark_settings', 'fullinparksettings_page');
}
add_action('admin_menu', 'fullinpark_admin_menu');

function fullinpark_admin_page(){
  require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark.php');
}

function fullinpark_countdown_page(){
  require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/countdown.php');
}

function fullinparksettings_page(){
  require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/settings.php');
}
