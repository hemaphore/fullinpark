<form action="#" method="POST">
  <p class="fip_admin_title">Email</p>

  <div class="fullinpark_form_row">
    <label>Email administrateur: </label>
    <input type="text" name="fullinpark_admin_email" id="fullinpark_admin_email" value="<?php echo get_option('fullinpark_admin_email'); ?>"/>
  </div>

  <p class="fip_admin_title">Réservation</p>

  <div>
    <label>Max entrée Jump: </label>
    <input type="number" name="max_jump_resa" id="max_jump_resa" value="<?php echo get_option('max_jump_resa'); ?>"/>
  </div>

  <div>
    <label>Max Stage: </label>
    <input type="number" name="max_stage_resa" id="max_stage_resa" value="<?php echo get_option('max_stage_resa'); ?>"/>
  </div>

  <div>
    <label>Max Cours Privé: </label>
    <input type="number" name="max_private_course" id="max_private_course" value="<?php echo get_option('max_private_course'); ?>"/>
  </div>

  <div>
    <label>Max entrée Kids: </label>
    <input type="number" name="max_kids_resa" id="max_kids_resa" value="<?php echo get_option('max_kids_resa'); ?>"/>
  </div>

  <div>
    <label>Validité d'une réservation Anniversaire (nb jour): </label>
    <input type="number" name="anniversary_resa_available" id="anniversary_resa_available" value="<?php echo get_option('anniversary_resa_available'); ?>"/>
  </div>

  <div>
    <label>Validité d'une réservation Stage (nb jour): </label>
    <input type="number" name="stage_resa_available" id="stage_resa_available" value="<?php echo get_option('stage_resa_available'); ?>"/>
  </div>

  <input type="hidden" name="update_fullinpark_settings" value="updated"/>
  <button type="submit" class="button button-primary">Enregister</button>
</form>
