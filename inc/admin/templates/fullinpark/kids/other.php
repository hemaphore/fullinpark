<div class="fullinpark_planning_jump_body_line">
  <?php
  $current_time = strtotime($start_time);

  while ($current_time < strtotime($end_time)):?>
    <div class="fullinpark_planning_body_col other <?php echo ($current_time < strtotime($day_start_time) OR $current_time >= strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
      <a onclick="show_resa_popup('kids', 'other','<?php echo $current_time; ?>');"><?php echo fullinparkResaManager::other_kids_resa_number_by_slot($today_resa, $current_time); ?></a>
    </div><?php
    echo get_popup($today_resa, 'kids', 'other', $current_time);
    $current_time += $interval;
  endwhile; ?>
</div>
