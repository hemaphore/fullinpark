<div id="stage_selector_container">
  <p class="secondary_title">Stages</p>

  <?php
  $all_stages = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'fip_stage' AND post_status = 'publish'"); ?>

  <div class="grey_container">
    <div class="custom_select">
      <a id="toogle_stages_button" onclick="toogle_stages();">
        <p class="custom_select_default">Choisis <span class="blue bold">ton stage</span></p>
        <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-blue.png'; ?> "/>
      </a>

      <div id="custom_select_stages">
        <ul>
          <?php
          $now =strtotime(date('Y-m-d'));

          foreach ($all_stages as $stage):
            $end_date = strtotime(fullinparkResaManager::convertDateFormat(get_post_meta($stage->ID, 'end_date', true)));

            if($end_date >= $now):
              ?><li onclick="stage_selected('<?php echo $stage->ID; ?>', 'Semaine du <?php echo get_post_meta($stage->ID, 'start_date', true); ?> au <?php echo get_post_meta($stage->ID, 'end_date', true); ?>')">Semaine du <?php echo get_post_meta($stage->ID, 'start_date', true); ?> au <?php echo get_post_meta($stage->ID, 'end_date', true); ?></li><?php
            endif;
          endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div> <!-- #stage_selector_container -->
