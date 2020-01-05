<?php
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
