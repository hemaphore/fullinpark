<?php
function is_valid_resa_id($resa_id){
  global $wpdb;

  $all_resa_infos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE ID = '$resa_id'");

  if(!empty($all_resa_infos)):
    return true;
  endif;

  return false;
}

if(isset($_POST['resa_id']) AND !empty($_POST['resa_id']) AND is_valid_resa_id(base64_decode($_POST['resa_id']))):
  $post_id = base64_decode($_POST['resa_id']); ?>

  <div id="edit_resa_form_container">
    <form action="#" method="POST" id="edit_resa_form">
      <p class="edit_resa_form_title">Modifier ma réservation</p>

      <div id="edit_resa_form_places">
        <div class="edit_resa_form_row">
          <label>Places Jump:</label>
          <div class="edit_resa_form_input_container">
            <input type="number" name="edit_resa_jump" id="edit_resa_jump" value="<?php echo (!empty(get_post_meta($post_id, 'resa_jump', true))) ? get_post_meta($post_id, 'resa_jump', true) : '0'; ?>" min="0" max="<?php echo get_option('max_jump_resa'); ?>" />
            <!--<a onclick="edit_resa_infos('#edit_resa_jump');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>-->
          </div>
        </div>

        <div class="edit_resa_form_row">
          <label>Places Kids:</label>
          <div class="edit_resa_form_input_container">
            <input type="number" name="edit_resa_kids" id="edit_resa_kids" value="<?php echo (!empty(get_post_meta($post_id, 'resa_kids', true))) ? get_post_meta($post_id, 'resa_kids', true) : '0'; ?>" min="0" max="<?php echo get_option('max_kids_resa'); ?>" />
            <!--<a onclick="edit_resa_infos('#edit_resa_kids');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>-->
          </div>
        </div>
      </div>

      <div id="edit_resa_form_date">
        <div class="edit_resa_form_row">
          <label>Date:</label>
          <div class="edit_resa_form_input_container">
            <input type="text" name="edit_resa_date" id="edit_resa_date" value="<?php echo date('d/m/Y', strtotime(get_post_meta($post_id, 'resa_date', true))); ?>"/>
            <!--<a onclick="edit_resa_infos('#edit_resa_date');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>-->
          </div>
        </div>

        <div class="edit_resa_form_row">
          <label>Heure:</label>
          <div class="edit_resa_form_input_container">
            <input type="text" name="edit_resa_hour" id="edit_resa_hour" value="<?php echo date('G:i', strtotime(get_post_meta($post_id, 'resa_hour', true))); ?>" />
            <!--<a onclick="edit_resa_infos('#edit_resa_hour');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>-->
          </div>
        </div>
      </div>

      <div id="edit_resa_form_date">
        <div class="edit_resa_form_row">
          <label>Durée:</label>
          <div class="edit_resa_form_input_container">
            <input type="text" name="edit_resa_duration" id="edit_resa_duration" value="<?php echo date('G:i', strtotime(get_post_meta($post_id, 'resa_duration', true))); ?>"/>
            <!--<a onclick="edit_resa_infos('#edit_resa_duration');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>-->
          </div>
        </div>

        <div class="edit_resa_form_row"></div>
      </div>

      <div class="edit_resa_form_row" style="margin-top: 2em;">
        <label>Nom complet:</label>
        <div class="edit_resa_form_input_container">
          <input type="text" name="edit_resa_contact_fullname" id="edit_resa_contact_fullname" value="<?php echo get_post_meta($post_id, 'resa_contact_fullname', true); ?>"/>
          <!--<a onclick="edit_resa_infos('#edit_resa_contact_fullname');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>-->
        </div>
      </div>

      <div class="edit_resa_form_row">
        <label>Email:</label>
        <div class="edit_resa_form_input_container">
          <input type="text" name="edit_resa_contact_email" id="edit_resa_contact_email" value="<?php echo get_post_meta($post_id, 'resa_contact_email', true); ?>"/>
          <!--<a onclick="edit_resa_infos('#edit_resa_contact_email');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>-->
        </div>
      </div>

      <div class="edit_resa_form_row">
        <label>Téléphone:</label>
        <div class="edit_resa_form_input_container">
          <input type="text" name="edit_resa_contact_phone" id="edit_resa_contact_phone" value="<?php echo get_post_meta($post_id, 'resa_contact_phone', true); ?>"/>
          <!--<a onclick="edit_resa_infos('#edit_resa_contact_phone');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/edit-blue.png'; ?>"/></a>-->
        </div>
      </div>

      <input type="hidden" name="edit_resa_id" value="<?php echo $post_id; ?>"/>
      <input type="hidden" name="resa_modify_form_submit" value="submitted"/>

      <div id="edit_resa_buttons_container">
        <a class="modify_button" onclick="submit_modify_resa();">Modifier ma réservation</button>
        <a data-href="<?php echo esc_url(home_url()); ?>/modifier-ma-reservation/?delete_resa=<?php echo $post_id; ?>" onclick="confirm_delete(this);">Supprimer ma réservation</a>
      </div>
    </form>
  </div>
  <?php
elseif(isset($_POST['resa_modify_form_submit']) AND $_POST['resa_modify_form_submit'] == 'submitted'):
  $resa_id = $_POST['edit_resa_id'];
  $resa_date = fullinparkResaManager::convertDateFormat($_POST['edit_resa_date']);

  update_post_meta($resa_id, 'resa_jump', $_POST['edit_resa_jump']);
  update_post_meta($resa_id, 'resa_kids', $_POST['edit_resa_kids']);
  update_post_meta($resa_id, 'resa_date', $resa_date);
  update_post_meta($resa_id, 'resa_hour', $_POST['edit_resa_hour']);
  update_post_meta($resa_id, 'resa_duration', $_POST['edit_resa_duration']);

  //Contact infos
  update_post_meta($resa_id, 'resa_contact_fullname', $_POST['edit_resa_contact_fullname']);
  update_post_meta($resa_id, 'resa_contact_email', $_POST['edit_resa_contact_email']);
  update_post_meta($resa_id, 'resa_contact_phone', $_POST['edit_resa_contact_phone']);

  require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/mails/mails_modify_resa.php'); ?>

  <div>
    <p>Réservation modifié !!!</p>

    <a href="<?php echo esc_url(home_url()); ?>">Retour à l'accueil</a>
  </div>
  <?php
else:
  if(isset($_GET['delete_resa'])):
    global $wpdb;
    $wpdb->delete("{$wpdb->prefix}posts", array("ID" =>  $_GET['delete_resa']));

    echo '<p style="text-align: center; color: #FFF; font-weight: bold; text-transform: uppercase;">Réservation supprimée.</p>';
  endif;

  if(isset($_POST['resa_id'])):
    echo '<p style="color: red; text-align: center; font-weight: bold;">L\'identifiant est inccorect.</p>';
  endif;  ?>

  <div id="modify_resa_container">
    <p>Entrer votre code de réservation reçu par mail</p>

    <form action="#" method="POST">
      <input type="text" name="resa_id"/>
      <button>Modifier</button>
    </form>
  </div>
  <?php
endif;
