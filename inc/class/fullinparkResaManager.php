<?php
require(PLUGIN_FIP_DIRECTORY.'inc/class/resa/fullinparkResaWarningManager.php');
require(PLUGIN_FIP_DIRECTORY.'inc/class/resa/fullinparkResaJumpManager.php');
require(PLUGIN_FIP_DIRECTORY.'inc/class/resa/fullinparkResaStructureManager.php');
require(PLUGIN_FIP_DIRECTORY.'inc/class/resa/fullinparkResaAnniversaryManager.php');
require(PLUGIN_FIP_DIRECTORY.'inc/class/resa/fullinparkResaStageManager.php');
require(PLUGIN_FIP_DIRECTORY.'inc/class/resa/fullinparkResaCourseManager.php');
require(PLUGIN_FIP_DIRECTORY.'inc/class/resa/fullinparkResaOtherManager.php');

if(!class_exists('fullinparkResaManager')):
  class fullinparkResaManager{
    public static $duration_coef = array(
      '0:30' => 0.5,
      '1:00' => 1,
      '1:30' => 1.5,
      '2:00' => 2,
      '2:30' => 2.5,
      '3:00' => 3,
      '3:30' => 3.5,
      '4:00' => 4,
      '4:30' => 4.5,
      '5:00' => 5
    );

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

    public static function jump_resa_number_by_slot($today_resa, $hour){
      return fullinparkResaJumpManager::jump_resa_number_by_slot($today_resa, $hour);
    }

    public static function kids_resa_number_by_slot($today_resa, $hour){
      return fullinparkResaJumpManager::kids_resa_number_by_slot($today_resa, $hour);
    }

    public static function structure_jump_resa_number_by_slot($today_resa, $hour){
      return fullinparkResaStructurepManager::structure_jump_resa_number_by_slot($today_resa, $hour);
    }

    public static function structure_jump_kids_number_by_slot($today_resa, $hour){
      return fullinparkResaStructurepManager::structure_jump_kids_number_by_slot($today_resa, $hour);
    }

    public static function anniversary_jump_resa_number_by_slot($today_resa, $hour){
      return fullinparkResaAnniversaryManager::anniversary_c1_resa_number_by_slot($today_resa, $hour) + fullinparkResaAnniversaryManager::anniversary_c2_resa_number_by_slot($today_resa, $hour);
    }

    public static function anniversary_kids_resa_number_by_slot($today_resa, $hour){
      return fullinparkResaAnniversaryManager::anniversary_kids_resa_number_by_slot($today_resa, $hour);
    }

    public static function stage_jump_resa_number_by_slot($today_resa, $hour){
      return fullinparkResaStageManager::stage_jump_resa_number_by_slot($today_resa, $hour);
    }

    public static function stage_kids_resa_number_by_slot($today_resa, $hour){
      $total_kids = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Stage'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if($hour >= $resa_hour AND $hour < $resa_duration):
            $total_kids = $total_kids + intval(get_post_meta($resa->ID, 'resa_kids', true));
          endif;
        endif;
      endforeach;

      return $total_kids;
    }

    public static function course_jump_resa_number_by_slot($today_resa, $hour){
      return fullinparkResaCourseManager::course_jump_resa_number_by_slot($today_resa, $hour);
    }

    public static function course_kids_resa_number_by_slot($today_resa, $hour){
      $total_kids = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Course'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if($hour >= $resa_hour AND $hour < $resa_duration):
            $total_kids = $total_kids + intval(get_post_meta($resa->ID, 'resa_kids', true));
          endif;
        endif;
      endforeach;

      return $total_kids;
    }

    public static function other_jump_resa_number_by_slot($today_resa, $hour){
      return fullinparkResaOtherpManager::other_jump_resa_number_by_slot($today_resa, $hour);
    }

    public static function other_kids_resa_number_by_slot($today_resa, $hour){
      return fullinparkResaOtherpManager::other_kids_resa_number_by_slot($today_resa, $hour);
    }

    public static function total_jump_resa_by_slot($today_resa, $hour){
      $total_jump = self::jump_resa_number_by_slot($today_resa, $hour) + self::structure_jump_resa_number_by_slot($today_resa, $hour) + self::anniversary_jump_resa_number_by_slot($today_resa, $hour) + self::stage_jump_resa_number_by_slot($today_resa, $hour) + self::course_jump_resa_number_by_slot($today_resa, $hour) + self::other_jump_resa_number_by_slot($today_resa, $hour);
      return $total_jump;
    }

    public static function total_real_jump_resa_by_slot($today_resa, $hour){
      $current_date = strtotime(date('Y-m-d'));

      foreach ($today_resa as $resa):
        $current_date = strtotime(get_post_meta($resa->ID, 'resa_date', true));
      endforeach;

      if(empty($today_resa)):
        $current_date = strtotime(date('Y-m-d')) + ($_GET['day'] * (24 * 3600));
      endif;

      $now = strtotime(date('Y-m-d'));
      $now_hour = strtotime(date('H:i'));
      $end_previ = ($now_hour + (60*60));

      if($current_date > $now):
        return '-';
      elseif($current_date == $now AND $hour > $end_previ):
        return '-';
      else:
        $total_jump = fullinparkResaJumpManager::jump_resa_real_number_by_slot($today_resa, $hour)
        + fullinparkResaStructurepManager::structure_jump_resa_real_number_by_slot($today_resa, $hour)
        + fullinparkResaAnniversaryManager::anniversary_c1_resa_real_number_by_slot($today_resa, $hour)
        + fullinparkResaAnniversaryManager::anniversary_c2_resa_real_number_by_slot($today_resa, $hour)
        + fullinparkResaStageManager::stage_jump_resa_real_number_by_slot($today_resa, $hour)
        + fullinparkResaCourseManager::course_jump_resa_real_number_by_slot($today_resa, $hour)
        + fullinparkResaOtherpManager::other_jump_resa_real_number_by_slot($today_resa, $hour);
      endif;

      return $total_jump;
    }

    public static function total_kids_resa_by_slot($today_resa, $hour){
      $total_kids = self::kids_resa_number_by_slot($today_resa, $hour) + self::structure_jump_kids_number_by_slot($today_resa, $hour) + self::anniversary_kids_resa_number_by_slot($today_resa, $hour) + self::other_kids_resa_number_by_slot($today_resa, $hour);
      return $total_kids;
    }

    public static function total_real_kids_resa_by_slot($today_resa, $hour){
      $current_date = strtotime(date('Y-m-d'));

      foreach ($today_resa as $resa):
        $current_date = strtotime(get_post_meta($resa->ID, 'resa_date', true));
      endforeach;

      if(empty($today_resa)):
        $current_date = strtotime(date('Y-m-d')) + ($_GET['day'] * (24 * 3600));
      endif;

      $now = strtotime(date('Y-m-d'));
      $now_hour = strtotime(date('H:i'));
      $end_previ = ($now_hour + (60*60));

      if($current_date >= $now AND $hour > $end_previ):
        return '-';
      elseif($current_date > $now):
        return '-';
      else:
        $total_kids = fullinparkResaJumpManager::kids_resa_real_number_by_slot($today_resa, $hour) + fullinparkResaStructurepManager::structure_jump_kids_real_number_by_slot($today_resa, $hour) + fullinparkResaAnniversaryManager::anniversary_kids_resa_real_number_by_slot($today_resa, $hour) + fullinparkResaOtherpManager::other_kids_resa_real_number_by_slot($today_resa, $hour);
      endif;

      return $total_kids;
    }

    public static function total_private_course_resa_by_slot($today_resa, $hour){
      $total_course = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Course' AND get_post_meta($resa->ID, 'resa_private_course', true)):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));

          if(strtotime($hour) == $resa_hour):
            $total_course = $total_course + intval(get_post_meta($resa->ID, 'resa_jump', true));
          endif;
        endif;
      endforeach;

      return $total_course;
    }

    public static function total_other_jump_resa_by_day($today_resa){
      $total_jump = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Course'):
          $total_jump = $total_jump + intval(get_post_meta($resa->ID, 'resa_jump', true));
        endif;
      endforeach;

      return $total_jump;
    }

    public static function total_jump_resa_by_day($today_resa){
      $total_jump = 0;

      foreach ($today_resa as $resa):
        $total_jump = $total_jump + intval(get_post_meta($resa->ID, 'resa_jump', true));
      endforeach;

      return $total_jump;
    }

    public static function total_real_jump_resa_by_day($today_resa){
      $total_jump = 0;

      foreach ($today_resa as $resa):
        $total_jump = $total_jump + intval(get_post_meta($resa->ID, 'people_arrived', true));
      endforeach;

      return $total_jump;
    }

    public static function total_stats_jump_resa_by_day($today_resa){
      $stats = array(
        "entries" => 10,
        "other" => self::total_other_jump_resa_by_day($today_resa),
        "total" => self::total_jump_resa_by_day($today_resa)
      );

      return $stats;
    }

    public static function total_kids_resa_by_day($today_resa){
      $total_kids = 0;

      foreach ($today_resa as $resa):
        $total_kids = $total_kids + intval(get_post_meta($resa->ID, 'resa_kids', true));
      endforeach;

      return $total_kids;
    }

    public static function total_real_kids_resa_by_day($today_resa){
      $total_jump = 0;

      foreach ($today_resa as $resa):
        $total_jump = $total_jump + intval(get_post_meta($resa->ID, 'kids_arrived', true));
      endforeach;

      return $total_jump;
    }

    public static function is_jump_slot_full($date, $hour, $resa_jump, $duration){
      $today_resa = self::get_resa_from_day($date);

      $duration_coef = array(
        '1:00' => 2,
        '1:30' => 3,
        '2:00' => 4,
        '2:30' => 5,
        '3:00' => 6,
        '3:30' => 7,
        '4:00' => 8,
        '4:30' => 9,
        '5:00' => 10
      );

      for($i=0; $i < $duration_coef[$duration]; $i++):
        $jump_resa_registered = self::total_jump_resa_by_slot($today_resa, ($hour + ($i * 1800)));
        $total_resa_jump = $jump_resa_registered + $resa_jump;
        if($total_resa_jump > get_option('max_jump_resa')):
          return true;
        endif;
      endfor;

      return false;
    }

    public static function is_kids_slot_full($date, $hour, $resa_kids, $duration){
      $today_resa = self::get_resa_from_day($date);

      $duration_coef = array(
        '1:00' => 2,
        '1:30' => 3,
        '2:00' => 4,
        '2:30' => 5,
        '3:00' => 6,
        '3:30' => 7,
        '4:00' => 8,
        '4:30' => 9,
        '5:00' => 10
      );

      for($i=0; $i < $duration_coef[$duration]; $i++):
        $kids_resa_registered = self::total_kids_resa_by_slot($today_resa, ($hour + ($i * 1800)));
        $total_resa_kids = $kids_resa_registered + $resa_kids;
        if($total_resa_kids > get_option('max_kids_resa')):
          return true;
        endif;
      endfor;

      return false;
    }

    public static function is_private_course_slot_full($date, $hour, $resa_jump){
      $today_resa = self::get_resa_from_day($date);

      $course_resa_registered = self::total_private_course_resa_by_slot($today_resa, $hour) + $resa_jump;
      if($course_resa_registered > get_option('max_private_course')):
        return true;
      endif;

      return false;
    }

    public static function is_rider_available($date, $hour, $rider_id = 0){
      global $wpdb;

      if(fullinparkCompanyManager::is_holidays(strtotime($date))):
        if((strtotime('12:00') <= strtotime($hour) AND strtotime($hour) < strtotime('14:00')) OR strtotime($hour) > strtotime('18:00')):
          return true;
        endif;
      else:
        if(date('w', strtotime($date)) == 0 OR date('w', strtotime($date)) > 2):
          if((strtotime('12:00') <= strtotime($hour) AND strtotime($hour) < strtotime('14:00')) OR strtotime($hour) > strtotime('18:00')):
            return true;
          endif;
        endif;
      endif;

      return false;
    }

    public static function is_resa_submited($date, $hour, $email){
      global $wpdb;

      $last_resa = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'fip_resa' AND post_status != 'trash' ORDER BY post_date DESC LIMIT 1 ");

      $resa_id = $last_resa[0]->ID;
      $resa_date = get_post_meta($resa_id, 'resa_date', true);
      $resa_hour = get_post_meta($resa_id, 'resa_hour', true);
      $resa_email = get_post_meta($resa_id, 'resa_contact_email', true);

      if($resa_date == $date AND $resa_hour == $hour AND $resa_email == $email):
        return true;
      endif;

      return false;
    }

    public static function convertDateFormat($date){
      $pos = strrpos($date, "/");

      if($pos === false):
        return $date;
      endif;

      $old_date = explode('/', $date);
      $new_data = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
      return $new_data;
    }
  }
endif;
