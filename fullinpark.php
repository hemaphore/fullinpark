<?php
/*
Plugin Name: Full In Park
Description: Gestionnaire des réservations => Shortcode [fullinpark_resa] (formulaire frontend) / Emails de confirmation (réservation + questions) / CTPs Réservations, Questions, Stages
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
      require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/shortcode_fullinpark_modify_resa.php');

      new FIPResa();
      new FIPModifyResa();

      require(PLUGIN_FIP_DIRECTORY.'inc/class/fullinparkResaManager.php');
      require(PLUGIN_FIP_DIRECTORY.'inc/class/fullinparkTeamManager.php');

      add_action('init', array($this, 'register_custom_post_type'));
      register_activation_hook( __FILE__ , array('FIP', 'install'));
      register_uninstall_hook( __FILE__ , array('FIP', 'uninstall'));
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

      $fip_resa_label = array(
        'name'            => 'Réservation',
        'singular_name'   => 'Réservation',
        'menu_name'       => 'Réservations',
        'name_admin_bar'  => 'Réservations',
        'all_items'           => __( 'Tous les Réservations' ),
        'view_item'           => __( 'Voir la Réservation' ),
        'add_new_item'        => __( 'Ajouter une nouvelle Réservation' ),
        'add_new'             => __( 'Ajouter' ),
        'edit_item'           => __( 'Editer la Réservation' ),
        'update_item'         => __( 'Mettre à jour la Réservation' ),
      );

      $fip_resa_args = array(
        'labels'          => $fip_resa_label,
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'capability_type' => 'post',
        'hierachical'     => false,
        'menu_position'   => 3,
        'menu_icon'       => 'dashicons-welcome-learn-more',
        'supports'        => array('title'),
        'taxonomies'      => array(),
        'show_in_rest'    => true,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false
      );

      register_post_type('fip_resa', $fip_resa_args);

      $fip_question_label = array(
        'name'            => 'Question',
        'singular_name'   => 'Question',
        'menu_name'       => 'Questions',
        'name_admin_bar'  => 'Questions',
        'all_items'           => __( 'Tous les Questions' ),
        'view_item'           => __( 'Voir la Question' ),
        'add_new_item'        => __( 'Ajouter une nouvelle Question' ),
        'add_new'             => __( 'Ajouter' ),
        'edit_item'           => __( 'Editer la Question' ),
        'update_item'         => __( 'Mettre à jour la Question' ),
      );

      $fip_question_args = array(
        'labels'          => $fip_question_label,
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'capability_type' => 'post',
        'hierachical'     => false,
        'menu_position'   => 3,
        'menu_icon'       => 'dashicons-welcome-learn-more',
        'supports'        => array('title', 'editor'),
        'taxonomies'      => array(),
        'show_in_rest'    => true,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false
      );

      register_post_type('fip_question', $fip_question_args);
    }

    public static function install(){
      global $wpdb;

      $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}team_member (id INT AUTO_INCREMENT PRIMARY KEY, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL);");
    }

    public static function uninstall(){
      global $wpdb;

      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}team_member;");
    }
  }
endif;

new FIP();
