<?php
if(!class_exists('fullinparkResaOtherpManager')):
  class fullinparkResaOtherpManager{
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

    public static function other_jump_resa_number_by_slot($today_resa, $hour){
      $total_jump = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Other'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if($hour >= $resa_hour AND $hour < $resa_duration):
            $total_jump = $total_jump + intval(get_post_meta($resa->ID, 'resa_jump', true));
          endif;
        endif;
      endforeach;

      return $total_jump;
    }

    public static function get_jump_other_people_not_out($today_resa, $hour){
      $people_not_out = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Other'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);
          $now_hour = strtotime(date('H:i'));
          $end_previ = $now_hour + (60*60);

          if($resa_duration < $now_hour):
            $people_not_out += (intval(get_post_meta($resa->ID, 'people_arrived', true)) - intval(get_post_meta($resa->ID, 'people_out', true)));
          endif;
        endif;
      endforeach;

      return $people_not_out;
    }

    public static function get_current_resa($today_resa, $hour){
      $active_resa = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Other'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));

          if($resa_hour == $hour ):
            $active_resa += (intval(get_post_meta($resa->ID, 'resa_jump', true)));
          endif;
        endif;
      endforeach;

      return $active_resa;
    }

    public static function other_jump_resa_real_number_by_slot($today_resa, $hour){
      $total_real_jump = 0;

      $current_date = strtotime(date('Y-m-d'));

      foreach ($today_resa as $resa):
        $current_date = strtotime(get_post_meta($resa->ID, 'resa_date', true));
      endforeach;

      $now = strtotime(date('Y-m-d'));
      $now_hour = strtotime(date('H:i'));
      $end_previ1 = ($now_hour + (30*60));
      $end_previ2 = ($now_hour + (60*60));
      $is_previ1 = false;
      $is_previ2 = false;
      $is_active = false;

      if($now_hour < $hour AND $hour < $end_previ1 AND $current_date == $now):
        $is_previ1 = true;
      elseif($now_hour < $hour AND $hour > $end_previ1 AND $hour < $end_previ2 AND $current_date == $now):
        $is_previ2 = true;
      endif;

      if(($now_hour - (30*60)) < $hour AND $hour <= $now_hour AND $current_date == $now):
        $is_active = true;
      endif;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Other'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if($hour >= $resa_hour AND $hour < $resa_duration):
            if($current_date < $now): //past
              $total_real_jump = $total_real_jump + intval(get_post_meta($resa->ID, 'people_arrived', true));
            elseif($current_date > $now): //future

            else:
              if($now_hour < $hour AND $hour < $end_previ2 AND (get_post_meta($resa->ID, 'people_arrived', true) == '' OR get_post_meta($resa->ID, 'people_arrived', true) == '0')):

              elseif($hour >= $end_previ2): // future

              else:
                $total_real_jump = $total_real_jump + (intval(get_post_meta($resa->ID, 'people_arrived', true)));
              endif;
            endif;
          endif;
        endif;
      endforeach;

      if($is_previ1):
        return (self::other_jump_resa_number_by_slot($today_resa, ($hour - 1800)) + self::get_current_resa($today_resa, $hour));
      elseif($is_previ2):
        return (self::other_jump_resa_number_by_slot($today_resa, ($hour - 3600)) + self::get_current_resa($today_resa, ($hour - 1800)) + self::get_current_resa($today_resa, $hour));
      elseif($is_active):
        return $total_real_jump + self::get_jump_other_people_not_out($today_resa, $hour);
      endif;

      return $total_real_jump;
    }

    public static function other_kids_resa_number_by_slot($today_resa, $hour){
      $total_kids = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Other'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if($hour >= $resa_hour AND $hour < $resa_duration):
            $total_kids = $total_kids + intval(get_post_meta($resa->ID, 'resa_kids', true));
          endif;
        endif;
      endforeach;

      return $total_kids;
    }

    public static function get_kids_other_people_not_out($today_resa, $hour){
      $people_not_out = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Other'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);
          $now_hour = strtotime(date('H:i'));
          $end_previ = $now_hour + (60*60);

          if($resa_duration < $now_hour):
            $people_not_out += (intval(get_post_meta($resa->ID, 'kids_arrived', true)) - intval(get_post_meta($resa->ID, 'kids_out', true)));
          endif;
        endif;
      endforeach;

      return $people_not_out;
    }

    public static function get_kids_current_resa($today_resa, $hour){
      $active_resa = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Other'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));

          if($resa_hour == $hour ):
            $active_resa += (intval(get_post_meta($resa->ID, 'resa_kids', true)));
          endif;
        endif;
      endforeach;

      return $active_resa;
    }

    public static function other_kids_resa_real_number_by_slot($today_resa, $hour){
      $total_real_kids = 0;

      $current_date = strtotime(date('Y-m-d'));

      foreach ($today_resa as $resa):
        $current_date = strtotime(get_post_meta($resa->ID, 'resa_date', true));
      endforeach;

      $now = strtotime(date('Y-m-d'));
      $now_hour = strtotime(date('H:i'));
      $end_previ1 = ($now_hour + (30*60));
      $end_previ2 = ($now_hour + (60*60));
      $is_previ1 = false;
      $is_previ2 = false;
      $is_active = false;

      if($now_hour < $hour AND $hour < $end_previ1 AND $current_date == $now):
        $is_previ1 = true;
      elseif($now_hour < $hour AND $hour >= $end_previ1 AND $hour < $end_previ2 AND $current_date == $now):
        $is_previ2 = true;
      endif;

      if(($now_hour - (30*60)) < $hour AND $hour <= $now_hour AND $current_date == $now):
        $is_active = true;
      endif;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Other'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if($hour >= $resa_hour AND $hour < $resa_duration):
            if($current_date < $now): //past
              $total_real_kids = $total_real_kids + intval(get_post_meta($resa->ID, 'kids_arrived', true));
            elseif($current_date > $now): //future
              //$total_real_kids = $total_real_kids + intval(get_post_meta($resa->ID, 'resa_kids', true));
            else:
              if($now_hour < $hour AND $hour < $end_previ2):
                //$total_real_kids = $total_real_kids + intval(get_post_meta($resa->ID, 'resa_kids', true));
              elseif($hour >= $end_previ2): // future
                //$total_real_kids = $total_real_kids + intval(get_post_meta($resa->ID, 'resa_kids', true));
              else:
                $total_real_kids = $total_real_kids + (intval(get_post_meta($resa->ID, 'kids_arrived', true)));
              endif;
            endif;
          endif;
        endif;
      endforeach;

      if($is_previ1):
        return (self::other_kids_resa_number_by_slot($today_resa, ($hour - 1800)) + self::get_kids_current_resa($today_resa, $hour));
      elseif($is_previ2):
        return (self::other_kids_resa_number_by_slot($today_resa, ($hour - 3600)) + self::get_kids_current_resa($today_resa, ($hour - 1800)) + self::get_kids_current_resa($today_resa, $hour));
      elseif($is_active):
        return $total_real_kids + self::get_kids_other_people_not_out($today_resa, $hour);
      endif;

      return $total_real_kids;
    }
  }
endif;
