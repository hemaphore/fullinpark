<?php
if(!class_exists('FIPModifyResa')):
  class FIPModifyResa{
    function __construct(){
      add_shortcode('fullinpark_modify_resa', array( $this, 'shortcode_fullinpark_modify_resa_html'));
    }

    function shortcode_fullinpark_modify_resa_html($atts, $content){
      ob_start();
      include PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/modify_resa.php';
      return ob_get_clean();
    }
  }
endif;
