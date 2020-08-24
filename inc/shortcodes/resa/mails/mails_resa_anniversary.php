<?php
$to = $_POST['resa_contact_email'];
$object = 'Confirmation de pré-réservation';
$headers[] = 'From: FullInpark <contact@fullinpark.fr>';

$phpmailerInitAction = function(&$phpmailer) {
  $phpmailer->AddEmbeddedImage(PLUGIN_FIP_DIRECTORY.'img/logo.png', 'logo');
};
add_action('phpmailer_init', $phpmailerInitAction);
add_filter('wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );

$resa_jump = $_POST['resa_jump'];
if(empty($resa_jump)):
  $resa_jump = 0;
endif;

$resa_kids = $_POST['resa_kids'];
if(empty($resa_kids)):
  $resa_kids = 0;
endif;

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

  <table cellpadding="0" cellspacing="0" style="width: 100%; background: #FFF;">
    <tr style="background: #FFF;">
      <td class="pattern" width="600" style="background: #FFF;">
        <table cellpadding="10" cellspacing="0" style="width: 100%;">
          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                  <td>
                    Bonjour '.$_POST['resa_contact_fullname'].',
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                  <td>
                    Nous vous confirmons votre pré-réservation pour le '.date('d/m/Y', strtotime(fullinparkResaManager::convertDateFormat($_POST['resa_date']))).'.
                  </td>
                </tr>

                <tr>
                  <td>
                    Elle sera valable '.get_option('anniversary_resa_available').' jours. Afin de valider votre option de réservation, nous vous attendons dès que possible à Full in Park afin de régler l\'acompte (montant en fonction de la formule choisie et du nombre d’enfants) et récupérer les cartons d’invitations.
                  </td>
                </tr>

                <tr>
                  <td>(Pas de paiement en ligne possible).</td>
                </tr>

                <tr>
                  <td>
                    <a href="'.esc_url(home_url()).'/horaires-tarifs/">Horaires d’ouverture</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                  <td>
                    Pour plus d’informations, n’hésitez pas à nous contacter au <a href="tel:+334 65 85 16 95">04 65 85 16 95</a>.
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                  <td>
                    Sportivement
                    L’équipe Full in Park
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
', $headers );

$food_formula = $_POST['resa_anniversary_food_formula'];
if($food_formula == 'anniversary_sweetandsalty'):
  $formula = 'Sucrée + Salée';
elseif($food_formula == 'anniversary_salty'):
  $formula = 'Salée';
else:
  $formula = 'Sucrée';
endif;

if($_POST['resa_anniversary_formula'] == 'FIPKids'):
  $participants = $_POST['resa_kids'];
else:
  $participants = $_POST['resa_jump'];
endif;

wp_mail(get_option('fullinpark_admin_email'), 'Nouvelle réservation anniversaire', '
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

  <table cellpadding="0" cellspacing="10" style="width: 100%; background: #FFF;">
    <tr style="background: #FFF;">
      <td class="pattern" width="600" style="background: #FFF;">
        <table cellpadding="10" cellspacing="0" style="width: 100%;">
          <tr>
            <td>
              Numéro de réservation: #'.$resa_id.'
            </td>
          </tr>

          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                  <td>
                    Réservation Anniversaire de '.$_POST['resa_contact_fullname'].' '.$_POST['resa_contact_phone'].' '.$_POST['resa_contact_email'].' :
                  </td>
                </tr>

                <tr height="30">
                  <td></td>
                </tr>

                <tr>
                  <td>
                    Informations de réservation:
                  </td>
                </tr>

                <tr height="30">
                  <td></td>
                </tr>

                <tr>
                  <td>
                    Formule: '.$_POST['resa_anniversary_formula'].' - '.$formula.'
                  </td>
                </tr>

                <tr height="30">
                  <td></td>
                </tr>

                <tr>
                  <td>
                    Nombre de participant: '.$participants.'
                  </td>
                </tr>

                <tr>
                  <td>
                    Nom du roi ou de la reine de la fête: '.$_POST['resa_anniversary_kids_name'].'
                  </td>
                </td>

                <tr>
                  <td>
                    Age du roi ou de la reine de la fête: '.$_POST['resa_anniversary_kids_age'].'
                  </td>
                </td>

                <tr height="30">
                  <td></td>
                </tr>

                <tr>
                  <td>
                    Date & Heure: le '.date('d/m/Y', strtotime(fullinparkResaManager::convertDateFormat($_POST['resa_date']))).' à '.date('H:i', strtotime($_POST['resa_hour'])).' pour une durée de '.$_POST['resa_duration'].'
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
', $headers );

remove_action('phpmailer_init', $phpmailerInitAction);
remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
