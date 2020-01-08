<?php
function fullinpark_admin_includes(){
  //Planning admin
    wp_enqueue_style('fullinpark_main_admin_page_style', plugins_url().'/fullinpark/css/admin/templates/fullinpark.css');

  //Settings
  wp_enqueue_style('fullinpark_settings_style', plugins_url().'/fullinpark/css/admin/templates/settings.css');

  //Metas
  wp_enqueue_style('fullinpark_stages_metas_style', plugins_url().'/fullinpark/css/metas/metas_stages.css');
  wp_enqueue_script('fullinpark_stages_metas_script', plugins_url().'/fullinpark/js/metas/metas_stages.js', array( 'jquery' ));

  wp_enqueue_script( 'jquery-ui-datepicker' );
  wp_enqueue_style( 'jquery-ui', 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css');
}
add_action('admin_enqueue_scripts', 'fullinpark_admin_includes');
