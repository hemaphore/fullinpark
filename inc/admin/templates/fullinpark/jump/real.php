<?php
if(!function_exists('get_real_class')):
  function get_real_class($current_time, $current_day){
    $now = strtotime(date('Y-m-d'));
    $real_hour = strtotime(date('H:i'));
    $real_hour_limit = ($real_hour + (60*60));

    if(strtotime($current_day) < $now):
      return 'real_past';
    elseif(strtotime($current_day) > $now):
      return 'real_to_come';
    else:
      if($real_hour < $current_time AND $current_time <= $real_hour_limit):
        return 'real_previ';
      elseif($current_time >  ($real_hour - (30*60)) AND $current_time < $real_hour_limit):
        return 'real_active';
      elseif($current_time >= $real_hour_limit):
        return 'real_to_come';
      else:
        return 'real_past';
      endif;
    endif;
  }
endif;  ?>

<div class="fullinpark_planning_jump_body_line subtotal_line">
  <?php
  $current_time = strtotime($start_time);

  while ($current_time < strtotime($end_time)):?>
    <div class="fullinpark_planning_body_col subtotal <?php echo get_real_class($current_time, $current_day); ?> <?php echo (($current_time < strtotime($day_start_time) OR $current_time >= strtotime($day_end_time)) AND get_real_class($current_time, $current_day) != 'real_active' AND get_real_class($current_time, $current_day) != 'real_previ') ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>" style="font-weight: bold;">
      <?php echo fullinparkResaManager::total_real_jump_resa_by_slot($today_resa, $current_time); ?>
    </div><?php
    $current_time += $interval;
  endwhile; ?>
</div>
