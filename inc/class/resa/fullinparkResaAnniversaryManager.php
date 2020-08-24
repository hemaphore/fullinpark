<?php
if(!class_exists('fullinparkResaAnniversaryManager')):
  class fullinparkResaAnniversaryManager{
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

    public static $annniversary_time_c1 = array(
      array(
        "start" => '10:00',
        "end" => '12:00',
      ),
      array(
        "start" => '13:00',
        "end" => '15:00'
      ),
      array(
        "start" => '15:30',
        "end" => '17:30'
      ),
      array(
        "start" => '18:00',
        "end" => '20:00'
      )
    );

    public static $annniversary_time_c2 = array(
      array(
        "start" => '11:00',
        "end" => '13:00'
      ),
      array(
        "start" => '14:00',
        "end" => '16:00'
      ),
      array(
        "start" => '17:00',
        "end" => '19:00'
      )
    );

    public static function anniversary_valid_c1_time($current_time, $current_day){
      $is_holiday = fullinparkCompanyManager::is_holidays(strtotime($current_day));
      $current_day_index = date('w', strtotime($current_day));

      if($is_holiday):
        foreach(self::$annniversary_time_c1 as $time):
          if($current_time >= strtotime($time['start']) AND $current_time < strtotime($time['end'])):
            return true;
          endif;
        endforeach;
      else:
        if($current_day_index == 3 OR $current_day_index == 6 OR $current_day_index == 0):
          foreach(self::$annniversary_time_c1 as $time):
            if($current_time >= strtotime($time['start']) AND $current_time < strtotime($time['end'])):
              return true;
            endif;
          endforeach;
        elseif($current_day_index == 2 OR $current_day_index == 4 OR $current_day_index == 5):
          if($current_time >= strtotime(self::$annniversary_time_c1[3]['start']) AND $current_time < strtotime(self::$annniversary_time_c1[3]['end'])):
            return true;
          endif;
        else:

        endif;
      endif;

      return false;
    }

    public static function anniversary_is_c1($hour){
      foreach(self::$annniversary_time_c1 as $time):
        if($time['start'] == $hour):
          return true;
        endif;
      endforeach;

      return false;
    }

    public static function anniversary_valid_c2_time($current_time, $current_day){
      $is_holiday = fullinparkCompanyManager::is_holidays(strtotime($current_day));
      $current_day_index = date('w', strtotime($current_day));

      if(!$is_holiday AND $current_day_index != 0 AND $current_day_index != 3 AND $current_day_index != 6):
        return false;
      endif;

      foreach(self::$annniversary_time_c2 as $time):
        if($current_time >= strtotime($time['start']) AND $current_time < strtotime($time['end'])):
          return true;
        endif;
      endforeach;

      return false;
    }

    public static function anniversary_is_c2($hour){
      foreach(self::$annniversary_time_c2 as $time):
        if($time['start'] == $hour):
          return true;
        endif;
      endforeach;

      return false;
    }

    public static function anniversary_c1_resa_number_by_slot($today_resa, $hour){
      $total_jump = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
          $current_day = date('Y-m-d', strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($today_resa[0]->ID, 'resa_date', true))));
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if(self::anniversary_is_c1(date('H:i', $resa_hour))):
            if($hour >= $resa_hour AND $hour < $resa_duration):
              $total_jump = $total_jump + intval(get_post_meta($resa->ID, 'resa_jump', true));
            endif;
          endif;
        endif;
      endforeach;

      return $total_jump;
    }

    public static function get_anniversary_c1_jump_people_not_out($today_resa, $hour){
      $people_not_out = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
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

    public static function get_c1_current_resa($today_resa, $hour){
      $active_resa = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));

          if($resa_hour == $hour AND self::anniversary_is_c1(date('H:i', $hour))):
            $active_resa += (intval(get_post_meta($resa->ID, 'resa_jump', true)));
          endif;
        endif;
      endforeach;

      return $active_resa;
    }

    public static function anniversary_c1_resa_real_number_by_slot($today_resa, $hour){
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
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
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
        return (self::anniversary_c1_resa_number_by_slot($today_resa, ($hour - 1800)) + self::get_c1_current_resa($today_resa, $hour));
      elseif($is_previ2):
        return (self::anniversary_c1_resa_number_by_slot($today_resa, ($hour - 3600)) + self::get_c1_current_resa($today_resa, ($hour - 1800)) + self::get_c1_current_resa($today_resa, $hour));
      elseif($is_active):
        return $total_real_jump + self::get_anniversary_c1_jump_people_not_out($today_resa, $hour);
      endif;

      return $total_real_jump;
    }

    public static function anniversary_c2_resa_number_by_slot($today_resa, $hour){
      $total_jump = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
          $current_day = date('Y-m-d', strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($today_resa[0]->ID, 'resa_date', true))));
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if(self::anniversary_is_c2(date('H:i', $resa_hour))):
            if($hour >= $resa_hour AND $hour < $resa_duration):
              $total_jump = $total_jump + intval(get_post_meta($resa->ID, 'resa_jump', true));
            endif;
          endif;
        endif;
      endforeach;

      return $total_jump;
    }

    public static function get_anniversary_c2_jump_people_not_out($today_resa, $hour){
      $people_not_out = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
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

    public static function get_c2_current_resa($today_resa, $hour){
      $active_resa = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));

          if($resa_hour == $hour AND self::anniversary_is_c2(date('H:i', $hour))):
            $active_resa += (intval(get_post_meta($resa->ID, 'resa_jump', true)));
          endif;
        endif;
      endforeach;

      return $active_resa;
    }

    public static function anniversary_c2_resa_real_number_by_slot($today_resa, $hour){
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
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
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
        return (self::anniversary_c2_resa_number_by_slot($today_resa, ($hour - 1800)) + self::get_c2_current_resa($today_resa, $hour));
      elseif($is_previ2):
        return (self::anniversary_c2_resa_number_by_slot($today_resa, ($hour - 3600)) + self::get_c2_current_resa($today_resa, ($hour - 1800)) + self::get_c2_current_resa($today_resa, $hour));
      elseif($is_active):
        return $total_real_jump + self::get_anniversary_c2_jump_people_not_out($today_resa, $hour);
      endif;

      return $total_real_jump;
    }

    public static function anniversary_kids_resa_number_by_slot($today_resa, $hour){
      $total_kids = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if($hour >= $resa_hour AND $hour < $resa_duration):
            $total_kids = $total_kids + intval(get_post_meta($resa->ID, 'resa_kids', true));
          endif;
        endif;
      endforeach;

      return $total_kids;
    }

    public static function anniversary_c2_resa_kids_number_by_slot($today_resa, $hour){
      $total_kids = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
          $current_day = date('Y-m-d', strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($today_resa[0]->ID, 'resa_date', true))));
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if(self::anniversary_is_c2(date('H:i', $resa_hour))):
            if($hour >= $resa_hour AND $hour < $resa_duration):
              $total_kids = $total_kids + intval(get_post_meta($resa->ID, 'resa_kids', true));
            endif;
          endif;
        endif;
      endforeach;

      return $total_kids;
    }

    public static function get_anniversary_c2_kids_people_not_out($today_resa, $hour){
      $people_not_out = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
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
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));

          if($resa_hour == $hour AND self::anniversary_is_c2(date('H:i', $hour))):
            $active_resa += (intval(get_post_meta($resa->ID, 'resa_kids', true)));
          endif;
        endif;
      endforeach;

      return $active_resa;
    }

    public static function anniversary_kids_resa_real_number_by_slot($today_resa, $hour){
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
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
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
        return (self::anniversary_c2_resa_kids_number_by_slot($today_resa, ($hour - 1800)) + self::get_kids_current_resa($today_resa, $hour));
      elseif($is_previ2):
        return (self::anniversary_c2_resa_kids_number_by_slot($today_resa, ($hour - 3600)) + self::get_kids_current_resa($today_resa, ($hour - 1800)) + self::get_kids_current_resa($today_resa, $hour));
      elseif($is_active):
        return $total_real_kids + self::get_anniversary_c2_kids_people_not_out($today_resa, $hour);
      endif;

      return $total_real_kids;
    }

    public static function resa_number_by_slot($today_resa, $hour){
      $anniversary_number = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Anniversaire'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $current_hour = strtotime($hour);

          if($resa_hour == $current_hour):
            $anniversary_number = $anniversary_number +1;
          endif;
        endif;
      endforeach;

      return $anniversary_number;
    }

    public static function is_available_hour($date, $hour, $resa_number, $formula){
      $today_resa = fullinparkResaManager::get_resa_from_day($date);
      $number_of_anniversary = self::resa_number_by_slot($today_resa, $hour);
      $duration = '2:00';

      if($number_of_anniversary >= 3):
        return false;
      endif;

      /*if($formula == 'FIPKids'):
        if(fullinparkResaManager::is_kids_slot_full($date, $hour,$resa_number, $duration)):
          return false;
        endif;
      else:
        if(fullinparkResaManager::is_jump_slot_full($date, $hour,$resa_number, $duration)):
          return false;
        endif;
      endif;*/

      return true;
    }
  }
endif;
