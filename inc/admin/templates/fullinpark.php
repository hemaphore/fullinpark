<?php
global $wpdb;

$admin_url = esc_url(home_url()).'/wp-admin/admin.php?page=fullinpark_admin';
$current_day = date('Y-m-d');
$alt_current_day = date('d/m/Y');
$current_position = 0;
$day = (24 * 3600);

if(isset($_GET['day'])):
  $current_day = date('Y-m-d', (strtotime($current_day) + ($_GET['day'] * $day)));
  $alt_current_day = date('d/m/Y', (strtotime($alt_current_day) + ($_GET['day'] * $day)));
  $current_position = $_GET['day'];
endif;

$sql = "SELECT * FROM {$wpdb->prefix}posts";
$sql .= " INNER JOIN {$wpdb->prefix}postmeta m1 ON ({$wpdb->prefix}posts.ID = m1.post_id)";
$sql .= " WHERE {$wpdb->prefix}posts.post_type = 'fip_resa' AND {$wpdb->prefix}posts.post_status != 'trash'";
$sql .= " AND (m1.meta_key = 'resa_date' AND (m1.meta_value = '$current_day' OR m1.meta_value = '$alt_current_day'))";
$all_resa = $wpdb->get_results($sql); ?>

<div id="fullinpark_admin_page">
  <div id="fullinpark_admin_page_title_container">
    <p id="fullinpark_admin_page_title">Planning des réservations</p>

    <select name="planning_displayed">
      <option disabled selected>Mode affichage...</option>
      <option value="day">Jour</option>
      <option value="week">Semaine</option>
      <option value="month">Mois</option>
    </select>
  </div>


  <div id="fullinpark_planning_nav">
    <a href="<?php echo $admin_url.'&day='.($current_position -1); ?>"><img id="fullinpark_planning_nav_back" src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-nav-black.png'; ?> "/></a>
    <p>Aujourd'hui (<?php echo date('d/m/Y', strtotime($current_day)); ?>)</p>
    <a href="<?php echo $admin_url.'&day='.($current_position +1); ?>"><img id="fullinpark_planning_nav_next" src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-nav-black.png'; ?> "/></a>
  </div>

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
            echo '<div class="fullinpark_planning_body_elem">Jump ('.get_post_meta($resa->ID, 'resa_jump', true).')</div>';
          endif;
        endforeach;
        echo '</div>';

        $current_time += $interval;
      endwhile; ?>
    </div>
  </div>

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
            echo '<div class="fullinpark_planning_body_elem">Kids ('.get_post_meta($resa->ID, 'resa_kids', true).')</div>';
          endif;
        endforeach;
        echo '</div>';

        $current_time += $interval;
      endwhile; ?>
    </div>
  </div>
</div>
