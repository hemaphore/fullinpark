<?php
//Send email to user
$from = $_POST['question_email'];
$from_label = $_POST['question_fullname'];
$headers[] = 'From: '.ucfirst($from_label).' <'.$from.'>';

add_filter('wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );

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
        <table cellpadding="10" cellspacing="0" style="width: 100%;">
          <tr>
            <td>
              Vous avez reçu une question: '.$_POST['question_core'].'
            </td>
          </tr>

          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                  <td>
                    Expéditeur: '.$_POST['question_fullname'].'
                  </td>
                </tr>

                <tr>
                  <td>
                    Téléphone: '.$_POST['question_phone'].'
                  </td>
                </tr>

                <tr>
                  <td>
                    Email: '.$_POST['question_email'].'
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

remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
