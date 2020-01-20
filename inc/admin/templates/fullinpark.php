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

$start_time = date('G:i', strtotime(get_option('fullinpark_start_hour_of_day')));
$end_time = date('G:i', strtotime(get_option('fullinpark_end_hour_of_day')));
$interval = (60*30);
$current_time = strtotime($start_time);

$today_resa = fullinparkResaManager::get_resa_from_day(date('Y-m-d', strtotime($current_day)));
$jump_max_resa_by_slot = fullinparkResaManager::jump_max_resa_by_slot($today_resa, $start_time, $end_time);
$kids_max_resa_by_slot = fullinparkResaManager::kids_max_resa_by_slot($today_resa, $start_time, $end_time); ?>

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

  <p class="fullinpark_planning_title">Jump</p>

  <div id="fullinpark_planning_jump_container">
    <div id="fullinpark_planning_jump_head">
      <?php
      $current_time = strtotime($start_time);

      while ($current_time <= strtotime($end_time)):
        echo '<div class="fullinpark_planning_head_elem">'.date('G:i', $current_time).'</div>';
        $current_time += $interval;
      endwhile; ?>
    </div>

    <div id="fullinpark_planning_jump_body">
      <?php
      $current_time = strtotime($start_time);
      $total_jump = 0;

      while ($current_time <= strtotime($end_time)):
        $slot = 0;

        echo '<div class="fullinpark_planning_body_col">';
        foreach ($today_resa as $resa):
          if($current_time == strtotime(date('G:i', strtotime(get_post_meta($resa->ID, 'resa_hour', true)))) AND get_post_meta($resa->ID, 'resa_jump', true) != 0):
            $total_jump = $total_jump + intval(get_post_meta($resa->ID, 'resa_jump', true));

            if($slot+1 == $kids_max_resa_by_slot): ?>
              <div class="fullinpark_planning_body_elem no_border" onclick="show_resa_popup('<?php echo $resa->ID; ?>')">
                <?php echo get_post_meta($resa->ID, 'resa_jump', true); ?>
              </div>  <?php
            else: ?>
            <div class="fullinpark_planning_body_elem" onclick="show_resa_popup('<?php echo $resa->ID; ?>')">
              <?php echo get_post_meta($resa->ID, 'resa_jump', true); ?>
            </div><?php
            endif;  ?>

            <div id="fullinpark_planning_elem_popup_<?php echo $resa->ID; ?>" class="fullinpark_planning_elem_popup">
              <a class="hide_resa_popup_button" onclick="hide_resa_popup('<?php echo $resa->ID; ?>')">x</a>

              <p class="fullinpark_planning_elem_popup_title">Fiche de la Réservation</p>

              <div class="fullinpark_planning_elem_popup_qty">
                <div>
                  <span>Jump:</span> <span class="fullinpark_planning_elem_popup_qty_value"><?php echo get_post_meta($resa->ID, 'resa_jump', true); ?></span>
                </div>

                <div>
                  <span>Kids:</span> <span class="fullinpark_planning_elem_popup_qty_value"><?php echo get_post_meta($resa->ID, 'resa_kids', true); ?></span>
                </div>
              </div>

              <div class="fullinpark_planning_elem_popup_contact">
                <p><span>Nom complet:</span> <span class="fullinpark_planning_elem_popup_contact_value"><?php echo get_post_meta($resa->ID, 'resa_contact_fullname', true); ?></span></p>
                <p><span>Email:</span> <span class="fullinpark_planning_elem_popup_contact_value"><?php echo get_post_meta($resa->ID, 'resa_contact_email', true); ?></span></p>
                <p><span>Téléphone:</span> <span class="fullinpark_planning_elem_popup_contact_value"><?php echo get_post_meta($resa->ID, 'resa_contact_phone', true); ?></span></p>
              </div>

              <a class="fullinpark_planning_elem_popup_modify_button" href="<?php echo esc_url(home_url()).'/wp-admin/post.php?post='.$resa->ID.'&action=edit'; ?>">modifier</a>
            </div><?php
            $slot = $slot+1;
          endif;
        endforeach;

        for ($i = $slot; $i < $jump_max_resa_by_slot; $i++):
          if($slot > 0):
            echo '<div class="fullinpark_planning_body_elem empty"></div>';
          endif;
        endfor;

        echo '</div>';

        $current_time += $interval;
      endwhile; ?>
    </div>
  </div>

  <p>Total Jump: <?php echo $total_jump; ?></p>

  <p class="fullinpark_planning_title">Kids</p>

  <div id="fullinpark_planning_kids_container">
    <div id="fullinpark_planning_kids_head">
      <?php
      $current_time = strtotime($start_time);

      while ($current_time <= strtotime($end_time)):
        echo '<div class="fullinpark_planning_head_elem">'.date('G:i', $current_time).'</div>';
        $current_time += $interval;
      endwhile; ?>
    </div>

    <div id="fullinpark_planning_kids_body">
      <?php
      $current_time = strtotime($start_time);
      $total_kids = 0;

      while ($current_time <= strtotime($end_time)):
        $slot = 0;

        echo '<div class="fullinpark_planning_body_col">';
        foreach ($today_resa as $resa):
          if($current_time == strtotime(date('G:i', strtotime(get_post_meta($resa->ID, 'resa_hour', true)))) AND get_post_meta($resa->ID, 'resa_kids', true) != 0):
            $total_kids = $total_kids + intval(get_post_meta($resa->ID, 'resa_kids', true));

            if($slot+1 == $kids_max_resa_by_slot): ?>
              <div class="fullinpark_planning_body_elem no_border" onclick="show_resa_popup('<?php echo $resa->ID; ?>')">
                <?php echo get_post_meta($resa->ID, 'resa_kids', true); ?>
              </div>  <?php
            else: ?>
            <div class="fullinpark_planning_body_elem" onclick="show_resa_popup('<?php echo $resa->ID; ?>')">
              <?php echo get_post_meta($resa->ID, 'resa_kids', true); ?>
            </div><?php
            endif;  ?>

            <div id="fullinpark_planning_elem_popup_<?php echo $resa->ID; ?>" class="fullinpark_planning_elem_popup">
              <?php echo $resa->ID; ?>

              <a href="<?php echo esc_url(home_url()).'/wp-admin/post.php?post='.$resa->ID.'&action=edit'; ?>">modifier</a>
            </div><?php
            $slot = $slot+1;
          endif;
        endforeach;

        for ($i = $slot; $i < $kids_max_resa_by_slot; $i++):
          if($slot > 0):
            echo '<div class="fullinpark_planning_body_elem empty"></div>';
          endif;
        endfor;

        echo '</div>';

        $current_time += $interval;
      endwhile; ?>
    </div>
  </div>

  <p>Total Kids: <?php echo $total_kids; ?></p>
</div>
