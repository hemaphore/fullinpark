<?php
//Custom Metas Box
if(!function_exists('fullinpark_add_metaboxes')):
  function fullinpark_add_metaboxes(){
    //Stages
    add_meta_box('fip_stage_date', 'Date du stage', 'fip_stage_date_html', 'fip_stage', 'advanced', 'high');

    //Resa
    add_meta_box('fip_resa_details', 'Informations sur la réservation', 'fip_resa_details_html', 'fip_resa', 'advanced', 'high');
    add_meta_box('fip_resa_contact', 'Informations de contact', 'fip_resa_contact_html', 'fip_resa', 'advanced', 'high');

    //Question
    add_meta_box('fip_question_coordonates', 'Cordonnées client', 'fip_question_coordonates_html', 'fip_question', 'advanced', 'high');

  }
endif;
add_action('add_meta_boxes', 'fullinpark_add_metaboxes');

//Stages
require(PLUGIN_FIP_DIRECTORY.'inc/metas/metas_stages.php');

//Résa
require(PLUGIN_FIP_DIRECTORY.'inc/metas/metas_resa.php');

//Questions
require(PLUGIN_FIP_DIRECTORY.'inc/metas/metas_questions.php');
