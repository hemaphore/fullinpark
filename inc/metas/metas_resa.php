<?php
function fip_resa_details_html(){
  global $post;

  if(!empty(get_post_meta($post->ID, 'resa_date', true)) AND get_post_meta($post->ID, 'resa_date', true) != '1970-01-01'):
    $date_value = date('d/m/Y', strtotime(get_post_meta($post->ID, 'resa_date', true)));
  else:
    $date_value = 'jj/mm/AAAA';
  endif;  ?>

  <div id="fip_resa_details">
    <p>
      <span>Type:</span>
      <span>
        <select name="edit_resa_activity" id="edit_resa_activity" onchange="switch_extra_infos_content(this);">
          <option value="Jump">Entrée standard</option>
          <option value="Structure">Structure</option>
          <option value="Anniversaire">Anniversaire</option>
          <option value="Stage">Stage</option>
          <option value="Course">Cour privé/collectif</option>
          <option value="Other">Cas particulier</option>
        </select>

        <?php
        if(isset($_GET['activity'])): ?>
          <script>jQuery('#edit_resa_activity option[value="<?php echo $_GET['activity']; ?>"]').attr("selected", "selected");</script><?php
        else: ?>
          <script>jQuery('#edit_resa_activity option[value="<?php echo get_post_meta($post->ID, 'resa_activity', true); ?>"]').attr("selected", "selected");</script><?php
        endif; ?>
      </span>
    </p>
    <p><span>Jump:</span> <span><input type="text" name="edit_resa_jump" id="edit_resa_jump" value="<?php echo (!empty(get_post_meta($post->ID, 'resa_jump', true))) ? get_post_meta($post->ID, 'resa_jump', true) : '0'; ?>"/></span></p>
    <p><span>Kids:</span> <span><input type="text" name="edit_resa_kids" id="edit_resa_kids" value="<?php echo (!empty(get_post_meta($post->ID, 'resa_kids', true))) ? get_post_meta($post->ID, 'resa_kids', true) : '0'; ?>"/></span></p>
    <p><span>Date:</span> <span><input type="text" name="edit_resa_date" id="edit_resa_date" value="<?php echo (isset($_GET['date'])) ? date('d/m/Y', strtotime($_GET['date'])) : $date_value; ?>"/></span></p>
    <?php
    if($_GET['activity'] == "Anniversaire"): ?>
      <p><span>Durée:</span> <span><input type="text" name="edit_resa_duration" id="edit_resa_duration" value="2:00" disabled="disabled"/></span></p><?php
    elseif($_GET['activity'] == "Stage"): ?>
      <p><span>Durée:</span> <span><input type="text" name="edit_resa_duration" id="edit_resa_duration" value="3:00" disabled="disabled"/></span></p><?php
    else: ?>
      <p><span>Durée:</span> <span><input type="text" name="edit_resa_duration" id="edit_resa_duration" value="<?php echo get_post_meta($post->ID, 'resa_duration', true); ?>"/></span></p><?php
    endif; ?>
    <p><span>Heure:</span> <span><input type="text" name="edit_resa_hour" id="edit_resa_hour" value="<?php echo (isset($_GET['hour'])) ? date('G:i', $_GET['hour']) : get_post_meta($post->ID, 'resa_hour', true); ?>"/></span></p>
  </div>

  <input type="hidden" name="resa_noncename" id="resa_noncename" value="<?php echo wp_create_nonce(plugin_basename(__FILE__).$post->ID); ?>" /><?php
}

