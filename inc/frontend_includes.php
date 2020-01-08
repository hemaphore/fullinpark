<?php
function fullinpark_frontend_includes(){
  //Shortcode resa
  wp_enqueue_style('shortcode_fullinpark_resa_style', plugins_url().'/fullinpark/css/shortcodes/shortcode_fullinpark_resa.css');
  wp_enqueue_script('shortcode_fullinpark_resa_script', plugins_url().'/fullinpark/js/shortcodes/shortcode_fullinpark_resa.js', array( 'jquery' ));

  //Shortcode modify resa
  wp_enqueue_style('shortcode_fullinpark_modify_resa_style', plugins_url().'/fullinpark/css/shortcodes/shortcode_fullinpark_modify_resa.css');
  wp_enqueue_script('shortcode_fullinpark_modify_resa_script', plugins_url().'/fullinpark/js/shortcodes/shortcode_fullinpark_modify_resa.js', array( 'jquery' ));

  wp_enqueue_media();
  wp_enqueue_script( 'jquery-ui-datepicker' );
  wp_enqueue_style( 'jquery-ui', 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css');
}
add_action('wp_enqueue_scripts', 'fullinpark_frontend_includes');
