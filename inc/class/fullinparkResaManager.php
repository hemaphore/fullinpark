<?php
if(!class_exists('fullinparkResaManager')):
  class fullinparkResaManager{
    public static function get_resa_from_time_slot($date, $hour){
      global $wpdb;

      $alt_current_day = date('d/m/Y', (strtotime($date)));

      $sql = "SELECT * FROM {$wpdb->prefix}posts";
      $sql .= " INNER JOIN {$wpdb->prefix}postmeta m1 ON ({$wpdb->prefix}posts.ID = m1.post_id)";
      $sql .= " WHERE {$wpdb->prefix}posts.post_type = 'fip_resa' AND {$wpdb->prefix}posts.post_status != 'trash'";
      $sql .= " AND (m1.meta_key = 'resa_date' AND (m1.meta_value = '$date' OR m1.meta_value = '$alt_current_day'))";
      $all_resa = $wpdb->get_results($sql);

      return $all_resa;
    }

    public static function get_resa_from_day($date){
      global $wpdb;

      $alt_current_day = date('d/m/Y', (strtotime($date)));

      $sql = "SELECT * FROM {$wpdb->prefix}posts";
      $sql .= " INNER JOIN {$wpdb->prefix}postmeta m1 ON ({$wpdb->prefix}posts.ID = m1.post_id)";
      $sql .= " WHERE {$wpdb->prefix}posts.post_type = 'fip_resa' AND {$wpdb->prefix}posts.post_status != 'trash'";
      $sql .= " AND (m1.meta_key = 'resa_date' AND (m1.meta_value = '$date' OR m1.meta_value = '$alt_current_day'))";
      $all_resa = $wpdb->get_results($sql);

      return $all_resa;
    }

    public static function jump_max_resa_by_slot($today_resa, $start_time, $end_time){
      $max_resa = 0;
      $tmp_resa = 0;
      $interval = (60*30);
      $current_time = strtotime($start_time);


      while ($current_time <= strtotime($end_time)):
        foreach ($today_resa as $resa):
          if($current_time == strtotime(date('G:i', strtotime(get_post_meta($resa->ID, 'resa_hour', true)))) AND get_post_meta($resa->ID, 'resa_jump', true) != 0):
            $tmp_resa = $tmp_resa+1;
          endif;
        endforeach;

        if($tmp_resa > $max_resa):
          $max_resa = $tmp_resa;
        endif;

        $tmp_resa = 0;
        $current_time += $interval;
      endwhile;

      return $max_resa;
    }

    public static function kids_max_resa_by_slot($today_resa, $start_time, $end_time){
      $max_resa = 0;
      $tmp_resa = 0;
      $interval = (60*30);
      $current_time = strtotime($start_time);

      while ($current_time <= strtotime($end_time)):
        foreach ($today_resa as $resa):
          if($current_time == strtotime(date('G:i', strtotime(get_post_meta($resa->ID, 'resa_hour', true)))) AND get_post_meta($resa->ID, 'resa_kids', true) != 0):
            $tmp_resa = $tmp_resa+1;
          endif;
        endforeach;

        if($tmp_resa > $max_resa):
          $max_resa = $tmp_resa;
        endif;

        $tmp_resa = 0;
        $current_time += $interval;
      endwhile;

      return $max_resa;
    }
  }
endif;
