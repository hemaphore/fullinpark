<?php
$to = $_POST['edit_resa_contact_email'];
$object = 'Réservation #'.$resa_id.' modifié';
$headers[] = 'From: FullInpark <contact@fullinpark.fr>';

$phpmailerInitAction = function(&$phpmailer) {
  $phpmailer->AddEmbeddedImage(PLUGIN_FIP_DIRECTORY.'img/logo.png', 'logo');
};
add_action('phpmailer_init', $phpmailerInitAction);
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

  <table cellpadding="0" cellspacing="0" style="width: 100%; background: #FFF;">
    <tr style="background: #FFF;">
      <td class="pattern" width="600" style="background: #FFF;">
        <table cellpadding="10" cellspacing="0" style="width: 100%;">
          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                  <td>
                    Bonjour '.$_POST['edit_resa_contact_fullname'].',
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
                    Nous vous confirmons que votre réservation #'.$resa_id.' à bien été modifié :
                  </td>
                </tr>

                <tr>
                  <td>
                    - '.$_POST['edit_resa_jump'].' en zone Jump le '.date('d/m/Y', strtotime(fullinparkResaManager::convertDateFormat($_POST['edit_resa_date']))).' à '.date('H:i', strtotime($_POST['edit_resa_hour'])).' pour une durée de '.$_POST['edit_resa_duration'].'
                  </td>
                </tr>

                <tr>
                  <td>
                    - '.$_POST['edit_resa_kids'].' en zone kids le '.date('d/m/Y', strtotime(fullinparkResaManager::convertDateFormat($_POST['edit_resa_date']))).' à '.date('H:i', strtotime($_POST['edit_resa_hour'])).' pour une durée de '.$_POST['edit_resa_duration'].'
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
                    Petit rappel : Les chaussettes antidérapantes sont obligatoires (elles sont disponibles à la vente sur place en cas de besoin !)
                  </td>
                </tr>

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

wp_mail(get_option('fullinpark_admin_email'), 'Réservation #'.$resa_id.' modifié', '
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
              Numéro de réservation modifié: #'.$resa_id.'
            </td>
          </tr>

          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                  <td>
                    Réservation confirmée de '.$_POST['edit_resa_contact_fullname'].' '.$_POST['edit_resa_contact_phone'].' '.$_POST['edit_resa_contact_email'].' :
                  </td>
                </tr>

                <tr>
                  <td>
                    - '.$_POST['edit_resa_jump'].' en zone Jump le '.date('d/m/Y', strtotime(fullinparkResaManager::convertDateFormat($_POST['edit_resa_date']))).' à '.date('H:i', strtotime($_POST['edit_resa_hour'])).' pour une durée de '.$_POST['edit_resa_duration'].'
                  </td>
                </tr>

                <tr>
                  <td>
                    - '.$_POST['edit_resa_kids'].' en zone kids le le '.date('d/m/Y', strtotime(fullinparkResaManager::convertDateFormat($_POST['edit_resa_date']))).' à '.date('H:i', strtotime($_POST['edit_resa_hour'])).' pour une durée de '.$_POST['edit_resa_duration'].'
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