function fip_resa_extra_html(){
  global $wpdb;
  global $post; ?>

  <?php
  if(isset($_GET['activity'])): ?>
    <div id="course" class="extra_infos_container" <?php echo ($_GET['activity'] != "Course") ? 'style="display: none"' : '' ; ?>><?php
  else: ?>
    <div id="course" class="extra_infos_container" <?php echo (get_post_meta($post->ID, 'resa_activity', true) != "Course") ? 'style="display: none"' : '' ; ?>><?php
  endif; ?>
    <div class="checkbox_choice">
      <label><input type="checkbox" id="private_course" name="private_course" class="course_type" onchange="switch_course_type(this);" <?php echo (get_post_meta($post->ID, 'resa_private_course', true)) ? 'checked' : ''; ?>/> Privé</label>
      <label><input type="checkbox" id="collective_course" name="collective_course" class="course_type" onchange="switch_course_type(this);" <?php echo (get_post_meta($post->ID, 'resa_collective_course', true)) ? 'checked' : ''; ?>/>Collectif</label>
    </div>

    <div id="collective_course_container" <?php echo (!get_post_meta($post->ID, 'resa_collective_course', true)) ? 'style="display: none;"' : ''; ?>>
      <select id="collective_course_choice" name="collective_course_choice">
        <option selected disabled>Choisir un cour collectif</option>
        <option value="trampo">Trampoline</option>
        <option value="parkour">Parkour & Free Run</option>
        <option value="fitramp">Fit Tramp</option>
      </select>
    </div>
  </div>
  <script>jQuery('#collective_course_choice option[value="<?php echo get_post_meta($post->ID, 'resa_collective_course_choice', true); ?>"]').attr("selected", "selected");</script>

  <?php
  if(isset($_GET['activity'])): ?>
    <div id="structure" class="extra_infos_container" <?php echo ($_GET['activity'] != "Structure") ? 'style="display: none"' : '' ; ?>><?php
  else: ?>
    <div id="structure" class="extra_infos_container" <?php echo (get_post_meta($post->ID, 'resa_activity', true) != "Structure") ? 'style="display: none"' : '' ; ?>><?php
  endif; ?>
    <div id="structure_formula_container">
      <select id="structure_formula_choice" name="structure_formula_choice">
        <option selected disabled>Choisir une formule</option>
        <option value="Acrobate">Acrobate (cours avec coach)</option>
        <option value="Découverte">Découverte (accès libre)</option>
      </select>
    </div>
  </div>
  <script>jQuery('#structure_formula_choice option[value="<?php echo get_post_meta($post->ID, 'structure_formula_choice', true); ?>"]').attr("selected", "selected");</script>

  <?php
  if(isset($_GET['activity'])): ?>
    <div id="stage" class="extra_infos_container" <?php echo ($_GET['activity'] != "Stage") ? 'style="display: none"' : '' ; ?>><?php
  else: ?>
    <div id="stage" class="extra_infos_container" <?php echo (get_post_meta($post->ID, 'resa_activity', true) != "Stage") ? 'style="display: none"' : '' ; ?>><?php
  endif; ?>
    <select id="resa_stage_choice" name="resa_stage_choice">
      <?php
      $all_stages = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'fip_stage'");

      foreach ($all_stages as $stage):
        echo '<option value="'.$stage->ID.'">'.$stage->post_title.'</option>';
      endforeach; ?>
    </select>

    <div>
      <?php
      for ($i=1; $i <= get_post_meta($post->ID, 'resa_jump', true); $i++): ?>
        <div>
          <p style="font-weight: bold; text-decoration: underline;">Stagiaire n°<?php echo $i ?>:</p>
          <p><?php echo get_post_meta($post->ID, 'stagiaire'.$i.'_lastname', true); ?></p>
          <p><?php echo get_post_meta($post->ID, 'stagiaire'.$i.'_firstname', true); ?></p>
          <p><?php echo get_post_meta($post->ID, 'stagiaire'.$i.'_age', true); ?>ans</p>
        </div><?php
      endfor;?>
    </div>

  </div>
  <script>jQuery('#resa_stage_choice option[value="<?php echo get_post_meta($post->ID, 'resa_stage_choice', true); ?>"]').attr("selected", "selected");</script>

  <?php
  if(isset($_GET['activity'])): ?>
    <div id="anniversary" class="extra_infos_container" <?php echo ($_GET['activity'] != "Anniversaire") ? 'style="display: none"' : '' ; ?>><?php
  else: ?>
    <div id="anniversary" class="extra_infos_container" <?php echo (get_post_meta($post->ID, 'resa_activity', true) != "Anniversaire") ? 'style="display: none"' : '' ; ?>><?php
  endif; ?>
    <div class="checkbox_choice">
      <label><input type="checkbox" id="anniversary_fip" name="anniversary_fip" class="anniversary_type" onchange="switch_anniversary_type(this);" <?php echo (get_post_meta($post->ID, 'anniversary_jump_formula', true) == 'FIP') ? 'checked' : ''; ?>/>Formule Full In Party</label>
      <label><input type="checkbox" id="anniversary_fipplus" name="anniversary_fipplus" class="anniversary_type" onchange="switch_anniversary_type(this);" <?php echo (get_post_meta($post->ID, 'anniversary_jump_formula', true) == 'FIP+') ? 'checked' : ''; ?>/>Formule Full In Party +</label>
      <label><input type="checkbox" id="anniversary_fipprem" name="anniversary_fipprem" class="anniversary_type" onchange="switch_anniversary_type(this);" <?php echo (get_post_meta($post->ID, 'anniversary_jump_formula', true) == 'FIPprem') ? 'checked' : ''; ?>/>Formule Full In Party Premium</label>
      <label><input type="checkbox" id="anniversary_kids" name="anniversary_kids" class="anniversary_type" onchange="switch_anniversary_type(this);" <?php echo (get_post_meta($post->ID, 'anniversary_jump_formula', true) == 'FIPKids') ? 'checked' : ''; ?>/>Formule Full In Party Kids</label>
    </div>


    <div class="checkbox_choice">
      <label><input type="checkbox" id="anniversary_sweet" name="anniversary_sweet" class="anniversary_formula" onchange="switch_anniversary_formula(this);" <?php echo (get_post_meta($post->ID, 'resa_anniversary_formula_sweet', true)) ? 'checked' : ''; ?>/>Formule Sucrée</label>
      <label><input type="checkbox" id="anniversary_salty" name="anniversary_salty" class="anniversary_formula" onchange="switch_anniversary_formula(this);" <?php echo (get_post_meta($post->ID, 'resa_anniversary_formula_salty', true)) ? 'checked' : ''; ?>/>Formule Salée</label>
      <label><input type="checkbox" id="anniversary_sweetandsalty" name="anniversary_sweetandsalty" class="anniversary_formula" onchange="switch_anniversary_formula(this);" <?php echo (get_post_meta($post->ID, 'resa_anniversary_formula_sweetandsalty', true)) ? 'checked' : ''; ?>/>Formule Sucrée + Salée</label>
    </div>

    <div>
      <div style="margin: 10px 0;">
        <label>Nom du roi ou de la reine de la fête:</label>
        <input type="text" name="anniversary_kids_name" value="<?php echo get_post_meta($post->ID, 'anniversary_kids_name', true); ?>"/>
      </div>

      <div style="margin: 10px 0;">
        <label>Age du roi ou de la reine de la fête:</label>
        <input type="text" name="anniversary_kids_age" value="<?php echo get_post_meta($post->ID, 'anniversary_kids_age', true); ?>"/>
      </div>

      <div id="anniversary_cake_container" class="anniversary_extra_infos" style="display: flex; margin: 10px 0;">
        <div class="checkbox_choice" style="width: 50%;">
          <label><input type="checkbox" name="anniversary_cake_choco" class="extra_infos_checkbox" <?php echo (get_post_meta($post->ID, 'resa_anniversary_cake', true) == 'choco') ? 'checked' : ''; ?> />Gâteau Chocolat</label>
        </div>

        <div class="checkbox_choice" style="width: 50%;">
          <label><input type="checkbox" name="anniversary_cake_fraise" class="extra_infos_checkbox" <?php echo (get_post_meta($post->ID, 'resa_anniversary_cake', true) == 'fraise') ? 'checked' : ''; ?>/>Gâteau Fraise</label>
        </div>
      </div>
    </div>

    <div class="meta_select_container">
      <label>Salle:</label>

      <select id="anniversary_place" name="anniversary_place">
        <option disabled selected>Choisir une salle</option>
        <option value="s1">Salle 1</option>
        <option value="s2">Salle 2</option>
        <option value="s3">Salle 3</option>
        <option value="s4">Salle 4</option>
        <option value="s5">Salle 5</option>
        <option value="s6">Salle 6</option>
      </select>
    </div>

    <?php
    if(empty(get_post_meta($post->ID, 'anniversary_place', true))): ?>
      <p class="warning">Anniversaire non affecté à une salle !</p><?php
    endif; ?>
  </div>
  <script>jQuery('#anniversary_place option[value="<?php echo get_post_meta($post->ID, 'anniversary_place', true); ?>"]').attr("selected", "selected");</script><?php
}

