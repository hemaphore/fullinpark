<?php
$to = $_POST['resa_contact_email'];
$object = 'Confirmation de pré-réservation';
$headers[] = 'From: FullInpark <contact@fullinpark.fr>';

$phpmailerInitAction = function(&$phpmailer) {
  $phpmailer->AddEmbeddedImage(PLUGIN_FIP_DIRECTORY.'img/logo.png', 'logo');
};
add_action('phpmailer_init', $phpmailerInitAction);
add_filter('wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );

$participants = $_POST['resa_jump'];
$stage_days = '';

$all_dates = explode(',', $_POST['resa_date']);

for($i=0; $i < count($all_dates); $i++):
  if($all_dates[$i] != ''):
    $date_infos =  explode('-', $all_dates[$i]);

    $stage_days .= '
    <tr>
      <td>- Le '.date('d/m/Y', strtotime(fullinparkResaManager::convertDateFormat($date_infos[0]))).' à '.$date_infos[1].'</td>
    </tr>';
  endif;
endfor;

wp_mail($to, $object, '
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
                    Nous vous confirmons votre pré-réservation pour les dates suivantes:
                  </td>
                </tr>

                <tr height="30">
                  <td></td>
                </tr>

                '.$stage_days.'

                <tr height="30">
                  <td></td>
                </tr>

                <tr>
                  <td>
                    Elle sera valable '.get_option('stage_resa_available').' jours. Afin de valider votre option de réservation, nous vous attendons dès que possible à Full in Park afin de régler le solde.
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

wp_mail(get_option('fullinpark_admin_email'), 'Nouvelle réservation stage', '
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
                    Réservation Stage de '.$_POST['resa_contact_fullname'].' '.$_POST['resa_contact_phone'].' '.$_POST['resa_contact_email'].' :
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

                '.$stage_days.'

                <tr height="30">
                  <td></td>
                </tr>

                <tr>
                  <td>
                    Nombre de participant: '.$participants.'
                  </td>
                </tr>


                <tr height="30">
                  <td></td>
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
