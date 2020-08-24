<?php
function is_border_time($time){
  $current_time = date('G:i', $time);

  if($current_time == '12:00' OR $current_time == '13:30' OR $current_time == '17:30'):
    return true;
  endif;

  return false;
}

function get_resa_info($resa_id, $section, $activity){
  $anniversary_infos = '';

  if($activity == 'anniversaire'):
    if(get_post_meta($resa_id, 'resa_anniversary_formula_sweetandsalty', true)):
      $formula = 'Sucré + Salé';
    elseif(get_post_meta($resa_id, 'resa_anniversary_formula_salty', true)):
      $formula = 'Salé';
    else:
      $formula = 'Sucré';
    endif;

    $salle_name = array(
      's1' => 'Salle 1',
      's2' => 'Salle 2',
      's3' => 'Salle 3',
      's4' => 'Salle 4',
      's5' => 'Salle 5',
      's6' => 'Salle 6',
    );

    $anniversary_infos = '
      <p>
        <span>Roi de la fête:</span>
        <span>'.get_post_meta($resa_id, 'anniversary_kids_name', true).'<span>
      </p>

      <p>
        <span>Formule:</span>
        <span>'.get_post_meta($resa_id, 'anniversary_jump_formula', true).'<span>
      </p>

      <p>
        <span>Formule (repas):</span>
        <span>'.$formula.'<span>
      </p>';

    $time_info='
      <p>
        <span>Heure de départ:</span>
        <span>'.get_post_meta($resa_id, 'resa_hour', true).'<span>
      </p>

      <p>
        <span>Salle:</span>
        <span>'.$salle_name[get_post_meta($resa_id, 'anniversary_place', true)].'<span>
      </p>';
  else:
    $time_info='
      <p>
        <span>Durée:</span>
        <span>'.get_post_meta($resa_id, 'resa_duration', true).'<span>
      </p>';
  endif;

  return '
    <p>
      <span>Nom complet:</span>
      <span>'.get_post_meta($resa_id, 'resa_contact_fullname', true).'<span>
    </p>

    <p>
      <span>Email:</span>
      <span>'.get_post_meta($resa_id, 'resa_contact_email', true).'<span>
    </p>

    <p>
      <span>Téléphone:</span>
      <span>'.get_post_meta($resa_id, 'resa_contact_phone', true).'<span>
    </p>

    '.$time_info.'

    <p>
      <span>Entrée(s):</span>
      <span>'.get_post_meta($resa_id, "resa_$section", true).' '.$section.'<span>
    </p>

    '.$anniversary_infos.'
  ';
}

