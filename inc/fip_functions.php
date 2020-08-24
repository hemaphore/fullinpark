<?php
require(PLUGIN_FIP_DIRECTORY.'inc/admin_includes.php');
require(PLUGIN_FIP_DIRECTORY.'inc/frontend_includes.php');
require(PLUGIN_FIP_DIRECTORY.'inc/custom_post_type_metas.php');
date_default_timezone_set('Europe/Paris');

if(!function_exists('custom_ajaxurl')):
  function custom_ajaxurl(){ echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>'; }
endif;
add_action('wp_head', 'custom_ajaxurl');

if(!function_exists('wpdocs_set_html_mail_content_type')):
  function wpdocs_set_html_mail_content_type(){  return 'text/html';  }
endif;

function fullinpark_admin_menu(){
  add_menu_page('Fullinpark', 'Fullinpark', 'manage_options', 'fullinpark_admin', 'fullinpark_admin_page', 'dashicons-admin-generic', '4');
  add_submenu_page('fullinpark_admin', 'fullinpark_team', 'Équipe', 'manage_options', 'fullinpark_team', 'fullinpark_team_page');
  add_submenu_page('fullinpark_admin', 'fullinpark_planning_team', 'Planning Équipe', 'manage_options', 'fullinpark_planning_team', 'fullinpark_planning_team_page');
  add_submenu_page('fullinpark_admin', 'fullinpark_stats', 'Statistiques', 'manage_options', 'fullinpark_stats', 'fullinpark_stats_page');
  add_submenu_page('fullinpark_admin', 'fullinpark_settings', 'Réglages', 'manage_options', 'fullinpark_settings', 'fullinparksettings_page');
}
add_action('admin_menu', 'fullinpark_admin_menu');

function fullinpark_admin_page(){
  require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark.php');
}

function fullinpark_team_page(){
  require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/team.php');
}

function fullinpark_planning_team_page(){
  require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/planning_team.php');
}

function fullinparksettings_page(){
  require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/settings.php');
}

function fullinpark_stats_page(){
  require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/stats.php');
}


//Ajax Request
function fullinpark_get_resa_info(){
  $parameters = $_POST['parameters'];
  $resa_id = $parameters[0];

  print_r(json_encode(array(
    'jump' => get_post_meta($resa_id, 'resa_jump', true),
    'kids' => get_post_meta($resa_id, 'resa_kids', true),
    'date' => date('d/m/Y', strtotime(get_post_meta($resa_id, 'resa_date', true))),
    'hour' => date('G:i', strtotime(get_post_meta($resa_id, 'resa_hour', true))),
    'fullname' => get_post_meta($resa_id, 'resa_contact_fullname', true),
    'email' => get_post_meta($resa_id, 'resa_contact_email', true),
    'phone' => get_post_meta($resa_id, 'resa_contact_phone', true)
  )));
  die();
}
add_action('wp_ajax_get_resa_info', 'fullinpark_get_resa_info');
add_action('wp_ajax_nopriv_get_resa_info', 'fullinpark_get_resa_info');

function get_disabled_dates(){
  $disabled_dates = [];
  $days = array(
    'dimanche',
    'lundi',
    'mardi',
    'mercredi',
    'jeudi',
    'vendredi',
    'samedi'
  );

  $today = time();
  $start_date = strtotime(date('Y-m-d'));
  $current_date = $start_date;
  $interval = (60*60*24);
  $end_date = strtotime("+6 months",$today);

  while($current_date <= $end_date):
    $day = date('w', $current_date);

    if(fullinparkCompanyManager::is_holidays($current_date)):
      $day_infos = fullinparkCompanyManager::get_day_open_hours($days[date('w', $current_date)], true);
    else:
      $day_infos = fullinparkCompanyManager::get_day_open_hours($days[date('w', $current_date)], false);
    endif;

    if($day_infos[0]->close):
      $disabled_dates[] = date('Y-m-d', $current_date);
    endif;

    $current_date = $current_date + $interval;
  endwhile;

  print_r(json_encode(array(
    'dates' => $disabled_dates
  )));
  die();
}
add_action('wp_ajax_get_disabled_dates', 'get_disabled_dates');
add_action('wp_ajax_nopriv_get_disabled_dates', 'get_disabled_dates');

function get_disabled_date_for_private_course(){
  $disabled_dates = [];
  $days = array(
    'dimanche',
    'lundi',
    'mardi',
    'mercredi',
    'jeudi',
    'vendredi',
    'samedi'
  );

  $today = time();
  $start_date = strtotime(date('Y-m-d'));
  $current_date = $start_date;
  $interval = (60*60*24);
  $end_date = strtotime("+6 months",$today);

  $parameters = $_POST['parameters'];
  $resa_jump = $parameters[0];

  while($current_date <= $end_date):
    $day = date('w', $current_date);

    if(fullinparkCompanyManager::is_holidays($current_date)):
      $day_infos = fullinparkCompanyManager::get_day_open_hours($days[date('w', $current_date)], true);
    else:
      $day_infos = fullinparkCompanyManager::get_day_open_hours($days[date('w', $current_date)], false);
    endif;

    if($day_infos[0]->close OR fullinparkResaManager::is_private_course_slot_full(date('Y-m-d', $current_date), '12:00', $resa_jump)):
      $disabled_dates[] = date('Y-m-d', $current_date);
    endif;

    if(strtotime($day_infos[0]->start_hour) > strtotime('12:00')):
      $disabled_dates[] = date('Y-m-d', $current_date);
    endif;

    $current_date = $current_date + $interval;
  endwhile;

  print_r(json_encode(array(
    'dates' => $disabled_dates
  )));
  die();
}
add_action('wp_ajax_get_disabled_date_for_private_course', 'get_disabled_date_for_private_course');
add_action('wp_ajax_nopriv_get_disabled_date_for_private_course', 'get_disabled_date_for_private_course');

function get_disabled_date_for_collective_course(){
  $parameters = $_POST['parameters'];
  $collective_course_choice = $parameters[0];

  $disabled_dates = [];
  $days = array(
    'dimanche',
    'lundi',
    'mardi',
    'mercredi',
    'jeudi',
    'vendredi',
    'samedi'
  );

  $today = time();
  $start_date = strtotime(date('Y-m-d'));
  $current_date = $start_date;
  $interval = (60*60*24);
  $end_date = strtotime("+6 months",$today);

  while($current_date <= $end_date):
    $day = date('w', $current_date);

    if(fullinparkCompanyManager::is_holidays($current_date)):
      $disabled_dates[] = date('Y-m-d', $current_date);
    else:
      $date_index = date('w', $current_date);
      if($date_index != 3 AND $date_index != 4 AND $date_index != 6):
        $disabled_dates[] = date('Y-m-d', $current_date);
      endif;

      if($collective_course_choice == 'trampo' AND $date_index == 4):
        $disabled_dates[] = date('Y-m-d', $current_date);
      endif;

      if($collective_course_choice == 'parkour' AND $date_index == 4):
        $disabled_dates[] = date('Y-m-d', $current_date);
      endif;

      if($collective_course_choice == 'fitramp' AND $date_index != 4):
        $disabled_dates[] = date('Y-m-d', $current_date);
      endif;
    endif;

    $current_date = $current_date + $interval;
  endwhile;

  print_r(json_encode(array(
    'dates' => $disabled_dates
  )));
  die();
}
add_action('wp_ajax_get_disabled_date_for_collective_course', 'get_disabled_date_for_collective_course');
add_action('wp_ajax_nopriv_get_disabled_date_for_collective_course', 'get_disabled_date_for_collective_course');

function get_non_holiday_dates(){
  $disabled_dates = [];
  $days = array(
    'dimanche',
    'lundi',
    'mardi',
    'mercredi',
    'jeudi',
    'vendredi',
    'samedi'
  );

  $today = time();
  $start_date = strtotime(date('Y-m-d'));
  $current_date = $start_date;
  $interval = (60*60*24);
  $end_date = strtotime("+6 months",$today);

  while($current_date <= $end_date):
    $day = date('w', $current_date);

    if(!fullinparkCompanyManager::is_holidays($current_date)):
      $disabled_dates[] = date('Y-m-d', $current_date);
    endif;

    $current_date = $current_date + $interval;
  endwhile;

  print_r(json_encode(array(
    'dates' => $disabled_dates
  )));
  die();
}
add_action('wp_ajax_get_non_holiday_dates', 'get_non_holiday_dates');
add_action('wp_ajax_nopriv_get_non_holiday_dates', 'get_non_holiday_dates');

function get_stage_diabled_dates(){
  global $wpdb;

  $parameters = $_POST['parameters'];
  $stage_id = $parameters[0];
  $jump_resa = $parameters[1];
  $all_stage_date = array();

  $all_dates = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}stage_dates WHERE stage_id = '$stage_id'");

  foreach ($all_dates as $date):
    if(stage_jump_resa_number_by_slot($date->stage_date, $date->stage_hour) + $jump_resa <= get_option('max_stage_resa')):
      $all_stage_date[] = $date->stage_date;
    endif;
  endforeach;

  $disabled_dates = [];
  $days = array(
    'dimanche',
    'lundi',
    'mardi',
    'mercredi',
    'jeudi',
    'vendredi',
    'samedi'
  );

  $today = time();
  $start_date = strtotime(date('Y-m-d'));
  $current_date = $start_date;
  $interval = (60*60*24);
  $end_date = strtotime("+6 months",$today);

  while($current_date <= $end_date):
    $day = date('w', $current_date);

    if(!fullinparkCompanyManager::is_holidays($current_date)):
      $disabled_dates[] = date('Y-m-d', $current_date);
    else:
      $date_to_test = date('Y-m-d', $current_date);

      if(!in_array($date_to_test, $all_stage_date)):
        $disabled_dates[] = date('Y-m-d', $current_date);
      endif;
    endif;

    $current_date = $current_date + $interval;
  endwhile;

  print_r(json_encode(array(
    'dates' => $disabled_dates,
    'stage_id' => $stage_id,
    'stage_date' => $all_stage_date
  )));
  die();
}
add_action('wp_ajax_get_stage_diabled_dates', 'get_stage_diabled_dates');
add_action('wp_ajax_nopriv_get_stage_diabled_dates', 'get_stage_diabled_dates');

