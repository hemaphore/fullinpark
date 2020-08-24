<?php
global $wpdb;

//Register Résa
if(isset($_POST['resa_sent']) && !isset($_SESSION['already_submitted'])):
  $_SESSION['already_submitted'] = true;

  if($_POST['resa_activity'] == "Stages"):
    $all_dates = explode(',', $_POST['resa_date']);

    for ($i=0; $i < count($all_dates); $i++):
      if($all_dates[$i] != ''):
        $date_infos =  explode('-', $all_dates[$i]);

        $resa_infos = array(
      	  'post_title'    => $_POST['resa_contact_fullname'].' - '.date('d/m/Y'),
      	  'post_content'  => '',
      	  'post_status'   => 'publish',
      	  'post_author'   => 1,
      	  'post_category' => array(),
      		'post_type'     => 'fip_resa',
      	);

      	$resa_id = wp_insert_post($resa_infos);

        update_post_meta($resa_id, 'resa_stage_choice', $_POST['resa_stage_choice']);
        update_post_meta($resa_id, 'resa_activity', "Stage");
        update_post_meta($resa_id, 'resa_jump', $_POST['resa_jump']);
        update_post_meta($resa_id, 'resa_kids', 0);
        update_post_meta($resa_id, 'resa_date', date('Y-m-d', strtotime(fullinparkResaManager::convertDateFormat($date_infos[0]))));
        update_post_meta($resa_id, 'resa_duration', $_POST['resa_duration']);
        update_post_meta($resa_id, 'resa_hour', $date_infos[1]);
        update_post_meta($resa_id, 'resa_riders', $_POST['resa_riders']);

        //Infos Stagiaire
        for($i=1; $i <= $_POST['resa_jump']; $i++):
          update_post_meta($resa_id, 'stagiaire'.$i.'_lastname', $_POST['stagiaire'.$i.'_lastname']);
          update_post_meta($resa_id, 'stagiaire'.$i.'_firstname', $_POST['stagiaire'.$i.'_firstname']);
          update_post_meta($resa_id, 'stagiaire'.$i.'_age', $_POST['stagiaire'.$i.'_age']);
        endfor;

        //Contact infos
        update_post_meta($resa_id, 'resa_contact_fullname', $_POST['resa_contact_fullname']);
        update_post_meta($resa_id, 'resa_contact_email', $_POST['resa_contact_email']);
        update_post_meta($resa_id, 'resa_contact_phone', $_POST['resa_contact_phone']);
        update_post_meta($resa_id, 'resa_auto', true);
      endif;
    endfor;

    require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/mails/mails_resa_stages.php');
  else:
    if(!fullinparkResaManager::is_resa_submited($_POST['resa_date'], $_POST['resa_hour'], $_POST['resa_contact_email'])):
      $resa_infos = array(
    	  'post_title'    => $_POST['resa_contact_fullname'].' - '.date('d/m/Y'),
    	  'post_content'  => '',
    	  'post_status'   => 'publish',
    	  'post_author'   => 1,
    	  'post_category' => array(),
    		'post_type'     => 'fip_resa',
    	);
    	$resa_id = wp_insert_post($resa_infos);


      if($_POST['resa_activity'] == "Coursep" OR $_POST['resa_activity'] == "Coursec"):
        if($_POST['resa_activity'] == "Coursec"):
          update_post_meta($resa_id, 'resa_activity', 'Course');
          update_post_meta($resa_id, 'resa_collective_course', true);
          update_post_meta($resa_id, 'resa_collective_course_choice', $_POST['resa_collective_course_choice']);
        else:
          update_post_meta($resa_id, 'resa_activity', 'Course');
          update_post_meta($resa_id, 'resa_private_course', true);
        endif;
      else:
        if($_POST['resa_activity'] == "Anniversary"):
          update_post_meta($resa_id, 'resa_activity', "Anniversaire");
          update_post_meta($resa_id, 'anniversary_jump_formula', $_POST['resa_anniversary_formula']);
          update_post_meta($resa_id, 'anniversary_kids_name', $_POST['resa_anniversary_kids_name']);
          update_post_meta($resa_id, 'anniversary_kids_age', $_POST['resa_anniversary_kids_age']);

          if($_POST['resa_anniversary_formula'] == 'FIPKids'):
            update_post_meta($resa_id, 'resa_anniversary_jump', false);
            update_post_meta($resa_id, 'resa_anniversary_kids', true);
          else:
            update_post_meta($resa_id, 'resa_anniversary_jump', true);
            update_post_meta($resa_id, 'resa_anniversary_kids', false);
          endif;

          $food_formula = $_POST['resa_anniversary_food_formula'];
          if($food_formula == 'anniversary_sweetandsalty'):
            update_post_meta($resa_id, 'resa_anniversary_formula_sweetandsalty', true);
            update_post_meta($resa_id, 'resa_anniversary_formula_salty', false);
            update_post_meta($resa_id, 'resa_anniversary_formula_sweet', false);
          elseif($food_formula == 'anniversary_salty'):
            update_post_meta($resa_id, 'resa_anniversary_formula_sweetandsalty', false);
            update_post_meta($resa_id, 'resa_anniversary_formula_salty', true);
            update_post_meta($resa_id, 'resa_anniversary_formula_sweet', false);
          else:
            update_post_meta($resa_id, 'resa_anniversary_formula_sweetandsalty', false);
            update_post_meta($resa_id, 'resa_anniversary_formula_salty', false);
            update_post_meta($resa_id, 'resa_anniversary_formula_sweet', true);
          endif;

          update_post_meta($resa_id, 'resa_anniversary_cake', $_POST['resa_anniversary_cake_choice']);
        endif;
      endif;

      if($_POST['resa_activity'] == "Jump"):
        update_post_meta($resa_id, 'resa_activity', 'Jump');
      endif;

      update_post_meta($resa_id, 'resa_jump', $_POST['resa_jump']);
      update_post_meta($resa_id, 'resa_kids', $_POST['resa_kids']);
      update_post_meta($resa_id, 'resa_date', $_POST['resa_date']);
      update_post_meta($resa_id, 'resa_duration', $_POST['resa_duration']);
      update_post_meta($resa_id, 'resa_hour', $_POST['resa_hour']);
      update_post_meta($resa_id, 'resa_riders', $_POST['resa_riders']);

      //Contact infos
      update_post_meta($resa_id, 'resa_contact_fullname', $_POST['resa_contact_fullname']);
      update_post_meta($resa_id, 'resa_contact_email', $_POST['resa_contact_email']);
      update_post_meta($resa_id, 'resa_contact_phone', $_POST['resa_contact_phone']);
      update_post_meta($resa_id, 'resa_auto', true);

      if($_POST['resa_activity'] == "Anniversary"):
        require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/mails/mails_resa_anniversary.php');
      elseif($_POST['resa_activity'] == "Coursep"):
        require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/mails/mails_resa_private_course.php');
      else:
        require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/mails/mails_resa.php');
      endif;
    endif;
  endif;
