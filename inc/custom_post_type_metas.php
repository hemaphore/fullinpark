<?php
//Custom Metas Box
if(!function_exists('fullinpark_add_metaboxes')):
  function fullinpark_add_metaboxes(){
    //Stages
    add_meta_box('fip_stage_date', 'Date du stage', 'fip_stage_date_html', 'fip_stage', 'advanced', 'high');

    //Resa
    
  }
endif;
add_action('add_meta_boxes', 'fullinpark_add_metaboxes');

//Stages
require(PLUGIN_FIP_DIRECTORY.'inc/metas/metas_stages.php');
