<?php
function fullinpark_admin_includes(){
  //Planning admin
  wp_enqueue_style('fullinpark_main_admin_page_style', plugins_url().'/fullinpark/css/admin/templates/fullinpark.css');
  wp_enqueue_script('fullinpark_main_admin_page_script', plugins_url().'/fullinpark/js/admin/templates/fullinpark.js', array( 'jquery' ));

  //Countdown
  wp_enqueue_style('fullinpark_countdown_style', plugins_url().'/fullinpark/css/admin/templates/countdown.css');
  wp_enqueue_script('fullinpark_countdown_script', plugins_url().'/fullinpark/js/admin/templates/countdown.js', array( 'jquery' ));

  //Settings
  wp_enqueue_style('fullinpark_settings_style', plugins_url().'/fullinpark/css/admin/templates/settings.css');
  wp_enqueue_script('fullinpark_settings_script', plugins_url().'/fullinpark/js/admin/templates/settings.js', array( 'jquery' ));

  // Team
  wp_enqueue_style('fullinpark_team_style', plugins_url().'/fullinpark/css/admin/templates/team.css');


  //Metas
  wp_enqueue_style('fullinpark_stages_metas_style', plugins_url().'/fullinpark/css/metas/metas_stages.css');
  wp_enqueue_script('fullinpark_stages_metas_script', plugins_url().'/fullinpark/js/metas/metas_stages.js', array( 'jquery' ));

  wp_enqueue_script( 'jquery-ui-datepicker' );
  wp_enqueue_style( 'jquery-ui', 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css');
}
add_action('admin_enqueue_scripts', 'fullinpark_admin_includes');
