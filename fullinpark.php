<?php
/*
Plugin Name: Full In Park
Description: Gestionnaire des réservations => Shortcode [fullinpark_resa] (formulaire frontend)
Author: Maxime PORPIGLIA
Version: 1.1
*/

if(!defined('ABSPATH')):
  die;
endif;

define('PLUGIN_FIP_DIRECTORY', plugin_dir_path(__FILE__));
define('PLUGIN_FIP_URL', plugins_url());

if(!class_exists('FIP')):
  class FIP{
    function __construct(){
      require(PLUGIN_FIP_DIRECTORY.'inc/fip_functions.php');
      require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/shortcode_fullinpark_resa.php');

      new FIPResa();

      add_action('init', array($this, 'register_custom_post_type'));
    }

    public function register_custom_post_type(){
      $fip_stage_label = array(
        'name'            => 'Stages',
        'singular_name'   => 'Stages',
        'menu_name'       => 'Stages',
        'name_admin_bar'  => 'Stages',
        'all_items'           => __( 'Tous les Stages' ),
        'view_item'           => __( 'Voir le Stage' ),
        'add_new_item'        => __( 'Ajouter un nouveau Stage' ),
        'add_new'             => __( 'Ajouter' ),
        'edit_item'           => __( 'Editer le Stage' ),
        'update_item'         => __( 'Mettre à jour le Stage' ),
      );

      $fip_stage_args = array(
        'labels'          => $fip_stage_label,
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'capability_type' => 'post',
        'hierachical'     => false,
        'menu_position'   => 3,
        'menu_icon'       => 'dashicons-welcome-learn-more',
        'supports'        => array('title', 'editor', 'thumbnail'),
        'taxonomies'      => array(),
        'show_in_rest'    => true,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false
      );

      register_post_type('fip_stage', $fip_stage_args);
    }
  }
endif;

new FIP();
