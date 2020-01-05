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
  add_options_page('FullInPark', 'FullInPark',  'manage_options', 'options_page_slug', 'fullinparksettings_page');
}
add_action('admin_menu', 'fullinpark_admin_menu');

function fullinparksettings_page(){
  require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/settings.php');
}