function get_hours_available(){
  $parameters = $_POST['parameters'];
  $now = strtotime(date('Y-m-d'));
  $current_date = $parameters[0];
  $resa_jump = $parameters[1];
  $resa_kids = $parameters[2];
  $duration = $parameters[3];
  $resa_type = $parameters[4];

  $days = array(
    'dimanche',
    'lundi',
    'mardi',
    'mercredi',
    'jeudi',
    'vendredi',
    'samedi'
  );

  $duration_coef = array(
    '1:00' => 1,
    '1:30' => 2,
    '2:00' => 3,
    '2:30' => 4,
    '3:00' => 5,
  );

  if(fullinparkCompanyManager::is_holidays(strtotime($current_date))):
    $day_infos = fullinparkCompanyManager::get_day_open_hours($days[date('w', strtotime($current_date))], true);
  else:
    $day_infos = fullinparkCompanyManager::get_day_open_hours($days[date('w', strtotime($current_date))], false);
  endif;

  $start_hours = $day_infos[0]->start_hour;
  $end_hours = $day_infos[0]->end_hour;
  $interval = (30*60);
  if(strtotime($current_date) > $now):
    $min_hour = strtotime($start_hours);
  else:
    $min_hour = strtotime(date('H:i'));
  endif;
  $current_time = strtotime($start_hours);
  $available_hours = array();

  while($current_time < (strtotime($end_hours) - ($interval * $duration_coef[$duration]))):
    if($current_time >= $min_hour):
      if((!fullinparkResaManager::is_jump_slot_full($current_date, $current_time, $resa_jump, $duration) OR $resa_jump == 0) AND (!fullinparkResaManager::is_kids_slot_full($current_date, $current_time, $resa_kids, $duration) OR $resa_kids == 0)):
        if(!in_array(date('H:i', $current_time), $available_hours)):
          $available_hours[] = date('H:i', $current_time);
        endif;
      endif;
    endif;

    $current_time = $current_time + $interval;
  endwhile;

  print_r(json_encode(array(
    'hours' => $available_hours
  )));
  die();
}
add_action('wp_ajax_get_hours_available', 'get_hours_available');
add_action('wp_ajax_nopriv_get_hours_available', 'get_hours_available');

