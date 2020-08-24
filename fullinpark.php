<?php
/*
Plugin Name: Full In Park
Description: Gestionnaire des réservations => Shortcode [fullinpark_resa] (formulaire frontend) / Emails de confirmation (réservation + questions) / CTPs Réservations, Questions, Stages
Author: Maxime PORPIGLIA
Version: 1.3
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
      require(PLUGIN_FIP_DIRECTORY.'inc/class/fullinparkCompanyManager.php');

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
        'supports'        => array('title', 'thumbnail'),
        'taxonomies'      => array(),
        'show_in_rest'    => true,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false
      );

      register_post_type('fip_stage', $fip_stage_args);

      $fip_resa_label = array(
        'name'            => 'Journal des réservations',
        'singular_name'   => 'Journal des réservations',
        'menu_name'       => 'Journal des réservations',
        'name_admin_bar'  => 'Journal des réservations',
        'all_items'           => __( 'Journal des réservations' ),
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
        'menu_name'       => 'Questions %%NotRead%%',
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

      $fip_structure_label = array(
        'name'            => 'Demandes Structures',
        'singular_name'   => 'Demandes Structures',
        'menu_name'       => 'Demandes Structures',
        'name_admin_bar'  => 'Demandes Structures',
        'all_items'           => __( 'Tous les Demandes' ),
        'view_item'           => __( 'Voir la Demande' ),
        'add_new_item'        => __( 'Ajouter une nouvelle Demande' ),
        'add_new'             => __( 'Ajouter' ),
        'edit_item'           => __( 'Editer la Demande' ),
        'update_item'         => __( 'Mettre à jour la Demande' ),
      );

      $fip_structure_args = array(
        'labels'          => $fip_structure_label,
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

      register_post_type('fip_structure', $fip_structure_args);

      $fip_riders_label = array(
        'name'            => 'Riders',
        'singular_name'   => 'Rider',
        'menu_name'       => 'Riders',
        'name_admin_bar'  => 'Riders',
        'all_items'           => __( 'Tous les Riders' ),
        'view_item'           => __( 'Voir le Rider' ),
        'add_new_item'        => __( 'Ajouter un nouveau Rider' ),
        'add_new'             => __( 'Ajouter' ),
        'edit_item'           => __( 'Editer le Rider' ),
        'update_item'         => __( 'Mettre à jour le Rider' ),
      );

      $fip_riders_args = array(
        'labels'          => $fip_riders_label,
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

      register_post_type('fip_riders', $fip_riders_args);
    }

    public static function install(){
      global $wpdb;

      $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}company_open_hours (id INT AUTO_INCREMENT PRIMARY KEY, day VARCHAR(255) NOT NULL, start_hour VARCHAR(255), end_hour VARCHAR(255), holiday BOOLEAN, close BOOLEAN);");
      $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}company_holidays (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255) NOT NULL, start_date DATE, end_date DATE);");
      $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}company_exceptional_opening (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255) NOT NULL, date DATE, start_hour VARCHAR(255), end_hour VARCHAR(255));");
      $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}company_exceptional_closure (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255) NOT NULL, date DATE);");
      $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}team_member (id INT AUTO_INCREMENT PRIMARY KEY, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL);");

      //If table company_open_hours is empty fill it with default value
      $open_hours_table_entries = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}company_open_hours");
      if(count($open_hours_table_entries) <= 0):
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'lundi', 'start_hour' => '', 'end_hour' => '', 'holiday' => false, 'close' => true));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'mardi', 'start_hour' => '18:00', 'end_hour' => '21:00', 'holiday' => false, 'close' => false));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'mercredi', 'start_hour' => '10:00', 'end_hour' => '21:00', 'holiday' => false, 'close' => false));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'jeudi', 'start_hour' => '18:00', 'end_hour' => '21:00', 'holiday' => false, 'close' => false));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'vendredi', 'start_hour' => '18:00', 'end_hour' => '21:00', 'holiday' => false, 'close' => false));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'samedi', 'start_hour' => '09:00', 'end_hour' => '22:00', 'holiday' => false, 'close' => false));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'dimanche', 'start_hour' => '09:00', 'end_hour' => '20:00', 'holiday' => false, 'close' => false));

        //holidays hours
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'lundi', 'start_hour' => '10:00', 'end_hour' => '20:00', 'holiday' => true, 'close' => false));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'mardi', 'start_hour' => '10:00', 'end_hour' => '20:00', 'holiday' => true, 'close' => false));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'mercredi', 'start_hour' => '10:00', 'end_hour' => '20:00', 'holiday' => true, 'close' => false));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'jeudi', 'start_hour' => '10:00', 'end_hour' => '20:00', 'holiday' => true, 'close' => false));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'vendredi', 'start_hour' => '10:00', 'end_hour' => '21:00', 'holiday' => true, 'close' => false));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'samedi', 'start_hour' => '09:00', 'end_hour' => '22:00', 'holiday' => true, 'close' => false));
        $wpdb->insert("{$wpdb->prefix}company_open_hours", array('day' => 'dimanche', 'start_hour' => '09:00', 'end_hour' => '20:00', 'holiday' => true, 'close' => false));
      endif;

      $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}stage_dates (id INT AUTO_INCREMENT PRIMARY KEY, stage_id VARCHAR(255) NOT NULL, stage_date DATE NOT NULL, stage_hour VARCHAR(255) NOT NULL);");
    }

    public static function uninstall(){
      global $wpdb;

      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}company_open_hours;");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}company_holidays;");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}company_exceptional_opening;");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}company_exceptional_closure;");
      $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}team_member;");
    }
  }
endif;

new FIP();
