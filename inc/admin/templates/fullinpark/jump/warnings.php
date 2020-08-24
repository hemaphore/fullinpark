<div id="fullinpark_planning_jump_warning">
  <?php
  $current_time = strtotime($start_time);

  while ($current_time < strtotime($end_time)): ?>
    <div class="fullinpark_planning_warning_elem"><?php echo (fullinparkResaWarningManager::is_warning($today_resa, $current_time)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning.png"/>' : ''; ?> <?php echo (fullinparkResaWarningManager::is_not_arrived($today_resa, $current_time)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning_not_arrived.png"/>' : ''; ?></div> <?php
    $current_time += $interval;
  endwhile; ?>
</div>