function get_collective_course_hours_available(){
  $parameters = $_POST['parameters'];
  $current_date = $parameters[0];
  $collective_course_choice = $parameters[1];
  $available_hours = array();
  $day = date('w', strtotime($current_date));

  switch($collective_course_choice):
    case 'trampo':
      if($day == 3):
        $available_hours[] = '14:00';
      endif;

      if($day == 6):
        $available_hours[] = '10:00';
      endif;
      break;
    case 'parkour':
      if($day == 3):
        $available_hours[] = '15:00';
      endif;

      if($day == 6):
        $available_hours[] = '11:00';
      endif;
      break;
    default:
      if($day == 4):
        $available_hours[] = '19:00';
        $available_hours[] = '20:00';
      endif;
      break;
  endswitch;

  print_r(json_encode(array(
    'hours' => $available_hours
  )));
  die();
}
add_action('wp_ajax_get_collective_course_hours_available', 'get_collective_course_hours_available');
add_action('wp_ajax_nopriv_get_collective_course_hours_available', 'get_collective_course_hours_available');

function get_stage_hours_available(){
  global $wpdb;

  $parameters = $_POST['parameters'];
  $current_date = $parameters[0];
  $stage_id = $parameters[1];
  $jump_resa = $parameters[2];

  $all_dates = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}stage_dates WHERE stage_id = '$stage_id' AND stage_date = '$current_date'");

  foreach ($all_dates as $date):
    $available_hours[] = $date->stage_hour;
  endforeach;

  print_r(json_encode(array(
    'hours' => $available_hours
  )));
  die();
}
add_action('wp_ajax_get_stage_hours_available', 'get_stage_hours_available');
add_action('wp_ajax_nopriv_get_stage_hours_available', 'get_stage_hours_available');