function fip_resa_contact_html(){
  global $post; ?>

  <div id="fip_resa_contact_infos">
    <p><span>Nom complet:</span> <span><input type="text" name="edit_contact_fullname" id="edit_contact_fullname" value="<?php echo get_post_meta($post->ID, 'resa_contact_fullname', true); ?>"/></span></p>
    <p><span>Email:</span> <span><input type="text" name="edit_contact_email" id="edit_contact_email" value="<?php echo get_post_meta($post->ID, 'resa_contact_email', true); ?>"/></span></p>
    <p><span>Téléphone:</span> <span><input type="text" name="edit_contact_phone" id="edit_contact_phone" value="<?php echo get_post_meta($post->ID, 'resa_contact_phone', true); ?>"/></span></p>
  </div>
  <?php
}

function fip_resa_notes_html(){
  global $post; ?>

  <div id="resa_note_places">
    <div><label>Arrivés (Jump):</label> <input type="number" name="people_arrived" id="people_arrived" value="<?php echo get_post_meta($post->ID, 'people_arrived', true); ?>" min="0" max="<?php echo get_post_meta($post->ID, 'resa_jump', true); ?>"/></div>
    <div><label>Arrivés (Kids):</label> <input type="number" name="kids_arrived" id="kids_arrived" value="<?php echo get_post_meta($post->ID, 'kids_arrived', true); ?>" min="0" max="<?php echo get_post_meta($post->ID, 'resa_kids', true); ?>"/></div>

    <div><label>Sortis (Jump):</label> <input type="text" name="people_out" id="people_out" value="<?php echo get_post_meta($post->ID, 'people_out', true); ?>" min="0" max="<?php echo get_post_meta($post->ID, 'people_arrived', true); ?>"/></div>
    <div><label>Sortis (Kids):</label> <input type="text" name="kids_out" id="kids_out" value="<?php echo get_post_meta($post->ID, 'kids_out', true); ?>" min="0" max="<?php echo get_post_meta($post->ID, 'people_out', true); ?>"/></div>
  </div>

  <div id="resa_note_text">
    <textarea name="edit_notes"><?php echo get_post_meta($post->ID, 'resa_notes', true); ?></textarea>
  </div>
  <?php
}

