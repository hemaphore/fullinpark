<?php
function fullinpark_frontend_includes(){
  //Shortcode resa
  wp_enqueue_style('shortcode_fullinpark_resa_style', plugins_url().'/fullinpark/css/shortcodes/resa/resa.css');
  wp_enqueue_script('shortcode_fullinpark_resa_script', plugins_url().'/fullinpark/js/shortcodes/resa/resa.js', array( 'jquery' ));
  wp_enqueue_script('shortcode_fullinpark_resa_activities_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/activities.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_anniversary_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/anniversary.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_call_to_action_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/call_to_action.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_courses_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/courses.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_datepicker_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/datepicker.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_stagepicker_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/stagepicker.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_entete_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/entete.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_errors_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/errors.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_offers_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/offers.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_question_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/question.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_recap_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/recap.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_riders_recap_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/riders_recap.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_riders_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/riders.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_stages_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/stages.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_step2_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/step2.js', array('jquery'));
  wp_enqueue_script('shortcode_fullinpark_resa_structure_script', plugins_url().'/fullinpark/js/shortcodes/resa/templates/structure.js', array('jquery'));

  //Shortcode modify resa
  wp_enqueue_style('shortcode_fullinpark_modify_resa_style', plugins_url().'/fullinpark/css/shortcodes/shortcode_fullinpark_modify_resa.css');
  wp_enqueue_script('shortcode_fullinpark_modify_resa_script', plugins_url().'/fullinpark/js/shortcodes/resa/modify_resa.js', array( 'jquery' ));

  wp_enqueue_media();
  wp_enqueue_script( 'jquery-ui-datepicker' );
  wp_enqueue_style( 'jquery-ui', 'https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css');
}
add_action('wp_enqueue_scripts', 'fullinpark_frontend_includes');
