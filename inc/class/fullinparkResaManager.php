<?php
if(!class_exists('fullinparkResaManager')):
  class fullinparkResaManager{
    public static function get_resa_from_time_slot($date, $hour){
      global $wpdb;

      $sql = "SELECT * FROM {$wpdb->prefix}posts";
      $sql .= " INNER JOIN {$wpdb->prefix}postmeta m1 ON ({$wpdb->prefix}posts.ID = m1.post_id)";
      $sql .= " WHERE {$wpdb->prefix}posts.post_type = 'fip_resa' AND {$wpdb->prefix}posts.post_status != 'trash'";
      $sql .= " AND (m1.meta_key = 'resa_date' AND (m1.meta_value = '$current_day' OR m1.meta_value = '$alt_current_day'))";
      $all_resa = $wpdb->get_results($sql);

      return 7;
    }

    public static function get_resa_from_day($date){
      global $wpdb;

      $sql = "SELECT * FROM {$wpdb->prefix}posts";
      $sql .= " INNER JOIN {$wpdb->prefix}postmeta m1 ON ({$wpdb->prefix}posts.ID = m1.post_id)";
      $sql .= " WHERE {$wpdb->prefix}posts.post_type = 'fip_resa' AND {$wpdb->prefix}posts.post_status != 'trash'";
      $sql .= " AND (m1.meta_key = 'resa_date' AND (m1.meta_value = '$current_day' OR m1.meta_value = '$alt_current_day'))";
      $all_resa = $wpdb->get_results($sql);

      return 7;
    }
  }
endif;
