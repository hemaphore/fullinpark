<div id="fullinpark_resa_form_offers">
  <p class="secondary_title" id="offer_title">NOS OFFRES</p>

  <div class="grey_container">
    <div id="all_tickets_details">
      <div id="tickets_kids" class="tickets_infos_container">
        <p class="tickets_infos_title">Kids (1 à 5ans)</p>

        <div class="tickets_infos_content">
          <a class="resa_minus" id="resa_kids_remove" onclick="remove_ticket('kids', 0);">-</a>
          <p id="ticket_number_kids" class="resa_number">0</p>
          <a class="resa_add" id="resa_kids_add" onclick="add_ticket('kids', <?php echo get_option('max_kids_resa'); ?>);">+</a>
        </div>
      </div>

      <div id="tickets_jump" class="tickets_infos_container">
        <p class="tickets_infos_title">Jump (6 à 77ans)</p>

        <div class="tickets_infos_content">
          <a class="resa_minus" id="resa_jump_remove" onclick="remove_ticket('jump', 0);">-</a>
          <p id="ticket_number_jump" class="resa_number">0</p>
          <a class="resa_add" id="resa_jump_add" onclick="add_ticket('jump', <?php echo get_option('max_jump_resa'); ?>);">+</a>
        </div>
      </div>

      <div id="tickets_details_anniversary" style="display: none;">
        <p>N'oubliez de prendre en compte le roi ou la reine de la fête.</p>

        <div class="anniversary_extra_infos">
          <label for="">Nom du roi ou de la reine de la fête:</label>
          <input type="text" name="anniversary_kids_name" id="anniversary_kids_name" onchange="update_kids_info();"/>
        </div>

        <div class="anniversary_extra_infos">
          <label for="">Age du roi ou de la reine de la fête:</label>
          <input type="text" name="anniversary_kids_age" id="anniversary_kids_age" onchange="check_formula(this);"/>
        </div>

        <div id="anniversary_cake_container" class="anniversary_extra_infos">
          <div class="checkbox_choice">
            <label><input type="checkbox" name="anniversary_cake_choco" class="extra_infos_checkbox" onchange="update_formula_extra_info(this);" data-cake="choco"/>Gâteau Chocolat</label>
          </div>

          <div class="checkbox_choice">
            <label><input type="checkbox" name="anniversary_cake_fraise" class="extra_infos_checkbox" onchange="update_formula_extra_info(this);" data-cake="fraise"/>Gâteau Fraise</label>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="stage_extra_infos_container">
    <p class="secondary_title">Informations stagiaire(s)</p>

    <div class="grey_container">
      <div id="stage_extra_infos">
        <div id="stagiaire1" class="stagiaire">
          <p>Stagiaire n°1</p>
          <input type="text" name="stagiaire1_lastname" id="stagiaire1_lastname" class="infos_require" data-error="Nom du stagiaire n°1" placeholder="Nom du stagiaire"/>
          <input type="text" name="stagiaire1_firstname" id="stagiaire1_firstname" class="infos_require" data-error="Prénom du stagiaire n°1" placeholder="Prénom du stagiaire"/>
          <input type="text" name="stagiaire1_age" id="stagiaire1_age" class="infos_require" data-error="Âge du stagiaire n°1" placeholder="Âge du stagiaire (6ans minimum)"/>
        </div>
      </div>
    </div>
  </div>
</div><!-- #fullinpark_resa_form_offers -->
