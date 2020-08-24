<?php
$is_holiday = fullinparkCompanyManager::is_holidays(strtotime($current_day));

$private_course_time = '12:00';
$trampo_course_time1 = '14:00';
$trampo_course_time2 = '10:00';
$parkour_course_time1 = '15:00';
$parkour_course_time2 = '11:00';
$fittramp_course_time1 = '19:00';
$fittramp_course_time2 = '20:00'; ?>

<div class="fullinpark_planning_jump_body_line">
  <?php
  $current_time = strtotime($start_time);

  while ($current_time < strtotime($end_time)):
    if(!$is_holiday):
      //FITramp
      if($current_time == strtotime($fittramp_course_time1) AND $current_day_index == 4): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');">CCF</a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      elseif($current_time == (strtotime($fittramp_course_time1) + (30*60)) AND $current_day_index == 4): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');"><?php echo fullinparkResaManager::course_jump_resa_number_by_slot($today_resa, $current_time); ?></a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      elseif($current_time == strtotime($fittramp_course_time2) AND $current_day_index == 4): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');">CCF</a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      elseif($current_time == (strtotime($fittramp_course_time2) + (30*60)) AND $current_day_index == 4): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');"><?php echo fullinparkResaManager::course_jump_resa_number_by_slot($today_resa, $current_time); ?></a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      endif;

      //Trampoline
      if($current_time == strtotime($trampo_course_time1) AND $current_day_index == 3): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');">CCT</a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      elseif($current_time == (strtotime($trampo_course_time1) + (30*60)) AND $current_day_index == 3): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');"><?php echo fullinparkResaManager::course_jump_resa_number_by_slot($today_resa, $current_time); ?></a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      elseif($current_time == strtotime($trampo_course_time2) AND $current_day_index == 6): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');">CCT</a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      elseif($current_time == (strtotime($trampo_course_time2) + (30*60)) AND $current_day_index == 6): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');"><?php echo fullinparkResaManager::course_jump_resa_number_by_slot($today_resa, $current_time); ?></a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      endif;

      //Parkour
      if($current_time == strtotime($parkour_course_time1) AND $current_day_index == 3): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');">CCP</a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      elseif($current_time == (strtotime($parkour_course_time1) + (30*60)) AND $current_day_index == 3): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');"><?php echo fullinparkResaManager::course_jump_resa_number_by_slot($today_resa, $current_time); ?></a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      elseif($current_time == strtotime($parkour_course_time2) AND $current_day_index == 6): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');">CCP</a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      elseif($current_time == (strtotime($parkour_course_time2) + (30*60)) AND $current_day_index == 6): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');"><?php echo fullinparkResaManager::course_jump_resa_number_by_slot($today_resa, $current_time); ?></a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      endif;

      // Cours privés
      if($current_time == strtotime($private_course_time)): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');">CP</a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      elseif($current_time == (strtotime($private_course_time) + (30*60))): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');"><?php echo fullinparkResaManager::course_jump_resa_number_by_slot($today_resa, $current_time); ?></a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
        continue;
      endif;  ?>

      <div class="fullinpark_planning_body_col course disabled <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
        <a>0</a>
      </div><?php
      $current_time += $interval;
    else:
      if($current_time == strtotime($private_course_time)): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');">CP</a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
      elseif($current_time == (strtotime($private_course_time) + (30*60))): ?>
        <div class="fullinpark_planning_body_col course <?php echo ($current_time < strtotime($day_start_time) OR $current_time > strtotime($day_end_time)) ? 'disabled' : ''; ?> <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a onclick="show_resa_popup('jump', 'course','<?php echo $current_time; ?>');"><?php echo fullinparkResaManager::course_jump_resa_number_by_slot($today_resa, $current_time); ?></a>
        </div><?php
        echo get_popup($today_resa, 'jump', 'course', $current_time);
        $current_time += $interval;
      else: ?>
        <div class="fullinpark_planning_body_col course disabled <?php echo ((is_border_time($current_time)) ? 'border_time' : ''); ?>">
          <a>0</a>
        </div><?php
        $current_time += $interval;
      endif;
    endif;
  endwhile; ?>
</div>
