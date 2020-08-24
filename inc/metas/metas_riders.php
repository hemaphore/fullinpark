<?php
function fip_riders_infos_html(){
  global $post; ?>

  <div>
    <label>Quantité disponible:</label>
    <input type="text" name="rider_qty" id="rider_qty" value="<?php echo get_post_meta($post->ID, 'qty', true); ?>"/>
  </div>

  <div>
    <label>Prix / heure:</label>
    <input type="text" name="rider_price" id="rider_price" value="<?php echo get_post_meta($post->ID, 'price', true); ?>"/>
  </div>
  <?php
}

if(!function_exists('save_fip_riders_infos')):
  function save_fip_riders_infos($post_id, $post, $update){
    update_post_meta($post_id, 'qty', @$_POST['rider_qty']);
    update_post_meta($post_id, 'price', @$_POST['rider_price']);
  }
endif;
add_action('save_post', 'save_fip_riders_infos', 10, 3);
