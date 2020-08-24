<?php
require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/settings/update_settings.php');

$url = admin_url().'admin.php?page=fullinpark_settings';  ?>

<div>
  <div id="settings_nav">
    <ul>
      <li <?php echo (!isset($_GET['subpage']))? 'class="active"' : ''; ?>><a href="<?php echo $url; ?>">Réservation</a></li>
      <li <?php echo (isset($_GET['subpage']) AND $_GET['subpage'] == 'company')? 'class="active"' : ''; ?>><a href="<?php echo $url.'&subpage=company'; ?>">Établissement</a></li>
      <li <?php echo (isset($_GET['subpage']) AND $_GET['subpage'] == 'others')? 'class="active"' : ''; ?>><a href="<?php echo $url.'&subpage=others'; ?>">Autres</a></li>
    </ul>
  </div>

  <div id="settings_content">
    <?php
    if(isset($_GET['subpage']) AND $_GET['subpage'] == 'company'):
      require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/settings/company.php');
    elseif(isset($_GET['subpage']) AND $_GET['subpage'] == 'others'):
      require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/settings/others.php');
    else:
      require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/settings/resa.php');
    endif;  ?>
  </div>
</div>

<style>
#settings_nav{ margin: 0;  }
#settings_nav ul{  display: flex;  }
#settings_nav ul li{
  margin-right: 1em;
  padding: 0.5em 1em;
  font-size: 20px;
  text-transform: uppercase;
}

#settings_nav ul li.active{
  background: #CFA614;
  border-radius: 5px 0;
  font-weight: bold;
}

#settings_nav ul li a{
  text-decoration: none;
  color: #000;
}
#settings_nav ul li.active a{ color: #FFF;  }
#settings_content{  margin: 0;  }
</style>

<!--
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
    			<input type="checkbox" name="fullinpark_jump_kids_activation" id="fullinpark_jump_kids_activation" <?php echo (get_option('fullinpark_jump_kids_activation')) ? 'checked' : ''; ?> class="switch_1" onchange="show_jump_kids_section();"/>
    		</div>
      </div>
    </div>

    <div id="jump_kids_hours_validation" <?php echo (get_option('fullinpark_jump_kids_activation')) ? 'class="active"' : ''; ?>>
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
          <input type="checkbox" name="fullinpark_anniversary_activation" id="fullinpark_anniversary_activation" <?php echo (get_option('fullinpark_anniversary_activation')) ? 'checked' : ''; ?> class="switch_1" onchange="show_anniversary_section();"/>
        </div>
      </div>
    </div>

    <div id="anniversary_hours_validation" <?php echo (get_option('fullinpark_anniversary_activation')) ? 'class="active"' : ''; ?>>
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
          <input type="checkbox" name="fullinpark_stages_activation" id="fullinpark_stages_activation" <?php echo (get_option('fullinpark_stages_activation')) ? 'checked' : ''; ?> class="switch_1"/>
        </div>
      </div>
    </div>
  </div>

  <input type="hidden" name="update_fullinpark_settings" value="updated"/>
  <button type="submit" class="button button-primary">Enregister</button>
</form>
-->
