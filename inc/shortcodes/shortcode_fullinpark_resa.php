<?php
if(!class_exists('FIPResa')):
  class FIPResa{
    function __construct(){
      add_shortcode('fullinpark_resa', array( $this, 'shortcode_fullinpark_resa_html'));
    }

    function shortcode_fullinpark_resa_html($atts, $content){
      ob_start();
      include PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/resa.php';
      return ob_get_clean();
    }
  }
endif;
