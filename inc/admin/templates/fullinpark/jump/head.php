<div id="fullinpark_planning_jump_head">
  <?php
  $current_time = strtotime($start_time);

  while ($current_time < strtotime($end_time)):
    echo '<div class="fullinpark_planning_head_elem '.(($current_time < strtotime($day_start_time) OR $current_time >= strtotime($day_end_time)) ? 'disabled' : '').' '.((is_border_time($current_time)) ? 'border_time' : '').'">'.date('G:i', $current_time).'</div>';
    $current_time += $interval;
  endwhile; ?>
</div>