function get_anniversary_hours_available(){
  $parameters = $_POST['parameters'];
  $current_date = $parameters[0];
  $anniversary_formula_choice = $parameters[1];
  $anniversary_formula_food = $parameters[2];
  $resa_number = intval($parameters[3]);
  $day = date('w', strtotime($current_date));
  $available_hours = array();

  $annniversary_time = array(
    array(
      "start" => '10:00',
      "end" => '12:00',
    ),
    array(
      "start" => '11:00',
      "end" => '13:00'
    ),
    array(
      "start" => '13:00',
      "end" => '15:00'
    ),
    array(
      "start" => '14:00',
      "end" => '16:00'
    ),
    array(
      "start" => '15:30',
      "end" => '17:30'
    ),
    array(
      "start" => '17:00',
      "end" => '19:00'
    ),
    array(
      "start" => '18:00',
      "end" => '20:00'
    )
  );

  if(fullinparkCompanyManager::is_holidays(strtotime($current_date))):
    if($anniversary_formula_food == 'anniversary_salty'):
      for($i=0; $i < count($annniversary_time); $i++):
        if($annniversary_time[$i]['start'] != '14:00' AND $annniversary_time[$i]['start'] != '15:30'):
          if(fullinparkResaAnniversaryManager::is_available_hour($current_date, $annniversary_time[$i]['start'], $resa_number, $anniversary_formula_choice)):
            $available_hours[] = $annniversary_time[$i]['start'];
          endif;
        endif;
      endfor;
    else:
      for($i=0; $i < count($annniversary_time); $i++):
        if(fullinparkResaAnniversaryManager::is_available_hour($current_date, $annniversary_time[$i]['start'], $resa_number, $anniversary_formula_choice)):
          $available_hours[] = $annniversary_time[$i]['start'];
        endif;
      endfor;
    endif;
  else:
    if($day == 0 OR $day == 3 OR $day == 6):
      if($anniversary_formula_food == 'anniversary_salty'):
        for($i=0; $i < count($annniversary_time); $i++):
          if($annniversary_time[$i]['start'] != '14:00' AND $annniversary_time[$i]['start'] != '15:30'):
            if(fullinparkResaAnniversaryManager::is_available_hour($current_date, $annniversary_time[$i]['start'], $resa_number, $anniversary_formula_choice)):
              $available_hours[] = $annniversary_time[$i]['start'];
            endif;
          endif;
        endfor;
      else:
        for($i=0; $i < count($annniversary_time); $i++):
          if(fullinparkResaAnniversaryManager::is_available_hour($current_date, $annniversary_time[$i]['start'], $resa_number, $anniversary_formula_choice)):
            $available_hours[] = $annniversary_time[$i]['start'];
          endif;
        endfor;
      endif;
    endif;

    if($day == 2 OR $day == 4 OR $day == 5):
      if(fullinparkResaAnniversaryManager::is_available_hour($current_date, $annniversary_time[6]['start'], $resa_number, $anniversary_formula_choice)):
        $available_hours[] = $annniversary_time[6]['start'];
      endif;
    endif;
  endif;

  print_r(json_encode(array(
    'hours' => $available_hours,
    'formula_food' => $anniversary_formula_food,
    'resa_number' => $resa_number,
    'date' => $current_date,
    'formula' => $anniversary_formula_choice,
    'hour' => $annniversary_time[6]['start']
  )));
  die();
}
add_action('wp_ajax_get_anniversary_hours_available', 'get_anniversary_hours_available');
add_action('wp_ajax_nopriv_get_anniversary_hours_available', 'get_anniversary_hours_available');

