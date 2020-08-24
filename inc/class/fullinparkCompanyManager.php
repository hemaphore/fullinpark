<?php
if(!class_exists('fullinparkCompanyManager')):
  class fullinparkCompanyManager{
    public static function get_day_open_hours($day, $holiday){
      global $wpdb;

      $day_infos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}company_open_hours WHERE day = '$day' AND holiday = '$holiday'");

      return $day_infos;
    }

    public static function set_day_open_hours($day, $holiday, $close, $start_hour = '', $end_hour = ''){
      global $wpdb;

      if($close):
        $wpdb->update("{$wpdb->prefix}company_open_hours", array('start_hour' => $start_hour, 'end_hour' => $end_hour, 'close' => $close), array('day' => $day, 'holiday' => $holiday));
      else:
        $wpdb->update("{$wpdb->prefix}company_open_hours", array('start_hour' => $start_hour, 'end_hour' => $end_hour, 'close' => $close), array('day' => $day, 'holiday' => $holiday));
      endif;
    }

    public static function is_holidays($date){
      global $wpdb;

      $all_holiday = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}company_holidays");

      foreach ($all_holiday as $holiday):
        if(strtotime($holiday->start_date) <= $date AND $date <= strtotime($holiday->end_date)):
          return true;
        endif;
      endforeach;

      return false;
    }
  }
endif;
