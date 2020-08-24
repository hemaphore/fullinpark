<?php
function fip_structures_infos_html(){
  global $post; ?>

  <div>
    <div class="structure_infos_box">
      <label>Adresse de la structure:</label></br>
      <?php echo get_post_meta($post->ID, 'adress', true); ?>
    <div>

    <div class="structure_infos_box">
      <label>Date de l'animation:</label></br>
      <?php echo get_post_meta($post->ID, 'date', true); ?>
    <div>

    <div class="structure_infos_box">
      <label>Heure d’arrivée:</label></br>
      <?php echo get_post_meta($post->ID, 'start_hour', true); ?>
    <div>

    <div class="structure_infos_box">
      <label>Heure de départ:</label></br>
      <?php echo get_post_meta($post->ID, 'end_hour', true); ?>
    <div>

    <div class="structure_infos_box">
      <label>Nombre et âge des participants:</label></br>
      <?php echo get_post_meta($post->ID, 'participants', true); ?>
    <div>

    <div class="structure_infos_box">
      <label>Nombre d’accompagnateur:</label></br>
      <?php echo get_post_meta($post->ID, 'accompany', true); ?>
    <div>

    <div class="structure_infos_box">
      <label>Durée de la séance:</label></br>
      <?php echo get_post_meta($post->ID, 'duration', true); ?>
    <div>

    <div class="structure_infos_box">
      <label>Mail:</label></br>
      <a href="mailto:<?php echo get_post_meta($post->ID, 'email', true); ?>"><?php echo get_post_meta($post->ID, 'email', true); ?></a>
    <div>

    <div class="structure_infos_box">
      <label>Téléphone:</label></br>
      <a href="tel:<?php echo get_post_meta($post->ID, 'phone', true); ?>"><?php echo get_post_meta($post->ID, 'phone', true); ?></a>
    <div>
  </div>

  <style>
    .structure_infos_box{ margin: 15px 0; }
    .structure_infos_box label{ text-decoration: underline; }
  </style>
  <?php
}
