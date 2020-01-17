<?php
global $wpdb;

//Register Résa
if(isset($_POST['resa_sent'])):
  $resa_infos = array(
	  'post_title'    => $_POST['resa_contact_fullname'].' - '.date('d/m/Y'),
	  'post_content'  => '',
	  'post_status'   => 'publish',
	  'post_author'   => 1,
	  'post_category' => array(),
		'post_type'     => 'fip_resa',
	);

	$resa_id = wp_insert_post($resa_infos);

  update_post_meta($resa_id, 'resa_activity', $_POST['resa_activity']);
  update_post_meta($resa_id, 'resa_jump', $_POST['resa_jump']);
  update_post_meta($resa_id, 'resa_kids', $_POST['resa_kids']);
  update_post_meta($resa_id, 'resa_date', $_POST['resa_date']);
  update_post_meta($resa_id, 'resa_hour', $_POST['resa_hour']);

  //Contact infos
  update_post_meta($resa_id, 'resa_contact_fullname', $_POST['resa_contact_fullname']);
  update_post_meta($resa_id, 'resa_contact_email', $_POST['resa_contact_email']);
  update_post_meta($resa_id, 'resa_contact_phone', $_POST['resa_contact_phone']);

  $to = $_POST['resa_contact_email'];
  $object = 'Confirmation de réservation';
  $headers[] = 'From: FullInpark <contact@fullinpark.fr>';

  add_filter('wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );

  wp_mail( $to, $object, '
    <style>
      table tr{ margin: 0.5em 0 !important;  }
      table td p{
        text-align: justify!important;
        margin: 0;
        padding: 0;
      }

      @media only screen and (max-width: 599px) {
        td[class="pattern"] td{ width: 100%;  }
      }
    </style>

    <table cellpadding="0" cellspacing="0" style="width: 100%;">
      <tr>
        <td class="pattern" width="600">
          <table cellpadding="4" cellspacing="0" style="width: 100%; background: #080f24;">
            <tr>
              <td>
                <p>Logo</p>
              </td>

              <td>
                <p>Contact</p>
              </td>
            </tr>
          </table>

          <table cellpadding="4" cellspacing="0" style="width: 100%;">
            <tr>
              <td>
                <p>Votre réservation a bien été prise en compte</p>
              </td>
            </tr>
          </table>

          <table cellpadding="4" cellspacing="0" style="width: 100%; background: #080f24;">
            <tr>
              <td>
                <a href="http://fullinpark.fr" style="color: #FFF; text-decoration: none;">fullinpark.fr</a>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  ', $headers );

  wp_mail(get_option('fullinpark_admin_email'), 'Nouvelle réservation', '
    <style>
      table tr{ margin: 0.5em 0 !important;  }
      table td p{
        text-align: justify!important;
        margin: 0;
        padding: 0;
      }

      @media only screen and (max-width: 599px) {
        td[class="pattern"] td{ width: 100%;  }
      }
    </style>

    <table cellpadding="0" cellspacing="0" style="width: 100%;">
      <tr>
        <td class="pattern" width="600">
          <table cellpadding="4" cellspacing="0" style="width: 100%; background: #080f24;">
            <tr>
              <td>
                <p>Logo</p>
              </td>

              <td>
                <p>Contact</p>
              </td>
            </tr>
          </table>

          <table cellpadding="4" cellspacing="0" style="width: 100%;">
            <tr>
              <td>
                <p>Une nouvelle réservation a été envoyée via le formulaire de réservation</p>
              </td>
            </tr>
          </table>

          <table cellpadding="4" cellspacing="0" style="width: 100%; background: #080f24;">
            <tr>
              <td>
                <a href="http://fullinpark.fr" style="color: #FFF; text-decoration: none;">fullinpark.fr</a>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  ', $headers );

  remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
endif;

//Register Question
if(isset($_POST['question_sent'])):
  $question_infos = array(
	  'post_title'    => $_POST['question_fullname'].' - '.date('d/m/Y'),
	  'post_content'  => $_POST['question_core'],
	  'post_status'   => 'publish',
	  'post_author'   => 1,
	  'post_category' => array(),
		'post_type'     => 'fip_question',
	);

	$question_id = wp_insert_post($question_infos);

  update_post_meta($question_id, 'email', $_POST['question_email']);
  update_post_meta($question_id, 'phone', $_POST['question_phone']);

  //Send email to user
  $to = $_POST['question_email'];
  $object = 'Question bien reçu';
  $headers[] = 'From: FullInpark <contact@fullinpark.fr>';

  add_filter('wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );

  wp_mail( $to, $object, '
    <style>
      table tr{ margin: 0.5em 0 !important;  }
      table td p{
        text-align: justify!important;
        margin: 0;
        padding: 0;
      }

      @media only screen and (max-width: 599px) {
        td[class="pattern"] td{ width: 100%;  }
      }
    </style>

    <table cellpadding="0" cellspacing="0">
      <tr>
        <td class="pattern" width="600">
          <table cellpadding="4" cellspacing="0">
            <tr>
              <td>
                <p>Votre question a bien été envoyée, nous vous répondrons dans les meilleurs délais.</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  ', $headers );

  wp_mail(get_option('fullinpark_admin_email'), 'Une nouvelle question envoyée', '
    <style>
      table tr{ margin: 0.5em 0 !important;  }
      table td p{
        text-align: justify!important;
        margin: 0;
        padding: 0;
      }

      @media only screen and (max-width: 599px) {
        td[class="pattern"] td{ width: 100%;  }
      }
    </style>

    <table cellpadding="0" cellspacing="0">
      <tr>
        <td class="pattern" width="600">
          <table cellpadding="4" cellspacing="0">
            <tr>
              <td>
                <p>Une question a été envoyé via le site internet</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  ', $headers );

  remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
endif;  ?>

<!--<div style="width:37%; ">-->

<div id="fullinpark_resa_form_entete">
  <div id="fullinpark_resa_form_entete_resa_button">
    <a onclick="show_resa_form();">Réservations</a>
  </div>

  <div id="fullinpark_resa_form_entete_question_button">
    <a onclick="show_question_form();">Question ?</a>
  </div>
</div>

<div id="fullinpark_resa_form_container">
  <div id="fullinpark_resa_form_content">
    <div>
      <p class="main_title">VOUS ÊTES: </p>

      <div class="grey_container">
        <p class="association_title">ASSOCIATIONS ENTREPRISES COLLECTIVITÉES </p>
        <a class="association_link">C'est par ici</a>
      </div>
    </div>

    <div>
      <p class="secondary_title">PARTICULIERS</p>

      <div class="grey_container">
        <div class="custom_select">
          <a id="toogle_activities_button" onclick="toogle_activities();">
            <p class="custom_select_default">Choisis <span class="blue bold">ton activité</span></p>
            <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-blue.png'; ?> "/>
          </a>

          <div id="custom_select_activities">
            <ul>
              <?php
              if(get_option('fullinpark_jump_kids_activation')): ?>
                <li onclick="activity_selected('Jump')">Jump</li><?php
              endif;

              if(get_option('fullinpark_anniversary_activation')): ?>
                <li onclick="activity_selected('Anniversaire')">Anniversaire</li><?php
              endif;

              if(get_option('fullinpark_stages_activation')): ?>
                <li onclick="show_stages_selector();">Stage</li><?php
              endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div id="stage_selector_container">
      <p class="secondary_title">Stages</p>

      <?php
      $all_stages = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'fip_stage'"); ?>

      <div class="grey_container">
        <div class="custom_select">
          <a id="toogle_stages_button" onclick="toogle_stages();">
            <p class="custom_select_default">Choisis <span class="blue bold">ton stage</span></p>
            <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-blue.png'; ?> "/>
          </a>

          <div id="custom_select_stages">
            <ul>
              <?php
              foreach ($all_stages as $stage):  ?>
                <li onclick="stage_selected('<?php echo $stage->post_title; ?>')"><?php echo $stage->post_title; ?></li><?php
              endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div>
      <p class="secondary_title">PARTICIPANTS</p>

      <div class="grey_container">
        <div id="all_tickets_details">
          <div class="tickets_infos_container">
            <p class="tickets_infos_title">Kids (1 à 5ans)</p>

            <div class="tickets_infos_content">
              <a class="resa_minus" onclick="remove_ticket('kids');">-</a>
              <p id="ticket_number_kids" class="resa_number">0</p>
              <a class="resa_add" onclick="add_ticket('kids');">+</a>
            </div>
          </div>

          <div class="tickets_infos_container">
            <p class="tickets_infos_title">Jump (6 à 77ans)</p>

            <div class="tickets_infos_content">
              <a class="resa_minus" onclick="remove_ticket('jump');">-</a>
              <p id="ticket_number_jump" class="resa_number">0</p>
              <a class="resa_add" onclick="add_ticket('jump');">+</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="date_hours_container">
      <div class="date_hours_box">
        <a onclick="show_datepicker();">
          <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/picto-calendrier-FIP.png'; ?>"/>
          <p><span id="date_selected">Date</span> <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-blue.png'; ?> "/></p>
        </a>
      </div>

      <div class="date_hours_box">
        <a onclick="show_datepicker();">
          <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/picto-horloge-FIP.png'; ?>"/>
          <p><span id="hour_selected">Heure</span> <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-blue.png'; ?>"/></p>
        </a>
      </div>
    </div>

    <div id="resa_form_submit_button">
      <a class="next_step" onclick="go_to_step2();">Valider</a>
      <a href="#" id="update_resa_button">Modifier ma reservation</a>
    </div>
  </div>

  <div id="fullinpark_second_step_form_content">
    <div>
      <p class="main_title">Contact: </p>

      <div>
        <p class="secondary_title">Nom complet</p>
        <input type="text" id="resa_fullname" onchange="update_contact_infos();"/>
      </div>

      <div>
        <p class="secondary_title">Email</p>
        <input type="text" id="resa_email" onchange="update_contact_infos();"/>
      </div>

      <div>
        <p class="secondary_title">Téléphone</p>
        <input type="text" id="resa_phone" onchange="update_contact_infos();"/>
      </div>
    </div>

    <div id="resa_form_submit_button">
      <a class="return_button" onclick="show_resa_form();">Retour</a>
      <a class="next_step" onclick="submit_resa_form();">Réserver</a>
    </div>
  </div>

  <div id="fullinpark_question_form_content">
    <p class="main_title">Votre question</p>

    <form action="#" method="POST" id="question_form">
      <div class="question_form_row">
        <label for="question_fullname">Nom complet</label>
        <input type="text" id="question_fullname" name="question_fullname"/>
      </div>

      <div class="question_form_row">
        <label for="question_email">Email</label>
        <input type="text" id="question_email" name="question_email"/>
      </div>

      <div class="question_form_row">
        <label for="question_phone">Téléphone</label>
        <input type="text" id="question_phone" name="question_phone"/>
      </div>

      <div class="question_form_row">
        <label for="question_core">Question</label>
        <textarea id="question_core" name="question_core"></textarea>
      </div>

      <input type="hidden" name="question_sent" value="sent"/>
      <button type="submit">Envoyer</button>
    </form>
  </div>
</div>

<div id="datepicker_container">
  <a id="hide_datepicker" onclick="hide_datepicker();"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/delete-white.png'; ?> "/></a>
  <div id="datepicker"></div>

  <div id="datepicker_step2">
    <p>Date sélectionnée: <span id="datepicker_step2_value">none</span></p>

    <div>
      <ul>
        <li class="full" onclick="select_hour('8:00');">8:00</li>
        <li onclick="select_hour('8:30');">8:30</li>
        <li onclick="select_hour('9:00');">9:00</li>
        <li class="not_enough_places" onclick="select_hour('9:30');">9:30</li>
        <li onclick="select_hour('10:00');">10:00</li>
        <li class="full" onclick="select_hour('10:30');">10:30</li>
        <li onclick="select_hour('11:00');">11:00</li>
        <li onclick="select_hour('11:30');">11:30</li>
        <li class="not_enough_places" onclick="select_hour('12:00');">12:00</li>
        <li onclick="select_hour('12:30');">12:30</li>
      </ul>
    </div>
  </div>
</div>

<div id="form_errors_message">
  <a>x</a>
  erreurs !!!
</div>

<form action="#" method="POST" id="fullinpark_resa_form">
  <!-- Réservation infos -->
  <input type="hidden" name="resa_jump" id="resa_jump"/>
  <input type="hidden" name="resa_kids" id="resa_kids"/>
  <input type="hidden" name="resa_activity" id="resa_activity" />
  <input type="hidden" name="resa_date" id="resa_date"/>
  <input type="hidden" name="resa_hour" id="resa_hour" />

  <!-- Contact -->
  <input type="hidden" name="resa_contact_fullname" id="resa_contact_fullname"/>
  <input type="hidden" name="resa_contact_email" id="resa_contact_email"/>
  <input type="hidden" name="resa_contact_phone" id="resa_contact_phone" />

  <input type="hidden" name="resa_sent" value="sent"/>
</form>


<!--</div>-->