function fip_resa_statement_html(){
  global $post; ?>

  <div id="resa_statement_anniversary_container">
    <select name="resa_statement_anniversary" id="resa_statement_anniversary" <?php echo (get_post_meta($post->ID, 'resa_activity', true) != "Anniversaire") ? 'style="display: none;"' : ''; ?>>
      <option value="booked">Réservation</option>
      <option value="paid">Accompte</option>
      <option value="confirmed">Confirmé</option>
    </select>

    <select name="resa_statement_stage" id="resa_statement_stage" <?php echo (get_post_meta($post->ID, 'resa_activity', true) != "Stage") ? 'style="display: none;"' : ''; ?>>
      <option value="booked">Réservation</option>
      <option value="confirmed">Confirmé</option>
    </select>

    <select name="resa_statement_structure" id="resa_statement_structure" <?php echo (get_post_meta($post->ID, 'resa_activity', true) != "Structure") ? 'style="display: none;"' : ''; ?>>
      <option value="booked">Réservation</option>
      <option value="confirmed">Devis validé</option>
    </select>
  </div>

  <script>jQuery('#resa_statement_anniversary option[value="<?php echo get_post_meta($post->ID, 'anniversary_statement', true); ?>"]').attr("selected", "selected");</script>
  <script>jQuery('#resa_statement_stage option[value="<?php echo get_post_meta($post->ID, 'stage_statement', true); ?>"]').attr("selected", "selected");</script>
  <script>jQuery('#resa_statement_structure option[value="<?php echo get_post_meta($post->ID, 'structure_statement', true); ?>"]').attr("selected", "selected");</script><?php
}

function wisdom_filter_tracked_plugins() {
  global $typenow;
  global $wp_query;
    if ( $typenow == 'fip_resa' ) { // Your custom post type slug
      $plugins = array('Jump', 'Stage', 'Anniversaire', 'Structure', 'Other' ); // Options for the filter select field
      $plugins_text = array(
        'Jump' => 'Entrée standard',
        'Stage' => 'Stage',
        'Anniversaire' => 'Anniversaire',
        'Structure' => 'Structure',
        'Other' => 'Cas particulier'
      );

      $current_plugin = '';
      if( isset( $_GET['slug'] ) ) {
        $current_plugin = $_GET['slug']; // Check if option has been selected
      } ?>
      <select name="slug" id="slug">
        <option value="all" <?php selected( 'all', $current_plugin ); ?>><?php _e( 'Tous', 'FIP' ); ?></option>
        <?php foreach( $plugins as $value ) { ?>
          <option value="<?php echo $value; ?>" <?php selected( $value, $current_plugin ); ?>><?php echo $plugins_text[$value]; ?></option>
        <?php } ?>
      </select>
  <?php }
}
add_action( 'restrict_manage_posts', 'wisdom_filter_tracked_plugins' );

