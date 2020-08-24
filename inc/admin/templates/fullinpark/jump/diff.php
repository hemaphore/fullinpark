<div class="fullinpark_planning_jump_body_line total_line">
  <?php
  $current_time = strtotime($start_time);

  while ($current_time < strtotime($end_time)):?>
    <div class="fullinpark_planning_body_col total <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>" style="font-weight: bold;">
      <?php
      if(fullinparkResaManager::total_jump_resa_by_slot($today_resa, $current_time) != 0):
        echo ((fullinparkResaManager::total_real_jump_resa_by_slot($today_resa, $current_time) / fullinparkResaManager::total_jump_resa_by_slot($today_resa, $current_time)) *100);
      else:
        echo '-';
      endif;  ?>
    </div><?php
    $current_time += $interval;
  endwhile; ?>
</div>