function is_valid_resa(){
  //check Rider
  $parameters = $_POST['parameters'];
  $date = $parameters[0];
  $hour = $parameters[1];
  $duration = $parameters[2];
  $riders = $parameters[3];
  $activity = $parameters[4];

  $today_resa = fullinparkResaManager::get_resa_from_day(date('Y-m-d', strtotime($date)));
  $jump_max = get_option('max_jump_resa') - fullinparkResaManager::total_jump_resa_by_slot($today_resa, strtotime($hour));
  $kids_max = get_option('max_kids_resa') - fullinparkResaManager::total_kids_resa_by_slot($today_resa, strtotime($hour));

  $message = '';
  $riders_unavailable = false;

  if($riders != 'false'):
    $all_rider = explode(',', $riders);
    for ($i=0; $i < count($all_rider); $i++):
      if(!fullinparkResaManager::is_rider_available($date, $hour, $all_rider[$i])):
        $riders_unavailable = true;
      endif;
    endfor;
  else:
    if(!fullinparkResaManager::is_rider_available($date, $hour)):
      $riders_unavailable = true;
    endif;
  endif;

  print_r(json_encode(array(
    'errors' => true,
    'message' => $message,
    'riders_unavailable' => $riders_unavailable,
    'jump_max' => $jump_max,
    'kids_max' => $kids_max
  )));
  die();
}
add_action('wp_ajax_is_valid_resa', 'is_valid_resa');
add_action('wp_ajax_nopriv_is_valid_resa', 'is_valid_resa');

function valid_resa_edited(){
  $parameters = $_POST['parameters'];
  $date = $parameters[0];
  $hour = strtotime($parameters[1]);
  $duration = $parameters[2];
  $resa_jump = $parameters[3];
  $resa_kids = $parameters[4];

  if((!fullinparkResaManager::is_jump_slot_full($current_date, $hour, $resa_jump, $duration) OR $resa_jump == 0) AND (!fullinparkResaManager::is_kids_slot_full($current_date, $hour, $resa_kids, $duration) OR $resa_kids == 0)):
    $valid = true;
  else:
    $valid = false;
  endif;

  print_r(json_encode(array(
    'valid' => $valid
  )));
  die();
}
add_action('wp_ajax_valid_resa_edited', 'valid_resa_edited');
add_action('wp_ajax_nopriv_valid_resa_edited', 'valid_resa_edited');


