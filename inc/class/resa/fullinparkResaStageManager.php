<?php
if(!class_exists('fullinparkResaStageManager')):
  class fullinparkResaStageManager{
    public static $duration_coef = array(
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

    public static function stage_jump_resa_number_by_slot($today_resa, $hour){
      $total_jump = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Stage'):
          $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
          $resa_duration = $resa_hour + (self::$duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

          if($hour >= $resa_hour AND $hour < $resa_duration):
            $total_jump = $total_jump + intval(get_post_meta($resa->ID, 'resa_jump', true));
          endif;
        endif;
      endforeach;

      return $total_jump;
    }

    public static function get_jump_stage_people_not_out($today_resa, $hour){
      $people_not_out = 0;

      foreach ($today_resa as $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Stage'):
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

    public static function stage_jump_resa_real_number_by_slot($today_resa, $hour){
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
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Stage'):
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
        return $total_real_jump + self::get_jump_stage_people_not_out($today_resa, $hour);
      endif;

      return $total_real_jump;
    }

    public static function get_stage_resa($date, $hour){
      $today_resa = fullinparkResaManager::get_resa_from_day($date);

      $stage_list = '<ul>';

      foreach ($today_resa as $key => $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Stage'):
          $resa_hour = get_post_meta($resa->ID, 'resa_hour', true);

          if($resa_hour == $hour):
            if(get_post_meta($resa->ID, 'stage_statement', true) == 'confirmed'):
              $paid = 'checked';
            else:
              $paid = '';
            endif;

            $stagiaire_names = '';

            for($i=1; $i <= get_post_meta($resa->ID, 'resa_jump', true); $i++):
              if(get_post_meta($resa->ID, 'stagiaire'.$i.'_lastname', true) == ''):
                $stagiaire_names = get_post_meta($resa->ID, 'resa_contact_fullname', true);
                break;
              endif;

              $stagiaire_names .= get_post_meta($resa->ID, 'stagiaire'.$i.'_lastname', true).' '.get_post_meta($resa->ID, 'stagiaire'.$i.'_firstname', true).' '.get_post_meta($resa->ID, 'stagiaire'.$i.'_age', true).'ans';

              if($i != get_post_meta($resa->ID, 'resa_jump', true)):
                $stagiaire_names .= ' / ';
              endif;
            endfor;

            $stage_list .= '<li><a href="'.esc_url(home_url()).'/wp-admin/post.php?post='.$resa->ID.'&action=edit" target="_blank">'.$stagiaire_names.' - '.get_post_meta($resa->ID, 'resa_jump', true).' Jump</a> <input type="checkbox" name="resa_paid_'.$resa->ID.'" '.$paid.'/></li>';
          endif;
        endif;
      endforeach;

      $stage_list .= '</ul>';

      return $stage_list;
    }

    public static function set_stage_resa($date, $hour){
      $today_resa = fullinparkResaManager::get_resa_from_day($date);

      foreach ($today_resa as $key => $resa):
        if(get_post_meta($resa->ID, 'resa_activity', true) == 'Stage'):
          $resa_hour = get_post_meta($resa->ID, 'resa_hour', true);

          if($resa_hour == $hour AND isset($_POST['resa_paid_'.$resa->ID])):
            update_post_meta($resa->ID, 'stage_statement', 'confirmed');
          elseif($resa_hour == $hour):
            update_post_meta($resa->ID, 'stage_statement', 'booked');
          endif;
        endif;
      endforeach;
    }
  }
endif;
