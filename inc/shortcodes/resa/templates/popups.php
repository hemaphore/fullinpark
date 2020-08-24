<?php
if(isset($_POST['resa_sent']) AND $_POST['resa_sent'] == 'sent'): ?>
  <div id="validation_message" class="validation_message_popup">
    <a class="close_popup" onclick="hide_popup('#validation_message');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/delete-white.png'; ?> "/></a>

    <div class="validation_message_popup_content">
      <p>
        <?php
        if($_POST['resa_activity'] == "Anniversary"): ?>
          Nous vous confirmons votre pré-réservation pour le <?php echo date('d/m/Y', strtotime(fullinparkResaManager::convertDateFormat($_POST['resa_date']))); ?></br>
          Elle sera valable <?php echo get_option('anniversary_resa_available'); ?> jours. Afin de valider votre option de réservation, nous vous attendons dès que possible à Full in Park afin de régler l'acompte (montant en fonction de la formule choisie et du nombre d’enfants) et récupérer les cartons d’invitations.</br>
          (Pas de paiement en ligne possible).</br>
          <a href="<?php echo esc_url(home_url()).'/horaires-tarifs/'; ?>">Horaires d’ouverture</a></br>
          <?php
        elseif($_POST['resa_activity'] == "Stages"):
          $stage_days = '';

          $all_dates = explode(',', $_POST['resa_date']);

          for($i=0; $i < count($all_dates); $i++):
            if($all_dates[$i] != ''):
              $date_infos =  explode('-', $all_dates[$i]);

              $stage_days .= '<li>- Le '.date('d/m/Y', strtotime(fullinparkResaManager::convertDateFormat($date_infos[0]))).' à '.$date_infos[1].'</li>';
            endif;
          endfor;
          ?>
          Nous vous confirmons votre pré-réservation pour la/les date(s) suivante(s):</br>

          <ul>
            <?php echo $stage_days; ?>
          </ul>

          </br>
          Elle sera valable <?php echo get_option('stage_resa_available'); ?> jours. Afin de valider votre option de réservation, nous vous attendons dès que possible à Full in Park afin de régler le solde.</br>
          (Pas de paiement en ligne possible).</br>
          <a href="<?php echo esc_url(home_url()).'/horaires-tarifs/'; ?>">Horaires d’ouverture</a></br>
          <?php
        else: ?>
          Bonjour <?php echo $_POST['resa_contact_fullname']; ?>,</br>
          Votre réservation a bien été enregistrée.</br>
          Merci d'avoir choisi notre parc.
          <?php
        endif; ?>
      </p>

      <p>
        Sportivement</br>
        L’équipe Full in park
      </p>

      <a id="return_homepage_button" href="<?php echo esc_url(home_url()); ?>">Retour à l'Accueil</a>
    </div>
  </div>
  <?php
endif;

if(isset($_POST['question_sent']) AND $_POST['question_sent'] == 'sent'): ?>
  <div id="validation_message_question" class="validation_message_popup">
    <a class="close_popup" onclick="hide_popup('#validation_message_question');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/delete-white.png'; ?> "/></a>

    <div class="validation_message_popup_content">
      <p>
        Bonjour <?php echo $_POST['question_fullname']; ?>,</br>
        Votre demande a bien été transmise à nos équipes, qui ne tarderont pas à vous répondre.</br>
        Merci de l’intérêt que vous portez à notre parc.
      </p>

      <p>
        Sportivement</br>
        L’équipe Full in park
      </p>

      <a id="return_homepage_button" href="<?php echo esc_url(home_url()); ?>">Retour à l'Accueil</a>
    </div>
  </div>
  <?php
endif;

if(isset($_POST['structure_sent']) AND $_POST['structure_sent'] == 'sent'): ?>
  <div id="validation_message_question" class="validation_message_popup">
    <a class="close_popup" onclick="hide_popup('#validation_message_question');"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/delete-white.png'; ?> "/></a>

    <div class="validation_message_popup_content">
      <p>
        Bonjour <?php echo $_POST['structure_fullname']; ?>,</br>
        Votre demande a bien été transmise à nos équipes, qui ne tarderont pas à vous répondre.</br>
        Merci de l’intérêt que vous portez à notre parc.
      </p>

      <p>
        Sportivement</br>
        L’équipe Full in park
      </p>

      <a id="return_homepage_button" href="<?php echo esc_url(home_url()); ?>">Retour à l'Accueil</a>
    </div>
  </div>
  <?php
endif;