function add_extra_infos_to_resa(){
  $parameters = $_POST['parameters'];
  $resa_id = $parameters[0];
  $arrived = $parameters[1];
  $out = $parameters[2];
  $notes = $parameters[3];
  $section = $parameters[4];

  if($section == 'kids'):
    update_post_meta($resa_id, 'kids_arrived', $arrived);
    update_post_meta($resa_id, 'kids_out', $out);
  else:
    update_post_meta($resa_id, 'people_arrived', $arrived);
    update_post_meta($resa_id, 'people_out', $out);
  endif;
  update_post_meta($resa_id, 'resa_notes', $notes);

  print_r(json_encode(array('success' => true, 'resa_id' => $resa_id, 'arrived' => $arrived, 'out' => $out)));
  die();
}
add_action('wp_ajax_add_extra_infos_to_resa', 'add_extra_infos_to_resa');
add_action('wp_ajax_nopriv_add_extra_infos_to_resa', 'add_extra_infos_to_resa');

function is_available_stage_date(){
  global $wpdb;

  $parameters = $_POST['parameters'];
  $start_date = strtotime(fullinparkResaManager::convertDateFormat($parameters[0]));
  $end_date = strtotime(fullinparkResaManager::convertDateFormat($parameters[1]));
  $stage_id = $parameters[2];
  $valid = true;
  $all_stages = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type='fip_stage' AND post_status = 'publish'");

  foreach ($all_stages as $stage):
    if($stage->ID != $stage_id):
      $tmp_start_date = strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($post->ID, 'start_date', true)));
      $tmp_end_date = strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($post->ID, 'end_date', true)));

      if($tmp_start_date <= $start_date AND $tmp_end_date >= $start_date):
        $valid = false;
      endif;

      if($tmp_start_date <= $end_date AND $tmp_end_date >= $end_date):
        $valid = false;
      endif;
    endif;
  endforeach;

  print_r(json_encode(array('success' => true, 'statement' => $valid)));
  die();
}
add_action('wp_ajax_is_available_stage_date', 'is_available_stage_date');
add_action('wp_ajax_nopriv_is_available_stage_date', 'is_available_stage_date');

function get_stage_planning(){
  $parameters = $_POST['parameters'];
  $stage_id = $parameters[0];
  $jump_resa = intval($parameters[1]);
  $day = (24*3600);

  $activities = get_post_meta($stage_id, 'activities', true);
  $activities_infos = array();

  $start_date = strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($stage_id, 'start_date', true)));
  $start_date_index =  date('w', strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($stage_id, 'start_date', true))));
  $end_date_index =  date('w', strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($stage_id, 'end_date', true))));

  if($end_date_index == 0):
    $end_date_index = 7;
  endif;

  for ($i=1; $i <= 7; $i++):
    if($i >= $start_date_index OR $i <= $end_date_index):
      $date = date('d/m/Y', $start_date + (($i - $start_date_index) * $day));

      $today_resa = fullinparkResaManager::get_resa_from_day(fullinparkResaManager::convertDateFormat($date));

      if((fullinparkResaStageManager::stage_jump_resa_number_by_slot($today_resa, strtotime('9:00')) + $jump_resa) <= get_option('max_stage_resa')):
        $activities_infos["day".$i."m"] = array(
          'activity' => $activities["day".$i."m"],
          'date' => $date,
          'hour' => '9:00'
        );
      else:
        $activities_infos["day".$i."m"] = array(
          'activity' => 'null',
          'date' => $date,
          'hour' => '9:00'
        );
      endif;

      if((fullinparkResaStageManager::stage_jump_resa_number_by_slot($today_resa, strtotime('14:00')) + $jump_resa) <= get_option('max_stage_resa')):
        $activities_infos["day".$i."a"] = array(
          'activity' => $activities["day".$i."a"],
          'date' => $date,
          'hour' => '14:00'
        );
      else:
        $activities_infos["day".$i."a"] = array(
          'activity' => 'null',
          'date' => $date,
          'hour' => '14:00'
        );
      endif;
    endif;
  endfor;

  print_r(json_encode(array('success' => true, 'activities' => $activities_infos)));
  die();
}
add_action('wp_ajax_get_stage_planning', 'get_stage_planning');
add_action('wp_ajax_nopriv_get_stage_planning', 'get_stage_planning');

