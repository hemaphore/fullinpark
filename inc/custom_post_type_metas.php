<?php
//Custom Metas Box
if(!function_exists('fullinpark_add_metaboxes')):
  function fullinpark_add_metaboxes(){
    //Stages
    add_meta_box('fip_stage_activities', 'Activité', 'fip_stage_activities_html', 'fip_stage', 'advanced', 'high');
    add_meta_box('fip_stage_resa', 'Reservation(s)', 'fip_stage_resa_html', 'fip_stage', 'advanced', 'high');

    //Resa
    add_meta_box('fip_resa_details', 'Informations sur la réservation', 'fip_resa_details_html', 'fip_resa', 'advanced', 'high');
    add_meta_box('fip_resa_extra', 'Informations complémentaires', 'fip_resa_extra_html', 'fip_resa', 'advanced', 'high');
    add_meta_box('fip_resa_contact', 'Informations de contact', 'fip_resa_contact_html', 'fip_resa', 'advanced', 'high');
    add_meta_box('fip_resa_note', 'Notes', 'fip_resa_notes_html', 'fip_resa', 'side', 'high');
    add_meta_box('fip_resa_statement', 'État', 'fip_resa_statement_html', 'fip_resa', 'side', 'high');

    //Questions
    add_meta_box('fip_question_coordonates', 'Cordonnées client', 'fip_question_coordonates_html', 'fip_question', 'advanced', 'high');

    //Structures
    add_meta_box('fip_structures_infos', 'Informations', 'fip_structures_infos_html', 'fip_structure', 'advanced', 'high');

    //Riders
    add_meta_box('fip_riders_infos', 'Détails', 'fip_riders_infos_html', 'fip_riders', 'side', 'high');
  }
endif;
add_action('add_meta_boxes', 'fullinpark_add_metaboxes');

//Stages
require(PLUGIN_FIP_DIRECTORY.'inc/metas/metas_stages.php');

//Résa
require(PLUGIN_FIP_DIRECTORY.'inc/metas/metas_resa.php');

//Questions
require(PLUGIN_FIP_DIRECTORY.'inc/metas/metas_questions.php');

//Questions
require(PLUGIN_FIP_DIRECTORY.'inc/metas/metas_structures.php');

//Riders
require(PLUGIN_FIP_DIRECTORY.'inc/metas/metas_riders.php');