endif;

//Register Question
if(isset($_POST['question_sent'])):
  global $wpdb;
  $submitted = false;

  $last_question = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'fip_question' AND post_status != 'trash' ORDER BY post_date DESC LIMIT 1 ");

  $question_id = $last_question[0]->ID;
  $question_email = get_post_meta($question_id, 'email', true);

  if($question_name == $_POST['question_email']):
    $submitted = true;
  endif;

  if(!$submitted):
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

    require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/mails/mails_question.php');
  endif;
endif;

//Register Structure
if(isset($_POST['structure_sent'])):
  $structure_infos = array(
	  'post_title'    => $_POST['structure_fullname'].' - '.date('d/m/Y'),
	  'post_content'  => '',
	  'post_status'   => 'publish',
	  'post_author'   => 1,
	  'post_category' => array(),
		'post_type'     => 'fip_structure',
	);

  $structure_id = wp_insert_post($structure_infos);

  update_post_meta($structure_id, 'adress', $_POST['structure_adresse']);
  update_post_meta($structure_id, 'town', $_POST['structure_adresse']);
  update_post_meta($structure_id, 'zipcode', $_POST['structure_adresse']);
  update_post_meta($structure_id, 'date', $_POST['structure_date']);
  update_post_meta($structure_id, 'start_hour', $_POST['structure_start_hour']);
  update_post_meta($structure_id, 'end_hour', $_POST['structure_end_hour']);
  update_post_meta($structure_id, 'participants', $_POST['structure_participants']);
  update_post_meta($structure_id, 'accompany', $_POST['structure_accompany']);
  update_post_meta($structure_id, 'duration', $_POST['structure_duration']);
  update_post_meta($structure_id, 'email', $_POST['structure_email']);
  update_post_meta($structure_id, 'phone', $_POST['structure_phone']);
  update_post_meta($structure_id, 'divers', $_POST['structure_divers']);

  require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/mails/mails_structures.php');
