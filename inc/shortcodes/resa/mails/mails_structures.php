<?php
//Send email to user
$from = $_POST['structure_email'];
$from_label = $_POST['structure_fullname'];
$headers[] = 'From: '.ucfirst($from_label).' <'.$from.'>';

add_filter('wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );

wp_mail(get_option('fullinpark_admin_email'), 'Une nouvelle demande de structure envoyée', '
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
        <table cellpadding="10" cellspacing="0" style="width: 100%;">
          <tr>
            <td>
              Vous avez reçu une demande de structure
            </td>
          </tr>

          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                  <td>
                    Expéditeur: '.$_POST['structure_fullname'].'
                  </td>
                </tr>

                <tr>
                  <td>
                    Adresse: '.$_POST['structure_adresse'].'
                  </td>
                </tr>

                <tr>
                  <td>
                    Ville: '.$_POST['structure_town'].'
                  </td>
                </tr>

                <tr>
                  <td>
                    Code Postal: '.$_POST['structure_zipcode'].'
                  </td>
                </tr>

                <tr>
                  <td>
                    Téléphone: '.$_POST['structure_phone'].'
                  </td>
                </tr>

                <tr>
                  <td>
                    Email: '.$_POST['structure_email'].'
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr>
            <td>
              Récapitulatif de la demande:
            </td>
          </tr>

          <tr>
            <td>
              Date de l\'animation: '.$_POST['structure_date'].'
            </td>
          </tr>

          <tr>
            <td>
              Heure d\'arrivée: '.$_POST['structure_start_hour'].'
            </td>
          </tr>

          <tr>
            <td>
              Heure de départ: '.$_POST['structure_end_hour'].'
            </td>
          </tr>

          <tr>
            <td>
              Nombre et âge des participants: '.$_POST['structure_participants'].'
            </td>
          </tr>

          <tr>
            <td>
              Nombre d\'accompagnateur: '.$_POST['structure_accompany'].'
            </td>
          </tr>

          <tr>
            <td>
              Durée de la séance: '.$_POST['structure_duration'].'
            </td>
          </tr>

          <tr>
            <td>
              Formule choisie: '.$_POST['structure_formula'].'
            </td>
          </tr>

          <tr>
            <td>
              Remarques / Divers: '.$_POST['structure_divers'].'
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
', $headers );

remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
