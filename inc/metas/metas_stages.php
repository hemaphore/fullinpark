<?php
function fip_stage_date_html(){
  global $post; ?>

  <div id="stage_open_date_container">
    <div>
      <label>Date de début:</label></br>
      <input type="text" name="start_date" id="start_date" value="<?php echo get_post_meta($post->ID, 'start_date', true); ?>"/>
    </div>

    <div>
      <label>Date de fin:</label></br>
      <input type="text" name="end_date" id="end_date" value="<?php echo get_post_meta($post->ID, 'end_date', true); ?>"/>
    </div>

    <input type="hidden" name="stage_date_edit" value="edit"/>
  </div>
  <?php
}

if(!function_exists('save_fullinpark_stages_infos')):
  function save_fullinpark_stages_infos($post_id, $post, $update){
    $post_type = get_post_type($post_id);

    if('fip_stage' == $post_type AND $_POST['stage_date_edit'] == "edit"):
      update_post_meta($post_id, 'start_date', @$_POST['start_date']);
      update_post_meta($post_id, 'end_date', @$_POST['end_date']);
    endif;
  }
endif;
add_action('save_post', 'save_fullinpark_stages_infos', 10, 3);
