<?php
global $wpdb;

//require(PLUGIN_FIP_DIRECTORY.'script_add_resa.php');

$admin_url = esc_url(home_url()).'/wp-admin/admin.php?page=fullinpark_admin';
$current_day = date('Y-m-d');
$alt_current_day = date('d/m/Y');
$current_position = 0;
$day = intval(24*3600);

if(isset($_GET['day'])):
  $current_day = date('Y-m-d', (strtotime($current_day) + (intval($_GET['day']) * $day)));
  $alt_current_day = date('d/m/Y', (strtotime($current_day)));
  $current_position = $_GET['day'];
endif;

$date_label = '';

if(!isset($_GET['day']) OR $_GET['day'] == 0):
  $date_label = 'Aujourd\'hui -';
elseif($_GET['day'] == 1):
  $date_label = 'Demain -';
elseif($_GET['day'] == -1):
  $date_label = 'Hier -';
endif;

$sql = "SELECT * FROM {$wpdb->prefix}posts";
$sql .= " INNER JOIN {$wpdb->prefix}postmeta m1 ON ({$wpdb->prefix}posts.ID = m1.post_id)";
$sql .= " WHERE {$wpdb->prefix}posts.post_type = 'fip_resa' AND {$wpdb->prefix}posts.post_status != 'trash'";
$sql .= " AND (m1.meta_key = 'resa_date' AND (m1.meta_value = '$current_day' OR m1.meta_value = '$alt_current_day'))";
$all_resa = $wpdb->get_results($sql); ?>

<div id="fullinpark_admin_page">
  <div id="fullinpark_admin_page_title_container">
    <p id="fullinpark_admin_page_title">Planning des réservations</p>

    <select name="planning_displayed" onchange="change_display_mode(this);">
      <option disabled selected>Mode affichage...</option>
      <option value="day">Jour</option>
      <option value="week">Semaine</option>
      <option value="month">Mois</option>
    </select>
  </div>

  <div id="fullinpark_planning_nav">
    <a href="<?php echo $admin_url.'&day='.($current_position -1); ?>"><img id="fullinpark_planning_nav_back" src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-nav-black.png'; ?> "/></a>
    <p><?php echo $date_label.' '.date('d/m/Y', strtotime($current_day)); ?></p>
    <a href="<?php echo $admin_url.'&day='.($current_position +1); ?>"><img id="fullinpark_planning_nav_next" src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-nav-black.png'; ?> "/></a>
  </div>

  <p>Jump</p>

  <div id="fullinpark_planning_jump_container">
    <div id="fullinpark_planning_jump_head">
      <?php
      $start_time = date('G:i', strtotime(get_option('fullinpark_start_hour_of_day')));
      $end_time = date('G:i', strtotime(get_option('fullinpark_end_hour_of_day')));
      $interval = (60*30);
      $current_time = strtotime($start_time);

      while ($current_time <= strtotime($end_time)):
        echo '<div class="fullinpark_planning_head_elem">'.date('G:i', $current_time).'</div>';
        $current_time += $interval;
      endwhile; ?>
    </div>

    <div id="fullinpark_planning_jump_body">
      <?php
      $start_time = date('G:i', strtotime(get_option('fullinpark_start_hour_of_day')));
      $end_time = date('G:i', strtotime(get_option('fullinpark_end_hour_of_day')));
      $interval = (60*30);
      $current_time = strtotime($start_time);

      while ($current_time <= strtotime($end_time)):
        echo '<div class="fullinpark_planning_body_col">';
        foreach ($all_resa as $resa):
          if($current_time == strtotime(date('G:i', strtotime(get_post_meta($resa->ID, 'resa_hour', true)))) AND get_post_meta($resa->ID, 'resa_jump', true) != 0):
            echo '<div class="fullinpark_planning_body_elem" onclick="show_resa_infos('.$resa->ID.');">'.get_post_meta($resa->ID, 'resa_jump', true).'</div>';
          endif;
        endforeach;
        echo '</div>';

        $current_time += $interval;
      endwhile; ?>
    </div>
  </div>

  <p>Kids</p>

  <div id="fullinpark_planning_kids_container">
    <div id="fullinpark_planning_kids_head">
      <?php
      $start_time = date('G:i', strtotime(get_option('fullinpark_start_hour_of_day')));
      $end_time = date('G:i', strtotime(get_option('fullinpark_end_hour_of_day')));
      $interval = (60*30);
      $current_time = strtotime($start_time);

      while ($current_time <= strtotime($end_time)):
        echo '<div class="fullinpark_planning_head_elem">'.date('G:i', $current_time).'</div>';
        $current_time += $interval;
      endwhile; ?>
    </div>

    <div id="fullinpark_planning_kids_body">
      <?php
      $start_time = date('G:i', strtotime(get_option('fullinpark_start_hour_of_day')));
      $end_time = date('G:i', strtotime(get_option('fullinpark_end_hour_of_day')));
      $interval = (60*30);
      $current_time = strtotime($start_time);

      while ($current_time <= strtotime($end_time)):
        echo '<div class="fullinpark_planning_body_col">';
        foreach ($all_resa as $resa):
          if($current_time == strtotime(date('G:i', strtotime(get_post_meta($resa->ID, 'resa_hour', true)))) AND get_post_meta($resa->ID, 'resa_kids', true) != 0):
            echo '<div class="fullinpark_planning_body_elem">'.get_post_meta($resa->ID, 'resa_kids', true).'</div>';
          endif;
        endforeach;
        echo '</div>';

        $current_time += $interval;
      endwhile; ?>
    </div>
  </div>
</div>

<div id="resa_infos_popup">
  <a onclick="hide_popup('#resa_infos_popup');"><div class="popup_x"></div></a>

  <div class="popup_content">
    <p id="popup_main_title">Informations de la réservation</p>

    <div id="resa_infos_container">
      <div class="resa_infos_col">
        <p class="resa_infos_title">Places</p>

        <div>
          <p><span class="resa_infos_label">Jump:</span> <span id="resa_infos_value_jump" class="resa_infos_value"></span></p>
          <p><span class="resa_infos_label">Kids:</span> <span id="resa_infos_value_kids" class="resa_infos_value"></span></p>
        </div>
      </div>


      <div class="resa_infos_col">
        <p class="resa_infos_title">Crénau</p>

        <div>
          <p><span class="resa_infos_label">Date:</span> <span id="resa_infos_value_date" class="resa_infos_value"></span></p>
          <p><span class="resa_infos_label">heure:</span> <span id="resa_infos_value_hour" class="resa_infos_value"></span></p>
        </div>
      </div>
    </div>

    <div id="resa_infos_contact">
      <p class="resa_infos_title">Contact client</p>

      <div>
        <p><span class="resa_infos_label">Nom:</span> <span id="resa_infos_value_fullname" class="resa_infos_value"></span></p>
        <p><span class="resa_infos_label">Email:</span> <span id="resa_infos_value_email" class="resa_infos_value"></span></p>
        <p><span class="resa_infos_label">Téléphone:</span> <span id="resa_infos_value_phone" class="resa_infos_value"></span></p>
      </div>
    </div>
  </div>
</div>
