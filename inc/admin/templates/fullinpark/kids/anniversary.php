<div class="fullinpark_planning_jump_body_line">
  <?php
  $current_time = strtotime($start_time);

  while ($current_time < strtotime($end_time)):?>
    <div class="fullinpark_planning_body_col anniversary <?php echo (!fullinparkResaAnniversaryManager::anniversary_valid_c2_time($current_time, $current_day)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
      <a onclick="show_resa_anniv_popup('kids', 'anniversaire','<?php echo $current_time; ?>', 'c2');"><?php echo (fullinparkResaAnniversaryManager::anniversary_valid_c2_time($current_time, $current_day)) ? fullinparkResaAnniversaryManager::anniversary_c2_resa_kids_number_by_slot($today_resa, $current_time) : ''; ?></a>
    </div><?php
    echo get_popup($today_resa, 'kids', 'anniversaire', $current_time, 'c2');
    $current_time += $interval;
  endwhile; ?>
</div>
