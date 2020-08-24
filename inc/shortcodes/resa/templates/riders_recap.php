<div id="riders_reservation_container">
  <a id="hide_reservation_container" onclick="hide_riders_reservation();"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/delete-white.png'; ?>"/></a>

  <p class="title">Liste des Riders:</p>

  <div id="riders_reservation_content">
    <?php
    $all_riders = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'fip_riders' AND post_status = 'publish'");

    if(count($all_riders) != 0):
      foreach ($all_riders as $rider):  ?>
        <div class="rider_line">
          <p><?php echo $rider->post_title; ?></p>

          <div id="rider_<?php echo $rider->ID; ?>" class="rider_infos_content">
            <a class="resa_minus" onclick="remove_rider(<?php echo $rider->ID; ?>);">-</a>
            <p id="rider_number_<?php echo $rider->ID; ?>" data-name="<?php echo $rider->post_title; ?>" data-id="<?php echo $rider->ID; ?>" class="resa_number">0</p>
            <a class="resa_add" onclick="add_rider(<?php echo $rider->ID; ?>, <?php echo get_post_meta($rider->ID, 'qty', true); ?>);">+</a>
          </div>
        </div>
        <?php
      endforeach;
    else: ?>
      <p style="color: #FFF;">Aucun rider disponible</p><?php
    endif; ?>
  </div><!-- #riders_reservation_content -->

  <a id="add_riders" onclick="add_rider_to_resa();">Ajouter à ma réservation</a>
</div><!-- #riders_reservation_container -->
