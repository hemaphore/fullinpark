<?php
$is_holiday = fullinparkCompanyManager::is_holidays(strtotime($current_day));

$stage_morning_start = '9:00';
$stage_morning_end = '12:00';
$stage_afternoon_start = '14:00';
$stage_afternoon_end = '17:00'; ?>

<div class="fullinpark_planning_jump_body_line">
  <?php
  $current_time = strtotime($start_time);

  while ($current_time < strtotime($end_time)):
    if($is_holiday): ?>
      <div class="fullinpark_planning_body_col stage <?php echo ($current_time < strtotime($stage_morning_start) OR ($current_time >= strtotime($stage_morning_end) AND  $current_time < strtotime($stage_afternoon_start)) OR $current_time >= strtotime($stage_afternoon_end)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
        <a onclick="show_resa_popup('jump', 'stage','<?php echo $current_time; ?>');"><?php echo fullinparkResaManager::stage_jump_resa_number_by_slot($today_resa, $current_time); ?></a>
      </div><?php
      echo get_popup($today_resa, 'jump', 'stage', $current_time);
      $current_time += $interval;
    else: ?>
      <div class="fullinpark_planning_body_col disabled <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
        <a onclick="show_resa_popup('jump', 'stage','<?php echo $current_time; ?>');"></a>
      </div><?php
      $current_time += $interval;
    endif;
  endwhile; ?>
</div>
