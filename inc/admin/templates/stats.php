<?php
global $wpdb;

require(PLUGIN_FIP_DIRECTORY.'inc/admin/functions/fullinpark.php');

$days = array(
  'dimanche',
  'lundi',
  'mardi',
  'mercredi',
  'jeudi',
  'vendredi',
  'samedi'
);

$admin_url = esc_url(home_url()).'/wp-admin/admin.php?page=fullinpark_stats';
$current_day = date('Y-m-d');
$current_day_index = date('w');
$alt_current_day = date('d/m/Y');
$current_position = 0;
$day = intval(24*3600);

if(isset($_GET['day'])):
  $current_day = date('Y-m-d', (strtotime($current_day) + (intval($_GET['day']) * $day)));
  $current_day_index = date('w', strtotime($current_day));
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

if(fullinparkCompanyManager::is_holidays(strtotime($current_day))):
  $day_infos = fullinparkCompanyManager::get_day_open_hours($days[$current_day_index], true);
else:
  $day_infos = fullinparkCompanyManager::get_day_open_hours($days[$current_day_index], false);
endif;

$day_start_time = $day_infos[0]->start_hour;
$day_end_time = $day_infos[0]->end_hour;
$start_time = '9:00';
$end_time = '22:00';
$interval = (60*30);
$current_time = strtotime($start_time);

$today_resa = fullinparkResaManager::get_resa_from_day(date('Y-m-d', strtotime($current_day))); ?>

<div id="fullinpark_admin_page">
  <div id="fullinpark_admin_page_title_container">
    <p id="fullinpark_admin_page_title">Planning des réservations</p>
  </div>

  <div id="fullinpark_planning_by_day">
    <div id="fullinpark_planning_nav">
      <a href="<?php echo $admin_url.'&day='.($current_position -1); ?>"><img id="fullinpark_planning_nav_back" src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-nav-black.png'; ?> "/></a>
      <p><?php echo $date_label.' <span>'.ucfirst($days[$current_day_index]).'</span> <a onclick="modify_current_date();">'.date('d/m/Y', strtotime($current_day)); ?></a></p>
      <a href="<?php echo $admin_url.'&day='.($current_position +1); ?>"><img id="fullinpark_planning_nav_next" src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-nav-black.png'; ?> "/></a>

      <div id="datepicker_planning_nav_container">
        <a id="datepicker_planning_nav_close_button" onclick="hide_datepicker_popup();"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/delete-blue.png'; ?>"/></a>

        <p id="datepicker_planning_nav_title">Sélectionnez une date</p>
        <div id="datepicker_planning_nav"></div>
      </div>
    </div>

    <?php
    if(!$day_infos[0]->close): ?>
      <p class="fullinpark_planning_title">Zone Jump</p>

      <p>Recapitulatif Jour:</p>

      <?php $stats_jump = fullinparkResaManager::total_stats_jump_resa_by_day($today_resa); ?>

      <div>
        <p>Total Entrées: <?php echo $stats_jump['entries']; ?></p>
        <p>Total Structure: <?php echo $stats_jump['entries']; ?></p>
        <p>Total Anniversaire: <?php echo $stats_jump['entries']; ?></p>
        <p>Total Stage: <?php echo $stats_jump['entries']; ?></p>
        <p>Total Cours: <?php echo $stats_jump['entries']; ?></p>
        <p>Total Cas particulier: <?php echo $stats_jump['other']; ?></p>
        <p>Total Jump: <?php echo $stats_jump['total']; ?></p>
      </div>

      <div id="fullinpark_planning_jump_global_container">
        <div id="fullinpark_planning_jump_entries_container">
          <div class="fullinpark_planning_jump_entries_elem"></div>
          <div class="fullinpark_planning_jump_entries_elem"></div>
          <div class="fullinpark_planning_jump_entries_elem jump">Entrées</div>
          <div class="fullinpark_planning_jump_entries_elem structure">Structure</div>
          <div class="fullinpark_planning_jump_entries_elem anniversary">Anniversaire C1</div>
          <div class="fullinpark_planning_jump_entries_elem anniversary">Anniversaire C2</div>
          <div class="fullinpark_planning_jump_entries_elem stage">Stage</div>
          <div class="fullinpark_planning_jump_entries_elem course">Cours</div>
          <div class="fullinpark_planning_jump_entries_elem other">Cas particulier</div>
          <div class="fullinpark_planning_jump_entries_elem total">Total</div>
          <div class="fullinpark_planning_jump_entries_elem subtotal">Réel</div>
          <div class="fullinpark_planning_jump_entries_elem subtotal">%</div>
        </div>

        <div id="fullinpark_planning_jump_container">
          <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/jump/warnings.php'); ?>
          <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/jump/head.php'); ?>

          <div id="fullinpark_planning_jump_body">
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/jump/jump.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/jump/structure.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/jump/anniversary.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/jump/stage.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/jump/course.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/jump/other.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/jump/total.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/jump/real.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/jump/diff.php'); ?>
          </div>
        </div>
      </div>

      <p class="fullinpark_planning_title">Zone Kids</p>

      <p>Recapitulatif Jour:</p>

      <div>
        <p>Total Entrées: </p>
        <p>Total Structure: </p>
        <p>Total Anniversaire: </p>
        <p>Total Cas particulier: </p>
        <p>Total Kids: </p>
      </div>

      <div id="fullinpark_planning_kids_global_container">
        <div id="fullinpark_planning_kids_entries_container">
          <div class="fullinpark_planning_kids_entries_elem"></div>
          <div class="fullinpark_planning_kids_entries_elem"></div>
          <div class="fullinpark_planning_kids_entries_elem kids">Entrées</div>
          <div class="fullinpark_planning_kids_entries_elem structure">Structure</div>
          <div class="fullinpark_planning_kids_entries_elem anniversary">Anniversaire</div>
          <div class="fullinpark_planning_kids_entries_elem other">Cas particulier</div>
          <div class="fullinpark_planning_kids_entries_elem total">Total</div>
          <div class="fullinpark_planning_kids_entries_elem subtotal">Réel</div>
          <div class="fullinpark_planning_kids_entries_elem subtotal">%</div>
        </div>

        <div id="fullinpark_planning_kids_container">
          <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/kids/warnings.php'); ?>
          <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/kids/head.php'); ?>

          <div id="fullinpark_planning_kids_body">
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/kids/kids.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/kids/structure.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/kids/anniversary.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/kids/other.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/kids/total.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/kids/real.php'); ?>
            <?php require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/fullinpark/kids/diff.php'); ?>
          </div>
        </div>
      </div>
    <?php
    else:
      echo '<p style="text-align: center; font-size: 32px; font-weight: bold;">Fermé</p>';
    endif;  ?>
  </div><!-- #fullinpark_planning_by_day -->
</div>
