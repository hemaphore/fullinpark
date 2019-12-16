<?php
/*
Plugin Name: Full In Park
Description: Gestionnaire des réservations
Author: Maxime PORPIGLIA
Version: 0.1
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
    }
  }
endif;

new FIP();
