<?php
function fip_question_coordonates_html(){
  global $post; ?>

  <div>
    <div>
      <label>Mail:</label></br>
      <a href="mailto:<?php echo get_post_meta($post->ID, 'email', true); ?>"><?php echo get_post_meta($post->ID, 'email', true); ?></a>
    <div>

      <div>
        <label>Téléphone:</label></br>
        <a href="tel:<?php echo get_post_meta($post->ID, 'phone', true); ?>"><?php echo get_post_meta($post->ID, 'phone', true); ?></a>
      <div>
  </div>
  <?php
}
