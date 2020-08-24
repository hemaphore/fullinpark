<?php
if(!class_exists('fullinparkResaWarningManager')):
  class fullinparkResaWarningManager{
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

    public static function is_warning($today_resa, $hour, $resa_id = 0){
      $current_date = strtotime(date('Y-m-d'));

      foreach ($today_resa as $resa):
        $current_date = strtotime(get_post_meta($resa->ID, 'resa_date', true));
      endforeach;

      $now = strtotime(date('Y-m-d'));

      if($current_date != $now):
        return false;
      endif;

      $current_hour = date('H:i');

      if(strtotime($current_hour) < $hour):
        return false;
      endif;

      if($resa_id != 0):
        $resa_hour = strtotime(get_post_meta($resa_id, 'resa_hour', true));
        $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa_id, 'resa_duration', true)] * 3600);
        $resa_people_arrived = get_post_meta($resa_id, 'people_arrived', true);
        $resa_people_out = get_post_meta($resa_id, 'people_out', true);

        if(empty($resa_people_out)):
          $resa_people_out = 0;
        endif;

        if(empty($resa_people_arrived)):
          $resa_people_arrived = 0;
        endif;

        if($hour == $resa_hour AND $resa_duration < strtotime($current_hour)  AND $resa_people_out < $resa_people_arrived):
          return true;
        endif;
      else:
        foreach ($today_resa as $resa):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);
          $resa_people_arrived = get_post_meta($resa->ID, 'people_arrived', true);
          $resa_people_out = get_post_meta($resa->ID, 'people_out', true);

          if(empty($resa_people_out)):
            $resa_people_out = 0;
          endif;

          if(empty($resa_people_arrived)):
            $resa_people_arrived = 0;
          endif;

          if($hour == $resa_hour AND $resa_duration < strtotime($current_hour) AND $resa_people_out < $resa_people_arrived):
            return true;
          endif;
        endforeach;
      endif;

      return false;
    }

    public static function is_not_arrived($today_resa, $hour, $resa_id = 0){
      $current_date = strtotime(date('Y-m-d'));

      foreach ($today_resa as $resa):
        $current_date = strtotime(get_post_meta($resa->ID, 'resa_date', true));
      endforeach;

      $now = strtotime(date('Y-m-d'));

      if($current_date != $now):
        return false;
      endif;

      $current_hour = date('H:i');

      if(strtotime($current_hour) < $hour):
        return false;
      endif;

      if($resa_id != 0):
        $resa_hour = strtotime(get_post_meta($resa_id, 'resa_hour', true));
        $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa_id, 'resa_duration', true)] * 3600);
        $resa_people = get_post_meta($resa_id, 'resa_jump', true);
        $resa_people_arrived = get_post_meta($resa_id, 'people_arrived', true);

        if(empty($resa_people)):
          $resa_people = 0;
        endif;

        if(empty($resa_people_arrived)):
          $resa_people_arrived = 0;
        endif;

        if($hour >= $resa_hour AND $hour < $resa_duration AND $resa_people_arrived < $resa_people AND $resa_duration > strtotime($current_hour)):
          return true;
        endif;
      else:
        foreach ($today_resa as $resa):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);
          $resa_people = get_post_meta($resa->ID, 'resa_jump', true);
          $resa_people_arrived = get_post_meta($resa->ID, 'people_arrived', true);

          if(empty($resa_people)):
            $resa_people = 0;
          endif;

          if(empty($resa_people_arrived)):
            $resa_people_arrived = 0;
          endif;

          if($hour >= $resa_hour AND $hour < $resa_duration AND $resa_people_arrived < $resa_people AND $resa_duration > strtotime($current_hour)):
            return true;
          endif;
        endforeach;
      endif;

      return false;
    }

    public static function is_kids_warning($today_resa, $hour, $resa_id = 0){
      $current_date = strtotime(date('Y-m-d'));

      foreach ($today_resa as $resa):
        $current_date = strtotime(get_post_meta($resa->ID, 'resa_date', true));
      endforeach;

      $now = strtotime(date('Y-m-d'));

      if($current_date != $now):
        return false;
      endif;

      $current_hour = date('H:i');

      if(strtotime($current_hour) < $hour):
        return false;
      endif;

      if($resa_id != 0):
        $resa_hour = strtotime(get_post_meta($resa_id, 'resa_hour', true));
        $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa_id, 'resa_duration', true)] * 3600);
        $resa_people_arrived = get_post_meta($resa_id, 'kids_arrived', true);
        $resa_people_out = get_post_meta($resa_id, 'kids_out', true);

        if(empty($resa_people_out)):
          $resa_people_out = 0;
        endif;

        if(empty($resa_people_arrived)):
          $resa_people_arrived = 0;
        endif;

        if($hour == $resa_hour AND $resa_duration < strtotime($current_hour)  AND $resa_people_out < $resa_people_arrived):
          return true;
        endif;
      else:
        foreach ($today_resa as $resa):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);
          $resa_people_arrived = get_post_meta($resa->ID, 'kids_arrived', true);
          $resa_people_out = get_post_meta($resa->ID, 'kids_out', true);

          if(empty($resa_people_out)):
            $resa_people_out = 0;
          endif;

          if(empty($resa_people_arrived)):
            $resa_people_arrived = 0;
          endif;

          if($hour == $resa_hour AND $resa_duration < strtotime($current_hour) AND $resa_people_out < $resa_people_arrived):
            return true;
          endif;
        endforeach;
      endif;

      return false;
    }

    public static function is_kids_not_arrived($today_resa, $hour, $resa_id = 0){
      $current_date = strtotime(date('Y-m-d'));

      foreach ($today_resa as $resa):
        $current_date = strtotime(get_post_meta($resa->ID, 'resa_date', true));
      endforeach;

      $now = strtotime(date('Y-m-d'));

      if($current_date != $now):
        return false;
      endif;

      $current_hour = date('H:i');

      if(strtotime($current_hour) < $hour):
        return false;
      endif;

      if($resa_id != 0):
        $resa_hour = strtotime(get_post_meta($resa_id, 'resa_hour', true));
        $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa_id, 'resa_duration', true)] * 3600);
        $resa_people = get_post_meta($resa_id, 'resa_kids', true);
        $resa_people_arrived = get_post_meta($resa_id, 'kids_arrived', true);

        if(empty($resa_people)):
          $resa_people = 0;
        endif;

        if(empty($resa_people_arrived)):
          $resa_people_arrived = 0;
        endif;

        if($hour <= $resa_hour AND $resa_hour < $resa_duration AND $resa_people_arrived < $resa_people AND $resa_duration > strtotime($current_hour)):
          return true;
        endif;
      else:
        foreach ($today_resa as $resa):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);
          $resa_people = get_post_meta($resa->ID, 'resa_kids', true);
          $resa_people_arrived = get_post_meta($resa->ID, 'kids_arrived', true);

          if(empty($resa_people)):
            $resa_people = 0;
          endif;

          if(empty($resa_people_arrived)):
            $resa_people_arrived = 0;
          endif;

          if($hour >= $resa_hour AND $hour < $resa_duration AND $resa_people_arrived < $resa_people AND $resa_duration > strtotime($current_hour)):
            return true;
          endif;
        endforeach;
      endif;

      return false;
    }
  }
endif;