function get_popup($today_resa, $section, $activity, $hour, $extra = ''){
  $activities = array(
    "jump" =>  "Jump",
    "structure" => "Structure",
    "anniversaire" => "Anniversaire",
    "stage" => "Stage",
    "course" => "Course",
    "other" => "Other"
  );

  $day = intval(24*3600);
  $current_day = date('Y-m-d');

  if(isset($_GET['day'])):
    $current_day = date('Y-m-d', (strtotime($current_day) + (intval($_GET['day']) * $day)));
  endif;

  $duration_coef = array(
    '0:30' => 0.5,
    '1:00' => 1,
    '1:30' => 1.5,
    '2:00' => 2,
    '2:30' => 2.5,
    '3:00' => 3,
    '3:30' => 3.5,
    '4:00' => 4,
    '4:30' => 4.5,
    '5:00' => 5,
  );
  $popup_id = "'#fullinpark_planning_elem_popup_".$section."_".$activity."_".$hour.$extra."'";
  $list_resa = '';

  if($section == 'kids'):
    $section_label = "'kids'";
  else:
    $section_label = "'jump'";
  endif;

  foreach ($today_resa as $resa):
    $resa_hour = strtotime(get_post_meta($resa->ID, 'resa_hour', true));
    $resa_duration = $resa_hour + ($duration_coef[get_post_meta($resa->ID, 'resa_duration', true)] * 3600);

    if($hour >= $resa_hour AND $hour < $resa_duration):
      if(!empty(get_post_meta($resa->ID, 'resa_'.$section, true)) AND get_post_meta($resa->ID, 'resa_activity', true) == ucfirst($activity)):
        $anniversary_room = array(
          "s1" => "Salle 1",
          "s2" => "Salle 2",
          "s3" => "Salle 3",
          "s4" => "Salle 4",
          "s5" => "Salle 5",
          "s6" => "Salle 6"
        );

        $extra_class = '';
        $extra_infos = '';

        if($activity == 'anniversaire'):
          if(!empty(get_post_meta($resa->ID, 'anniversary_statement', true))):
            $extra_class = 'class="'.get_post_meta($resa->ID, 'anniversary_statement', true).'"';
          else:
            $extra_class = 'class="booked"';
          endif;

          if(!empty(get_post_meta($resa->ID, 'anniversary_place', true))):
            $extra_infos = '('.$anniversary_room[get_post_meta($resa->ID, 'anniversary_place', true)].')';
          else:
            $extra_infos = '(N/A)';
          endif;

          if(get_post_meta($resa->ID, 'resa_anniversary_formula_sweet', true)):
            $formula = 'Sucrée';
          endif;

          if(get_post_meta($resa->ID, 'resa_anniversary_formula_salty', true)):
            $formula = 'Salée';
          endif;

          if(get_post_meta($resa->ID, 'resa_anniversary_formula_sweetandsalty', true)):
            $formula = 'Sucrée + Salée';
          endif;
        endif;

        if($activity == 'structure'):
          $extra_infos = '(Formule '.get_post_meta($resa->ID, 'structure_formula_choice', true).')';

          if(!empty(get_post_meta($resa->ID, 'structure_statement', true))):
            $extra_class = 'class="'.get_post_meta($resa->ID, 'structure_statement', true).'"';
          else:
            $extra_class = 'class="booked"';
          endif;
        endif;

        if($activity == 'stage'):
          $stagiaire_names = '';

          for($i=1; $i <= get_post_meta($resa->ID, 'resa_jump', true); $i++):
            if(get_post_meta($resa->ID, 'stagiaire'.$i.'_lastname', true) == ''):
              $stagiaire_names = get_post_meta($resa->ID, 'resa_contact_fullname', true);
              break;
            endif;

            $stagiaire_names .= get_post_meta($resa->ID, 'stagiaire'.$i.'_lastname', true).' '.get_post_meta($resa->ID, 'stagiaire'.$i.'_firstname', true).' '.get_post_meta($resa->ID, 'stagiaire'.$i.'_age', true).'ans';

            if($i != get_post_meta($resa->ID, 'resa_jump', true)):
              $stagiaire_names .= ' / ';
            endif;
          endfor;

          if(!empty(get_post_meta($resa->ID, 'stage_statement', true))):
            $extra_class = 'class="'.get_post_meta($resa->ID, 'stage_statement', true).'"';
          else:
            $extra_class = 'class="booked"';
          endif;
        endif;

        if($activity == 'anniversaire' AND $section == 'kids'):
          $items_title = '<a onclick="show_user_infos(this);" '.$extra_class.'>'.get_post_meta($resa->ID, 'anniversary_kids_name', true).'('.get_post_meta($resa->ID, 'resa_'.$section, true).') '.get_post_meta($resa->ID, 'anniversary_jump_formula', true).' - '.$formula.' '.$extra_infos.' '.((fullinparkResaWarningManager::is_kids_warning($today_resa, $hour, $resa->ID)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning.png"/>' : '').''.((fullinparkResaWarningManager::is_kids_not_arrived($today_resa, $hour, $resa->ID)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning_not_arrived.png"/>' : '').'</a>';
        elseif($activity == 'anniversaire'):
          $items_title = '<a onclick="show_user_infos(this);" '.$extra_class.'>'.get_post_meta($resa->ID, 'anniversary_kids_name', true).'('.get_post_meta($resa->ID, 'resa_'.$section, true).') '.get_post_meta($resa->ID, 'anniversary_jump_formula', true).' - '.$formula.' '.$extra_infos.' '.((fullinparkResaWarningManager::is_warning($today_resa, $hour, $resa->ID)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning.png"/>' : '').''.((fullinparkResaWarningManager::is_not_arrived($today_resa, $hour, $resa->ID)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning_not_arrived.png"/>' : '').'</a>';
        elseif($section == 'kids'):
          $items_title = '<a onclick="show_user_infos(this);" '.$extra_class.'>'.get_post_meta($resa->ID, 'resa_contact_fullname', true).' - '.get_post_meta($resa->ID, 'resa_'.$section, true).' entrée(s) '.$section.' '.$extra_infos.' '.((fullinparkResaWarningManager::is_kids_warning($today_resa, $hour, $resa->ID)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning.png"/>' : '').''.((fullinparkResaWarningManager::is_kids_not_arrived($today_resa, $hour, $resa->ID)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning_not_arrived.png"/>' : '').'</a>';
        elseif($activity == 'stage'):
          $items_title = '<a onclick="show_user_infos(this);" '.$extra_class.'>'.$stagiaire_names.' - '.get_post_meta($resa->ID, 'resa_'.$section, true).' entrée(s) '.$section.' '.$extra_infos.' '.((fullinparkResaWarningManager::is_warning($today_resa, $hour, $resa->ID)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning.png"/>' : '').''.((fullinparkResaWarningManager::is_not_arrived($today_resa, $hour, $resa->ID)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning_not_arrived.png"/>' : '').'</a>';
        else:
          $items_title = '<a onclick="show_user_infos(this);" '.$extra_class.'>'.get_post_meta($resa->ID, 'resa_contact_fullname', true).' - '.get_post_meta($resa->ID, 'resa_'.$section, true).' entrée(s) '.$section.' '.$extra_infos.' '.((fullinparkResaWarningManager::is_warning($today_resa, $hour, $resa->ID)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning.png"/>' : '').''.((fullinparkResaWarningManager::is_not_arrived($today_resa, $hour, $resa->ID)) ? '<img style="width: 20px; height: 20px;" src="'.PLUGIN_FIP_URL.'/fullinpark/img/warning_not_arrived.png"/>' : '').'</a>';
        endif;

        if($extra == 'c1' AND fullinparkResaAnniversaryManager::anniversary_is_c1(get_post_meta($resa->ID, 'resa_hour', true))):
          $list_resa .= '
          <li data-name="'.get_post_meta($resa->ID, 'resa_contact_fullname', true).'">
            '.$items_title.'
            <div class="popup_user_infos">
              <a onclick="hide_user_infos(this);"><img src="'.PLUGIN_FIP_URL.'/fullinpark/img/left-arrow-blue.png"/></a>
              <p class="user_infos_title">Réservation #'.$resa->ID.'</p>
              <div class="user_info_content">'.get_resa_info($resa->ID, $section, $activity).'</div>

              <div class="resa_real_accompt">
                <div><label>Arrivée:</label><input type="number" id="resa_arrived_'.$section.'_'.$resa->ID.'_'.$hour.'" min="0" value="'.(($section == 'kids') ? get_post_meta($resa->ID, 'kids_arrived', true) : get_post_meta($resa->ID, 'people_arrived', true)).'"/></div>
                <div><label>Sortie:</label><input type="number" id="resa_out_'.$section.'_'.$resa->ID.'_'.$hour.'" min="0" value="'.(($section == 'kids') ? get_post_meta($resa->ID, 'kids_out', true) : get_post_meta($resa->ID, 'people_out', true)).'"/></div>
              </div>
              <textarea id="resa_notes_'.$resa->ID.'_'.$hour.'">'.get_post_meta($resa->ID, 'resa_notes', true).'</textarea>

              <div class="popup_user_infos_buttons">
                <a class="popup_modify_button" onclick="register_resa_extra_infos('.$resa->ID.', '.$section_label.', '.$hour.');">Mettre à jour le Compteur</a>
                <a class="popup_modify_button" href="'.get_edit_post_link($resa->ID).'" target="_blank">Modifier la réservation</a>
              </div>
            </div>
          </li>';
        elseif($extra == 'c2' AND fullinparkResaAnniversaryManager::anniversary_is_c2(get_post_meta($resa->ID, 'resa_hour', true))):
          $list_resa .= '
          <li data-name="'.get_post_meta($resa->ID, 'resa_contact_fullname', true).'">
            '.$items_title.'
            <div class="popup_user_infos">
              <a onclick="hide_user_infos(this);"><img src="'.PLUGIN_FIP_URL.'/fullinpark/img/left-arrow-blue.png"/></a>
              <p class="user_infos_title">Réservation #'.$resa->ID.'</p>
              <div class="user_info_content">'.get_resa_info($resa->ID, $section, $activity).'</div>

              <div class="resa_real_accompt">
                <div><label>Arrivée:</label><input type="number" id="resa_arrived_'.$section.'_'.$resa->ID.'_'.$hour.'" min="0" value="'.(($section == 'kids') ? get_post_meta($resa->ID, 'kids_arrived', true) : get_post_meta($resa->ID, 'people_arrived', true)).'"/></div>
                <div><label>Sortie:</label><input type="number" id="resa_out_'.$section.'_'.$resa->ID.'_'.$hour.'" min="0" value="'.(($section == 'kids') ? get_post_meta($resa->ID, 'kids_out', true) : get_post_meta($resa->ID, 'people_out', true)).'"/></div>
              </div>
              <textarea id="resa_notes_'.$resa->ID.'_'.$hour.'">'.get_post_meta($resa->ID, 'resa_notes', true).'</textarea>

              <div class="popup_user_infos_buttons">
                <a class="popup_modify_button" onclick="register_resa_extra_infos('.$resa->ID.', '.$section_label.', '.$hour.');">Mettre à jour le Compteur</a>
                <a class="popup_modify_button" href="'.get_edit_post_link($resa->ID).'" target="_blank">Modifier la réservation</a>
              </div>
            </div>
          </li>';
        elseif($extra == ''):
          $list_resa .= '
          <li data-name="'.get_post_meta($resa->ID, 'resa_contact_fullname', true).'">
            '.$items_title.'
            <div class="popup_user_infos">
              <a onclick="hide_user_infos(this);"><img src="'.PLUGIN_FIP_URL.'/fullinpark/img/left-arrow-blue.png"/></a>
              <p class="user_infos_title">Réservation #'.$resa->ID.'</p>
              <div class="user_info_content">'.get_resa_info($resa->ID, $section, $activity).'</div>

              <div class="resa_real_accompt">
                <div><label>Arrivée:</label><input type="number" id="resa_arrived_'.$section.'_'.$resa->ID.'_'.$hour.'" min="0" value="'.(($section == 'kids') ? get_post_meta($resa->ID, 'kids_arrived', true) : get_post_meta($resa->ID, 'people_arrived', true)).'"/></div>
                <div><label>Sortie:</label><input type="number" id="resa_out_'.$section.'_'.$resa->ID.'_'.$hour.'" min="0" value="'.(($section == 'kids') ? get_post_meta($resa->ID, 'kids_out', true) : get_post_meta($resa->ID, 'people_out', true)).'"/></div>
              </div>
              <textarea id="resa_notes_'.$resa->ID.'_'.$hour.'">'.get_post_meta($resa->ID, 'resa_notes', true).'</textarea>

              <div class="popup_user_infos_buttons">
                <a class="popup_modify_button" onclick="register_resa_extra_infos('.$resa->ID.', '.$section_label.', '.$hour.');">Mettre à jour le Compteur</a>
                <a class="popup_modify_button" href="'.get_edit_post_link($resa->ID).'" target="_blank">Modifier la réservation</a>
              </div>
            </div>
          </li>';
        endif;
      endif;
    endif;
  endforeach;

  return '
  <div id="fullinpark_planning_elem_popup_'.$section.'_'.$activity.'_'.$hour.$extra.'" class="fullinpark_planning_elem_popup">
    <div class="fullinpark_planning_elem_popup_content">
      <a class="hide_resa_popup_button" onclick="hide_resa_popup('.$popup_id.')"><img src="'.PLUGIN_FIP_URL.'/fullinpark/img/delete-blue.png"/></a>
      <p class="fullinpark_planning_elem_popup_title">Liste des reservations:</p>
      <ul class="resa_listing">'.$list_resa.'</ul>

      <a href="'.esc_url(home_url()).'/wp-admin/post-new.php?post_type=fip_resa&activity='.$activities[$activity].'&date='.$current_day.'&hour='.$hour.'" class="add_resa_button">Ajouter une réservation</a>
    </div>
  </div>';
}
