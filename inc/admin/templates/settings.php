<?php
if(isset($_POST['update_fullinpark_settings']) AND $_POST['update_fullinpark_settings'] == "updated"):
  update_option('fullinpark_admin_email', $_POST['fullinpark_admin_email']);
  update_option('fullinpark_start_day_of_week', $_POST['fullinpark_start_day_of_week']);
  update_option('fullinpark_end_day_of_week', $_POST['fullinpark_end_day_of_week']);
  update_option('fullinpark_start_hour_of_day', $_POST['fullinpark_start_hour_of_day']);
  update_option('fullinpark_end_hour_of_day', $_POST['fullinpark_end_hour_of_day']);
endif;  ?>

<form action="#" method="POST">
  <p class="fip_admin_title">Email</p>

  <div class="fullinpark_form_row">
    <label>Email administrateur: </label>
    <input type="text" name="fullinpark_admin_email" id="fullinpark_admin_email" value="<?php echo get_option('fullinpark_admin_email'); ?>"/>
  </div>

  <p class="fip_admin_title">Réservation</p>

  <div class="fullinpark_resa_opening">
    <label for="fullinpark_start_day_of_week">Ouvert du </label>
    <select name="fullinpark_start_day_of_week" id="fullinpark_start_day_of_week">
      <option value="lun" <?php echo (get_option('fullinpark_start_day_of_week') == "lun") ? 'selected' : ''; ?>>Lundi</option>
      <option value="mar" <?php echo (get_option('fullinpark_start_day_of_week') == "mar") ? 'selected' : ''; ?>>Mardi</option>
      <option value="mer" <?php echo (get_option('fullinpark_start_day_of_week') == "mer") ? 'selected' : ''; ?>>Mercredi</option>
      <option value="jeu" <?php echo (get_option('fullinpark_start_day_of_week') == "jeu") ? 'selected' : ''; ?>>Jeudi</option>
      <option value="ven" <?php echo (get_option('fullinpark_start_day_of_week') == "ven") ? 'selected' : ''; ?>>Vendredi</option>
      <option value="sam" <?php echo (get_option('fullinpark_start_day_of_week') == "sam") ? 'selected' : ''; ?>>Samedi</option>
      <option value="dim" <?php echo (get_option('fullinpark_start_day_of_week') == "dim") ? 'selected' : ''; ?>>Dimanche</option>
    </select>

    <label for="fullinpark_end_day_of_week">au </label>
    <select name="fullinpark_end_day_of_week" id="fullinpark_end_day_of_week">
      <option value="lun" <?php echo (get_option('fullinpark_end_day_of_week') == "lun") ? 'selected' : ''; ?>>Lundi</option>
      <option value="mar" <?php echo (get_option('fullinpark_end_day_of_week') == "mar") ? 'selected' : ''; ?>>Mardi</option>
      <option value="mer" <?php echo (get_option('fullinpark_end_day_of_week') == "mer") ? 'selected' : ''; ?>>Mercredi</option>
      <option value="jeu" <?php echo (get_option('fullinpark_end_day_of_week') == "jeu") ? 'selected' : ''; ?>>Jeudi</option>
      <option value="ven" <?php echo (get_option('fullinpark_end_day_of_week') == "ven") ? 'selected' : ''; ?>>Vendredi</option>
      <option value="sam" <?php echo (get_option('fullinpark_end_day_of_week') == "sam") ? 'selected' : ''; ?>>Samedi</option>
      <option value="dim" <?php echo (get_option('fullinpark_end_day_of_week') == "dim") ? 'selected' : ''; ?>>Dimanche</option>
    </select>
  </div>

  <div class="fullinpark_resa_opening">
    <label for="fullinpark_start_hour_of_day">Ouvert de </label>
    <select name="fullinpark_start_hour_of_day" id="fullinpark_start_hour_of_day">
      <?php
      $start_time = date('G:i', strtotime('7:00'));
      $end_time = date('G:i', strtotime('20:00'));
      $interval = (60*30);
      $current_time = strtotime($start_time);

      while ($current_time <= strtotime($end_time)):
        echo '<option value="'.date('G:i', $current_time) .'"'. ((get_option('fullinpark_start_hour_of_day') == date('G:i', $current_time)) ? 'selected' : '') .'>'.date('G:i', $current_time).'</option>';
        $current_time += $interval;
      endwhile; ?>
    </select>

    <label for="fullinpark_end_hour_of_day">à </label>
    <select name="fullinpark_end_hour_of_day" id="fullinpark_end_hour_of_day">
      <?php
      $start_time = date('G:i', strtotime('7:00'));
      $end_time = date('G:i', strtotime('20:00'));
      $interval = (60*30);
      $current_time = strtotime($start_time);

      while ($current_time <= strtotime($end_time)):
        echo '<option value="'.date('G:i', $current_time) .'"'. ((get_option('fullinpark_end_hour_of_day') == date('G:i', $current_time)) ? 'selected' : '') .'>'.date('G:i', $current_time).'</option>';
        $current_time += $interval;
      endwhile; ?>
    </select>
  </div>

  <p class="fip_admin_title">Fonctionnalités</p>

  <div>
    <div class="main_label_container">
      <label class="main_label">Jump & Kids</label>
      <div class="wrapper">
    		<div class="switch_box box_1">
    			<input type="checkbox" class="switch_1" onchange="show_jump_kids_section();"/>
    		</div>
      </div>
    </div>

    <div id="jump_kids_hours_validation">
      <?php
      $start_time = date('G:i', strtotime('7:00'));
      $end_time = date('G:i', strtotime('20:00'));
      $interval = (60*30);
      $current_time = strtotime($start_time);

      while ($current_time <= strtotime($end_time)):  ?>
        <div class="hours_validation_box">
          <label><?php echo date('G:i', $current_time); ?></label>
          <div class="wrapper">
        		<div class="switch_box box_1">
        			<input type="checkbox" class="switch_1"/>
        		</div>
          </div>
        </div>  <?php
        $current_time += $interval;
      endwhile; ?>
    </div>

    <div class="main_label_container">
      <label class="main_label">Anniversaire</label>
      <div class="wrapper">
        <div class="switch_box box_1">
          <input type="checkbox" class="switch_1" onchange="show_anniversary_section();"/>
        </div>
      </div>
    </div>

    <div id="anniversary_hours_validation">
      <?php
      $start_time = date('G:i', strtotime('7:00'));
      $end_time = date('G:i', strtotime('20:00'));
      $interval = (60*30);
      $current_time = strtotime($start_time);

      while ($current_time <= strtotime($end_time)):  ?>
        <div class="hours_validation_box">
          <label><?php echo date('G:i', $current_time); ?></label>
          <div class="wrapper">
        		<div class="switch_box box_1">
        			<input type="checkbox" class="switch_1"/>
        		</div>
          </div>
        </div>  <?php
        $current_time += $interval;
      endwhile; ?>
    </div>

    <div class="main_label_container">
      <label class="main_label">Stages</label>
      <div class="wrapper">
        <div class="switch_box box_1">
          <input type="checkbox" class="switch_1"/>
        </div>
      </div>
    </div>
  </div>

  <input type="hidden" name="update_fullinpark_settings" value="updated"/>
  <button type="submit" class="button button-primary">Enregister</button>
</form>
