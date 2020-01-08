<?php
if(isset($_POST['resa_id']) AND !empty($_POST['resa_id'])):
  $post_id = $_POST['resa_id']; ?>
  <div id="edit_resa_form_container">
    <form action="#" method="POST" id="edit_resa_form">
      <p class="edit_resa_form_title">Modifier ma réservation</p>

      <div id="edit_resa_form_places">
        <div class="edit_resa_form_row">
          <label>Places Jump:</label>
          <div class="edit_resa_form_input_container">
            <input type="text" name="edit_resa_jump" id="edit_resa_jump" value="<?php echo get_post_meta($post_id, 'resa_jump', true); ?>" disabled/>
            <a onclick="edit_resa_infos('#edit_resa_jump');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>
          </div>
        </div>

        <div class="edit_resa_form_row">
          <label>Places Kids:</label>
          <div class="edit_resa_form_input_container">
            <input type="text" name="edit_resa_kids" id="edit_resa_kids" value="<?php echo get_post_meta($post_id, 'resa_kids', true); ?>" disabled/>
            <a onclick="edit_resa_infos('#edit_resa_kids');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>
          </div>
        </div>
      </div>

      <div id="edit_resa_form_date">
        <div class="edit_resa_form_row">
          <label>Date:</label>
          <div class="edit_resa_form_input_container">
            <input type="text" name="edit_resa_date" id="edit_resa_date" value="<?php echo date('d/m/Y', strtotime(get_post_meta($post_id, 'resa_date', true))); ?>" disabled/>
            <a onclick="edit_resa_infos('#edit_resa_date');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>
          </div>
        </div>

        <div class="edit_resa_form_row">
          <label>Heure:</label>
          <div class="edit_resa_form_input_container">
            <input type="text" name="edit_resa_hour" id="edit_resa_hour" value="<?php echo date('h:i', strtotime(get_post_meta($post_id, 'resa_hour', true))); ?>" disabled/>
            <a onclick="edit_resa_infos('#edit_resa_hour');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>
          </div>
        </div>
      </div>

      <div class="edit_resa_form_row">
        <label>Nom complet:</label>
        <div class="edit_resa_form_input_container">
          <input type="text" name="edit_resa_contact_fullname" id="edit_resa_contact_fullname" value="<?php echo get_post_meta($post_id, 'resa_contact_fullname', true); ?>" disabled/>
          <a onclick="edit_resa_infos('#edit_resa_contact_fullname');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>
        </div>
      </div>

      <div class="edit_resa_form_row">
        <label>Email:</label>
        <div class="edit_resa_form_input_container">
          <input type="text" name="edit_resa_contact_email" id="edit_resa_contact_email" value="<?php echo get_post_meta($post_id, 'resa_contact_email', true); ?>" disabled/>
          <a onclick="edit_resa_infos('#edit_resa_contact_email');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>
        </div>
      </div>

      <div class="edit_resa_form_row">
        <label>Téléphone:</label>
        <div class="edit_resa_form_input_container">
          <input type="text" name="edit_resa_contact_phone" id="edit_resa_contact_phone" value="<?php echo get_post_meta($post_id, 'resa_contact_phone', true); ?>" disabled/>
          <a onclick="edit_resa_infos('#edit_resa_contact_phone');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>
        </div>
      </div>

      <input type="hidden" name="edit_resa_id" value="<?php echo $post_id; ?>"/>
      <input type="hidden" name="resa_modify_form_submit" value="submitted"/>
      <button>Modifier ma réservation</button>
    </form>
  </div>
  <?php
elseif(isset($_POST['resa_modify_form_submit']) AND $_POST['resa_modify_form_submit'] == 'submitted'):
  $resa_id = $_POST['edit_resa_id'];

  update_post_meta($resa_id, 'resa_jump', $_POST['edit_resa_jump']);
  update_post_meta($resa_id, 'resa_kids', $_POST['edit_resa_kids']);
  update_post_meta($resa_id, 'resa_date', $_POST['edit_resa_date']);
  update_post_meta($resa_id, 'resa_hour', $_POST['edit_resa_hour']);

  //Contact infos
  update_post_meta($resa_id, 'resa_contact_fullname', $_POST['edit_resa_contact_fullname']);
  update_post_meta($resa_id, 'resa_contact_email', $_POST['edit_resa_contact_email']);
  update_post_meta($resa_id, 'resa_contact_phone', $_POST['edit_resa_contact_phone']); ?>

  <div>
    <p>Réservation modifié !!!</p>

    <a href="<?php echo esc_url(home_url()); ?>">Retour à l'accueil</a>
  </div>
  <?php
else: ?>
  <div>
    <p>Entrer votre identifiant de réservation réçu par mail</p>
    <form action="#" method="POST">
      <input type="text" name="resa_id"/>
      <button>Modifier</button>
    </form>
  </div>
  <?php
endif;
