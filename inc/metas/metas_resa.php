<?php
function fip_resa_details_html(){
  global $post; ?>

  <div id="fip_resa_details">
    <p><span>Type:</span> <span><input type="text" name="edit_resa_activity" value="<?php echo get_post_meta($post->ID, 'resa_activity', true); ?>"/></span></p>
    <p><span>Jump:</span> <span><input type="text" name="edit_resa_jump" value="<?php echo get_post_meta($post->ID, 'resa_jump', true); ?>"/></span></p>
    <p><span>Kids:</span> <span><input type="text" name="edit_resa_kids" value="<?php echo get_post_meta($post->ID, 'resa_kids', true); ?>"/></span></p>
    <p><span>Date:</span> <span><input type="text" name="edit_resa_date" id="edit_resa_date" value="<?php echo date('d/m/Y', strtotime(get_post_meta($post->ID, 'resa_date', true))); ?>"/></span></p>
    <p><span>Heure:</span> <span><input type="text" name="edit_resa_hour" value="<?php echo get_post_meta($post->ID, 'resa_hour', true); ?>"/></span></p>
  </div>

  <style>
    #fip_resa_details p{
      width: 500px;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
    }

    #fip_resa_details p span{
      width: 250px;
      text-align: left;
    }
    #fip_resa_details p span:first-child{  font-weight: bold; }
  </style>
  <?php
}

function fip_resa_contact_html(){
  global $post; ?>

  <div id="fip_resa_contact_infos">
    <p><span>Nom complet:</span> <span><input type="text" name="edit_contact_fullname" value="<?php echo get_post_meta($post->ID, 'resa_contact_fullname', true); ?>"/></span></p>
    <p><span>Email:</span> <span><input type="text" name="edit_contact_email" value="<?php echo get_post_meta($post->ID, 'resa_contact_email', true); ?>"/></span></p>
    <p><span>Téléphone:</span> <span><input type="text" name="edit_contact_phone" value="<?php echo get_post_meta($post->ID, 'resa_contact_phone', true); ?>"/></span></p>
  </div>

  <style>
    #fip_resa_contact_infos p{
      width: 500px;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
    }

    #fip_resa_contact_infos p span{
      width: 250px;
      text-align: left;
    }
    #fip_resa_contact_infos p span:first-child{  font-weight: bold; }
  </style>
  <?php
}

if(!function_exists('save_fip_resa_infos')):
  function save_fip_resa_infos($post_id, $post, $update){
    update_post_meta($post_id, 'resa_activity', @$_POST['edit_resa_activity']);
    update_post_meta($post_id, 'resa_jump', @$_POST['edit_resa_jump']);
    update_post_meta($post_id, 'resa_kids', @$_POST['edit_resa_kids']);
    update_post_meta($post_id, 'resa_date', date('Y-m-d', strtotime(@$_POST['edit_resa_date'])));
    update_post_meta($post_id, 'resa_hour', date('G:i', strtotime(@$_POST['edit_resa_hour'])));
    update_post_meta($post_id, 'resa_contact_fullname', @$_POST['edit_contact_fullname']);
    update_post_meta($post_id, 'resa_contact_email', @$_POST['edit_contact_email']);
    update_post_meta($post_id, 'resa_contact_phone', @$_POST['edit_contact_phone']);
  }
endif;
add_action('save_post', 'save_fip_resa_infos', 10, 3);

function add_fullinpark_resa_acf_columns ( $columns ) {
  unset($columns['date']);

  return array_merge ($columns, array(
   'resa_type' => __ ( 'Activité' ),
   'resa_date' => __ ( 'Date - Heure' ),
   'resa_jump' => __ ( 'Jump' ),
   'resa_kids' => __ ( 'Kids' )
 ));
}
add_filter ( 'manage_edit-fip_resa_columns', 'add_fullinpark_resa_acf_columns' );

function fullinpark_resa_custom_column ($column, $post_id){
   switch($column):
     case 'resa_type':
       echo get_post_meta($post_id, 'resa_activity', true);
       break;
     case 'resa_date':
       echo date('d/m/Y', strtotime(get_post_meta($post_id, 'resa_date', true))).' - '.get_post_meta($post_id, 'resa_hour', true);
       break;
     case 'resa_jump':
       echo get_post_meta($post_id, 'resa_jump', true);
       break;
     case 'resa_kids':
       echo get_post_meta($post_id, 'resa_kids', true);
       break;
     default:
       break;
   endswitch;
}
add_action ('manage_fip_resa_posts_custom_column', 'fullinpark_resa_custom_column', 10, 2);
