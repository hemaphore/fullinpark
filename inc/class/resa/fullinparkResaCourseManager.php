<?php
if(!class_exists('fullinparkResaCourseManager')):
  class fullinparkResaCourseManager{
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

    public static function course_jump_resa_number_by_slot($today_resa, $hour){
      $total_jump = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Course'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if($hour >= $resa_hour AND $hour < $resa_duration):
            $total_jump = $total_jump + intval(get_post_meta($resa->ID, 'resa_jump', true));
          endif;
        endif;
      endforeach;

      return $total_jump;
    }

    public static function get_jump_course_people_not_out($today_resa, $hour){
      $people_not_out = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Course'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);
          $now_hour = strtotime(date('H:i'));
          $end_previ = $now_hour + (60*60);

          if($resa_hour < $now_hour AND $resa_duration <= $end_previ):
            $people_not_out += (intval(get_post_meta($resa->ID, 'people_arrived', true)) - intval(get_post_meta($resa->ID, 'people_out', true)));
          endif;
        endif;
      endforeach;

      return $people_not_out;
    }

    public static function course_jump_resa_real_number_by_slot($today_resa, $hour){
      $total_real_jump = 0;

      $current_date = strtotime(date('Y-m-d'));

      foreach ($today_resa as $resa):
        $current_date = strtotime(get_post_meta($resa->ID, 'resa_date', true));
      endforeach;

      $now = strtotime(date('Y-m-d'));
      $now_hour = strtotime(date('H:i'));
      $end_previ = $now_hour + (60*60);
      $is_previ = false;

      if($now_hour < $hour AND $hour < $end_previ AND $current_date == $now):
        $is_previ = true;
      endif;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Course'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if($hour >= $resa_hour AND $hour < $resa_duration):
            if($current_date < $now): //past
              $total_real_jump = $total_real_jump + intval(get_post_meta($resa->ID, 'people_arrived', true));
            elseif($current_date > $now): //future
              $total_real_jump = $total_real_jump + intval(get_post_meta($resa->ID, 'resa_jump', true));
            else:
              if($now_hour < $hour AND $hour < $end_previ):
                $total_real_jump = $total_real_jump + intval(get_post_meta($resa->ID, 'resa_jump', true));
              elseif($hour >= $end_previ): // future
                $total_real_jump = $total_real_jump + intval(get_post_meta($resa->ID, 'resa_jump', true));
              else:
                $total_real_jump = $total_real_jump + intval(get_post_meta($resa->ID, 'people_arrived', true));
              endif;
            endif;
          endif;
        endif;
      endforeach;

      if($is_previ):
        return $total_real_jump + self::get_jump_course_people_not_out($today_resa, $hour);
      endif;

      return $total_real_jump;
    }
  }
endif;