function wisdom_sort_plugins_by_slug( $query ) {
  global $pagenow;
  // Get the post type
  $post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
  if ( is_admin() && $pagenow=='edit.php' && $post_type == 'fip_resa' && isset( $_GET['slug'] ) && $_GET['slug'] !='all' ) {
    $query->query_vars['meta_key'] = 'resa_activity';
    $query->query_vars['meta_value'] = $_GET['slug'];
    $query->query_vars['meta_compare'] = '=';
  }
}
add_filter( 'parse_query', 'wisdom_sort_plugins_by_slug' );

if(!function_exists('save_fip_resa_infos')):
  function save_fip_resa_infos($post_id, $post, $update){
    if(!wp_verify_nonce($_POST['resa_noncename'], plugin_basename(__FILE__).$post->ID)):
      return $post->ID;
    endif;

    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE):
      return $post_id;
    endif;

    if(defined('DOING_AJAX')):
      return;
    endif;

    if(!current_user_can('edit_post')):
      return $post->ID;
    endif;

    if($post->post_type == 'revision'):
      return;
    endif;

    //Résa
    update_post_meta($resa_id, 'resa_auto', false);
    update_post_meta($post_id, 'resa_activity', @$_POST['edit_resa_activity']);
    update_post_meta($post_id, 'resa_jump', @$_POST['edit_resa_jump']);
    update_post_meta($post_id, 'resa_kids', @$_POST['edit_resa_kids']);
    update_post_meta($post_id, 'resa_date', date('Y-m-d', strtotime(fullinparkResaManager::convertDateFormat(@$_POST['edit_resa_date']))));
    update_post_meta($post_id, 'resa_duration', date('G:i', strtotime(@$_POST['edit_resa_duration'])));
    update_post_meta($post_id, 'resa_hour', date('G:i', strtotime(@$_POST['edit_resa_hour'])));

    //Extra infos Course
    if(isset($_POST['private_course'])):
      update_post_meta($post_id, 'resa_private_course', true);
    else:
      update_post_meta($post_id, 'resa_private_course', false);
    endif;

    if(isset($_POST['collective_course'])):
      update_post_meta($post_id, 'resa_collective_course', true);
    else:
      update_post_meta($post_id, 'resa_collective_course', false);
    endif;

    update_post_meta($post_id, 'resa_collective_course_choice', @$_POST['collective_course_choice']);

    //Extra infos Structure
    update_post_meta($post_id, 'structure_formula_choice', @$_POST['structure_formula_choice']);

    //Extra infos Stage
    update_post_meta($post_id, 'resa_stage_choice', @$_POST['resa_stage_choice']);

    //Extra infos Anniverssaire
    if(isset($_POST['anniversary_fip'])):
      update_post_meta($post_id, 'anniversary_jump_formula', 'FIP');
    endif;

    if(isset($_POST['anniversary_fipplus'])):
      update_post_meta($post_id, 'anniversary_jump_formula', 'FIP+');
    endif;

    if(isset($_POST['anniversary_fipprem'])):
      update_post_meta($post_id, 'anniversary_jump_formula', 'FIPprem');
    endif;

    if(isset($_POST['anniversary_kids'])):
      update_post_meta($post_id, 'anniversary_jump_formula', 'FIPKids');
    endif;

    if(isset($_POST['anniversary_sweet'])):
      update_post_meta($post_id, 'resa_anniversary_formula_sweet', true);
    else:
      update_post_meta($post_id, 'resa_anniversary_formula_sweet', false);
    endif;

    if(isset($_POST['anniversary_salty'])):
      update_post_meta($post_id, 'resa_anniversary_formula_salty', true);
    else:
      update_post_meta($post_id, 'resa_anniversary_formula_salty', false);
    endif;

    if(isset($_POST['anniversary_sweetandsalty'])):
      update_post_meta($post_id, 'resa_anniversary_formula_sweetandsalty', true);
    else:
      update_post_meta($post_id, 'resa_anniversary_formula_sweetandsalty', false);
    endif;

    update_post_meta($post_id, 'anniversary_place', @$_POST['anniversary_place']);
    update_post_meta($post_id, 'anniversary_kids_age', @$_POST['anniversary_kids_age']);
    update_post_meta($post_id, 'anniversary_kids_name', @$_POST['anniversary_kids_name']);

    if(isset($_POST['anniversary_cake_fraise'])):
      update_post_meta($post_id, 'resa_anniversary_cake', 'fraise');
    endif;

    if(isset($_POST['anniversary_cake_choco'])):
      update_post_meta($post_id, 'resa_anniversary_cake', 'choco');
    endif;

    //Statement
    update_post_meta($post_id, 'anniversary_statement', @$_POST['resa_statement_anniversary']);
    update_post_meta($post_id, 'structure_statement', @$_POST['resa_statement_structure']);
    update_post_meta($post_id, 'stage_statement', @$_POST['resa_statement_stage']);


    //Contact
    if(empty(@$_POST['edit_contact_fullname']) AND get_the_title($post_id) != 'Brouillon auto'):
      update_post_meta($post_id, 'resa_contact_fullname', get_the_title($post_id));
    else:
      update_post_meta($post_id, 'resa_contact_fullname', @$_POST['edit_contact_fullname']);
    endif;

    update_post_meta($post_id, 'resa_contact_email', @$_POST['edit_contact_email']);
    update_post_meta($post_id, 'resa_contact_phone', @$_POST['edit_contact_phone']);

    //Notes
    update_post_meta($post_id, 'resa_notes', @$_POST['edit_notes']);
    update_post_meta($post_id, 'people_arrived', @$_POST['people_arrived']);
    update_post_meta($post_id, 'kids_arrived', @$_POST['kids_arrived']);
    update_post_meta($post_id, 'people_out', @$_POST['people_out']);
    update_post_meta($post_id, 'kids_out', @$_POST['kids_out']);
  }
