<?php
function fip_resa_details_html(){
  global $post; ?>

  <div id="fip_resa_details">
    <p><span>Type:</span> <span><?php echo get_post_meta($post->ID, 'resa_activity', true); ?></span></p>
    <p><span>Jump:</span> <span><?php echo get_post_meta($post->ID, 'resa_jump', true); ?></span></p>
    <p><span>Kids:</span> <span><?php echo get_post_meta($post->ID, 'resa_kids', true); ?></span></p>
    <p><span>Date:</span> <span><?php echo date('d/m/Y', strtotime(get_post_meta($post->ID, 'resa_date', true))); ?></span></p>
    <p><span>Heure:</span> <span><?php echo get_post_meta($post->ID, 'resa_hour', true); ?></span></p>
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
    <p><span>Nom complet:</span> <span><?php echo get_post_meta($post->ID, 'resa_contact_fullname', true); ?></span></p>
    <p><span>Email:</span> <span><?php echo get_post_meta($post->ID, 'resa_contact_email', true); ?></span></p>
    <p><span>Téléphone:</span> <span><?php echo get_post_meta($post->ID, 'resa_contact_phone', true); ?></span></p>
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
