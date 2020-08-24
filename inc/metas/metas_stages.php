<?php
function fip_stage_activities_html(){
  global $post;

  $start_date_index =  date('w', strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($post->ID, 'start_date', true))));
  $end_date_index =  date('w', strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($post->ID, 'end_date', true))));

  if($end_date_index == 0):
    $end_date_index = 7;
  endif;

  $activities = get_post_meta($post->ID, 'activities', true); ?>

  <div class="metas_stages_container">
    <div id="metas_stages_step1">
      <div id="metas_stages_dates">
        <div class="date_box">
          <label>Date de début</label>
          <input type="text" id="stage_start_date" name="stage_start_date" value="<?php echo get_post_meta($post->ID, 'start_date', true); ?>"/>
        </div>

        <div class="date_box">
          <label>Date de fin</label>
          <input type="text" id="stage_end_date" name="stage_end_date" value="<?php echo get_post_meta($post->ID, 'end_date', true); ?>"/>
        </div>
      </div>

      <a class="button button-primary button-large" onclick="submit_stage_form();">Valider</a>
    </div><!-- #metas_stages_step1 -->

    <div id="metas_stages_step2" <?php echo (empty(get_post_meta($post->ID, 'start_date', true)) OR empty(get_post_meta($post->ID, 'end_date', true))) ? 'style="display: none;"' : ''; ?>>
      <div id="metas_stages_planning">
        <div class="col">
          <div class="row no-border"></div>
          <div class="row"><span>9:00</span></div>
          <div class="row"><span>14:00</span></div>
        </div>

        <?php
        $day = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

        for ($i=1; $i <= 7; $i++): ?>
          <div class="col <?php echo ($i < $start_date_index OR $i > $end_date_index) ? 'disabled' : ''; ?>">
            <div class="row"><?php echo  $day[($i -1)]; ?></div>
            <div class="row">
              <select name="day<?php echo $i; ?>m">
                <option value="null">-</option>
                <option value="tramp" <?php echo ($activities['day'.$i.'m'] == "tramp") ? 'selected': ''; ?>>Cours de trampoline</option>
                <option value="free" <?php echo ($activities['day'.$i.'m'] == "free") ? 'selected': ''; ?>>Cours de free-run</option>
                <option value="rider" <?php echo ($activities['day'.$i.'m'] == "rider") ? 'selected': ''; ?>>Matériels rider</option>
              </select>
            </div>

            <div class="row">
              <select name="day<?php echo $i; ?>a">
                <option value="null">-</option>
                <option value="tramp" <?php echo ($activities['day'.$i.'a'] == "tramp") ? 'selected': ''; ?>>Cours de trampoline</option>
                <option value="free" <?php echo ($activities['day'.$i.'a'] == "free") ? 'selected': ''; ?>>Cours de free-run</option>
                <option value="rider" <?php echo ($activities['day'.$i.'a'] == "rider") ? 'selected': ''; ?>>Matériels rider</option>
              </select>
            </div>
          </div>
          <?php
        endfor; ?>
      </div>
    </div><!-- #metas_stages_step2 -->
    <input type="hidden" id="stage_id" name="stage_id" value="<?php echo $post->ID; ?>"/>
    <input type="hidden" id="stage_date_edit" name="stage_date_edit" value="edit"/>
  </div>
  <?php
}

function fip_stage_resa_html(){
  global $wpdb;
  global $post;

  $activities = get_post_meta($post->ID, 'activities', true);
  $start_date = strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($post->ID, 'start_date', true)));
  $end_date = strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($post->ID, 'end_date', true)));
  $day_time = (24 * 3600);  ?>

  <div class="metas_stages_container">
    <div id="stage_recap_resa_container">
      <div id="stage_recap_resa">
        <div class="col">
          <div class="row no-border"></div>
          <div class="row">9:00</div>
          <div class="row">14:00</div>
        </div>

        <?php
        $day = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

        for ($i=0; $i < 7; $i++):
          $current_date = date('Y-m-d', $start_date + ($i * $day_time)); ?>

          <div class="col">
            <div class="the_row"><?php echo  $day[$i]; ?></div>
            <div class="the_row <?php echo $activities['day'.($i+1).'m']; ?>"><?php echo fullinparkResaStageManager::get_stage_resa($current_date, '9:00'); ?></div>
            <div class="the_row <?php echo $activities['day'.($i+1).'a']; ?>"><?php echo fullinparkResaStageManager::get_stage_resa($current_date, '14:00'); ?></div>
          </div>
          <?php
        endfor; ?>
      </div>
    </div>
  </div><?php
}

if(!function_exists('save_fullinpark_stages_infos')):
  function save_fullinpark_stages_infos($post_id, $post, $update){
    global $wpdb;
    $post_type = get_post_type($post_id);

    if('fip_stage' == $post_type AND isset($_POST['stage_date_edit'])):
      $start_date_index =  date('w', strtotime(fullinparkResaManager::convertDateFormat($_POST['stage_start_date'])));
      $end_date_index =  date('w', strtotime(fullinparkResaManager::convertDateFormat($_POST['stage_end_date'])));

      if($end_date_index == 0):
        $end_date_index = 7;
      endif;

      update_post_meta($post_id, 'start_date', $_POST['stage_start_date']);
      update_post_meta($post_id, 'end_date', $_POST['stage_end_date']);

      $activities = array();

      for ($i=1; $i <= 7; $i++):
        if($i < $start_date_index OR $i > $end_date_index):
          $activities['day'.$i.'m'] = "null";
          $activities['day'.$i.'a'] = "null";
        else:
          $activities['day'.$i.'m'] = $_POST['day'.$i.'m'];
          $activities['day'.$i.'a'] = $_POST['day'.$i.'a'];
        endif;
      endfor;

      update_post_meta($post_id, 'activities', $activities);

      //Paiement
      $start_date = strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($post->ID, 'start_date', true)));
      $end_date = strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($post->ID, 'end_date', true)));
      $day_time = (24 * 3600);

      for ($i=0; $i < 7; $i++):
        $current_date = date('Y-m-d', $start_date + ($i * $day_time));

        fullinparkResaStageManager::set_stage_resa($current_date, '9:00');
        fullinparkResaStageManager::set_stage_resa($current_date, '14:00');
      endfor;
    endif;
  }
endif;
add_action('save_post', 'save_fullinpark_stages_infos', 10, 3);