endif;
add_action('save_post', 'save_fip_resa_infos', 10, 3);

function add_fullinpark_resa_acf_columns ( $columns ) {
  unset($columns['date']);

  return array_merge ($columns, array(
   'resa_id' => __ ( 'N° Résa' ),
   'resa_type' => __ ( 'Activité' ),
   'resa_date' => __ ( 'Date - Heure' ),
   'resa_duration' => __ ( 'Durée' ),
   'resa_jump' => __ ( 'Jump' ),
   'resa_kids' => __ ( 'Kids' )
 ));
}
add_filter ( 'manage_edit-fip_resa_columns', 'add_fullinpark_resa_acf_columns' );

function fullinpark_resa_custom_column ($column, $post_id){
  $resa_type_label = array(
    "Jump" => "Entrée standard",
    "Structure" => "Structure",
    "Anniversaire" => "Anniversaire",
    "Stage" => "Stage",
    "Course" => "Cour",
    "Other" => "Cas particulier"
  );

   switch($column):
     case 'resa_id':
       if(get_post_meta($post_id, 'resa_auto', true)):
         echo '#'.$post_id.' (automatique)';
       else:
         echo '#'.$post_id.' (manuelle / modifiée)';
       endif;
       break;
     case 'resa_type':
       if(get_post_meta($post_id, 'resa_activity', true) == "Course"):
         if(get_post_meta($post_id, 'resa_collective_course', true)):
           echo $resa_type_label[get_post_meta($post_id, 'resa_activity', true)].' Collectif';
         else:
           echo $resa_type_label[get_post_meta($post_id, 'resa_activity', true)].' Privé';
         endif;
       else:
         echo $resa_type_label[get_post_meta($post_id, 'resa_activity', true)];
       endif;
       break;
     case 'resa_date':
       echo date('d/m/Y', strtotime(get_post_meta($post_id, 'resa_date', true))).' - '.get_post_meta($post_id, 'resa_hour', true);
       break;
     case 'resa_duration':
       echo get_post_meta($post_id, 'resa_duration', true);
       break;
     case 'resa_jump':
       echo get_post_meta($post_id, 'resa_jump', true);
       break;
     case 'resa_kids':
       echo get_post_meta($post_id, 'resa_kids', true);
       break;
     default:
       break;
   endswitch;
}
add_action ('manage_fip_resa_posts_custom_column', 'fullinpark_resa_custom_column', 10, 2);