//Load template from specific page
function fip_page_template($page_template){

    if(get_page_template_slug() == 'template-export-stats.php'):
        $page_template = PLUGIN_FIP_DIRECTORY. 'templates/template-export-stats.php';
    endif;
    return $page_template;
}
add_filter('page_template', 'fip_page_template');

/**
 * Add "Custom" template to page attirbute template section.
 */
function fip_add_template_to_select($post_templates, $wp_theme, $post, $post_type){
    // Add custom template named template-custom.php to select dropdown
    $post_templates['template-export-stats.php'] = __('Export');

    return $post_templates;
}
add_filter( 'theme_page_templates', 'fip_add_template_to_select', 10, 4 );

function fip_duplicate_resa_as_draft(){
  global $wpdb;
  if (! ( isset( $_GET['post']) || isset( $_POST['post']) || ( isset($_REQUEST['action']) && 'fip_duplicate_resa_as_draft' == $_REQUEST['action'] ) ) ):
    wp_die('No post to duplicate has been supplied!');
  endif;
  /*
  * Nonce verification
  */
  if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) ):
    return;
  endif;

  /*
  * get the original post id
  */
  $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
  /*
  * and all the original post data then
  */
  $post = get_post( $post_id );
  /*
  * if you don't want current user to be the new post author,
  * then change next couple of lines to this: $new_post_author = $post->post_author;
  */
  $current_user = wp_get_current_user();
  $new_post_author = $current_user->ID;
  /*
  * if post data exists, create the post duplicate
  */
  if(isset( $post ) && $post != null):
    /*
    * new post data array
    */
    $args = array(
      'comment_status' => $post->comment_status,
      'ping_status' => $post->ping_status,
      'post_author' => $new_post_author,
      'post_content' => $post->post_content,
      'post_excerpt' => $post->post_excerpt,
      'post_name' => $post->post_name,
      'post_parent' => $post->post_parent,
      'post_password' => $post->post_password,
      'post_status' => 'draft',
      'post_title' => $post->post_title,
      'post_type' => $post->post_type,
      'to_ping' => $post->to_ping,
      'menu_order' => $post->menu_order
    );
    /*
    * insert the post by wp_insert_post() function
    */
    $new_post_id = wp_insert_post( $args );

    update_post_meta($new_post_id, 'resa_activity', get_post_meta($post_id, 'resa_activity', true));
    update_post_meta($new_post_id, 'resa_jump', get_post_meta($post_id, 'resa_jump', true));
    update_post_meta($new_post_id, 'resa_kids', get_post_meta($post_id, 'resa_kids', true));
    update_post_meta($new_post_id, 'resa_date', get_post_meta($post_id, 'resa_date', true));
    update_post_meta($new_post_id, 'resa_duration', get_post_meta($post_id, 'resa_duration', true));
    update_post_meta($new_post_id, 'resa_hour', get_post_meta($post_id, 'resa_hour', true));

    //Extra infos Course
    update_post_meta($new_post_id, 'resa_private_course', get_post_meta($post_id, 'resa_private_course', true));
    update_post_meta($new_post_id, 'resa_collective_course', get_post_meta($post_id, 'resa_collective_course', true));
    update_post_meta($new_post_id, 'resa_collective_course_choice', get_post_meta($post_id, 'resa_collective_course_choice', true));

    //Extra infos Stage
    update_post_meta($new_post_id, 'resa_stage_choice', get_post_meta($post_id, 'resa_stage_choice', true));

    //Extra infos Anniverssaire
    update_post_meta($new_post_id, 'resa_anniversary_jump', get_post_meta($post_id, 'resa_anniversary_jump', true));
    update_post_meta($new_post_id, 'resa_anniversary_kids', get_post_meta($post_id, 'resa_anniversary_kids', true));
    update_post_meta($new_post_id, 'resa_anniversary_formula_sweet', get_post_meta($post_id, 'resa_anniversary_formula_sweet', true));
    update_post_meta($new_post_id, 'resa_anniversary_formula_salty', get_post_meta($post_id, 'resa_anniversary_formula_salty', true));
    update_post_meta($new_post_id, 'resa_anniversary_formula_sweetandsalty', get_post_meta($post_id, 'resa_anniversary_formula_sweetandsalty', true));
    update_post_meta($new_post_id, 'anniversary_jump_formula', get_post_meta($post_id, 'anniversary_jump_formula', true));
    update_post_meta($new_post_id, 'anniversary_place', get_post_meta($post_id, 'anniversary_place', true));

    //Statement
    update_post_meta($new_post_id, 'anniversary_statement', get_post_meta($post_id, 'anniversary_statement', true));
    update_post_meta($new_post_id, 'resa_statement_structure', get_post_meta($post_id, 'resa_statement_structure', true));

    //Contact
    update_post_meta($new_post_id, 'edit_contact_fullname', get_post_meta($post_id, 'edit_contact_fullname', true));
    update_post_meta($new_post_id, 'resa_contact_email', get_post_meta($post_id, 'resa_contact_email', true));
    update_post_meta($new_post_id, 'resa_contact_phone', get_post_meta($post_id, 'resa_contact_phone', true));

    //Notes
    update_post_meta($new_post_id, 'resa_notes', get_post_meta($post_id, 'resa_notes', true));
    update_post_meta($new_post_id, 'people_arrived', get_post_meta($post_id, 'people_arrived', true));
    update_post_meta($new_post_id, 'kids_arrived', get_post_meta($post_id, 'kids_arrived', true));
    update_post_meta($new_post_id, 'people_out', get_post_meta($post_id, 'people_out', true));
    update_post_meta($new_post_id, 'kids_out', get_post_meta($post_id, 'kids_out', true));

    wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
  else:
    wp_die('Post creation failed, could not find original post: ' . $post_id);
  endif;
}
add_action( 'admin_action_fip_duplicate_resa_as_draft', 'fip_duplicate_resa_as_draft' );