endif;
?>

<div id="fullinpark_resa_container">
  <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/entete.php'); ?>

  <div id="fullinpark_resa_form_container">
    <div id="fullinpark_resa_form_content">
      <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/call_to_action.php'); ?>
      <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/activities.php'); ?>
      <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/courses.php'); ?>
      <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/stages.php'); ?>
      <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/anniversary.php'); ?>
      <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/offers.php'); ?>
      <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/riders.php'); ?>
      <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/recap.php'); ?>
      <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/stagerecap.php'); ?>

      <div id="resa_form_submit_button">
        <a class="next_step" onclick="go_to_step2();">Valider</a>
        <a href="<?php echo esc_url(home_url()).'/modifier-ma-reservation/'; ?>" id="update_resa_button">Modifier ma reservation</a>
      </div>
    </div>

    <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/step2.php'); ?>
    <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/question.php'); ?>
    <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/structure.php'); ?>
  </div> <!-- #fullinpark_resa_form_container -->

  <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/datepicker.php'); ?>
  <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/stagepicker.php'); ?>
  <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/riders_recap.php'); ?>
  <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/errors.php'); ?>

  <form action="#" method="POST" id="fullinpark_resa_form">
    <!-- Réservation infos -->
    <input type="hidden" name="resa_activity" id="resa_activity"/>
    <input type="hidden" name="resa_jump" id="resa_jump"/>
    <input type="hidden" name="resa_kids" id="resa_kids"/>
    <input type="hidden" name="resa_date" id="resa_date"/>
    <input type="hidden" name="resa_hour" id="resa_hour"/>
    <input type="hidden" name="resa_duration" id="resa_duration"/>
    <input type="hidden" name="resa_riders" id="resa_riders"/>
    <input type="hidden" name="resa_collective_course_choice" id="resa_collective_course_choice"/>
    <input type="hidden" name="resa_stage_choice" id="resa_stage_choice"/>
    <input type="hidden" name="resa_anniversary_formula" id="resa_anniversary_formula"/>
    <input type="hidden" name="resa_anniversary_food_formula" id="resa_anniversary_food_formula"/>
    <input type="hidden" name="resa_anniversary_kids_name" id="resa_anniversary_kids_name"/>
    <input type="hidden" name="resa_anniversary_kids_age" id="resa_anniversary_kids_age"/>
    <input type="hidden" name="resa_anniversary_cake_choice" id="resa_anniversary_cake_choice"/>

    <!-- Contact -->
    <input type="hidden" name="resa_contact_fullname" id="resa_contact_fullname"/>
    <input type="hidden" name="resa_contact_email" id="resa_contact_email"/>
    <input type="hidden" name="resa_contact_phone" id="resa_contact_phone" />

    <input type="hidden" name="resa_sent" value="sent"/>
  </form><!-- #fullinpark_resa_form -->

  <script>
    if(window.history.replaceState){  window.history.replaceState( null, null, window.location.href );  }
  </script>

  <?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/infobulles.php'); ?>
</div><!-- #fullinpark_resa_container -->

<?php require(PLUGIN_FIP_DIRECTORY.'inc/shortcodes/resa/templates/popups.php'); ?>