function remove_quick_edit($actions, $post){
  if($post->post_type == "fip_resa" ):
    $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=fip_duplicate_resa_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="'.__('Dupliquer cette réservation').'" rel="permalink">'.__('Duplicate').'</a>';
  endif;

  unset($actions['inline hide-if-no-js']);
  return $actions;
}
add_filter('post_row_actions','remove_quick_edit', 10, 2);

function add_cpt_question_pending_approval_count_filter() {
   add_filter('attribute_escape', 'display_count_cpt_question_pending_approval', 20, 2);
}
add_action('auth_redirect', 'add_cpt_question_pending_approval_count_filter');

function display_count_cpt_question_pending_approval( $safe_text = '', $text = '' ) {
  global $wpdb;

  $all_questions = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'fip_question'");

  if(substr_count($text, '%%NotRead%%')):
     // this is the menu name we want to modify
     $text = trim( str_replace(' %%NotRead%%', '', $text) );

     // once you have found the string you want to modify, no need to use the filter
     remove_filter('attribute_escape', 'display_count_cpt_question_pending_approval', 20, 2);

     $safe_text = esc_attr($text);

     $count = 0;

     foreach ($all_questions as $question):
       if(!get_post_meta($question->ID, 'read', true)):
         $count = $count +1;
       endif;
     endforeach;

     if($count > 0):
        // if there are posts pending approval
        $text = esc_attr($text) . ' <span class="awaiting-mod">' . $count . '</span>';
        return $text;
     endif;
  endif;
  return $safe_text;
}
