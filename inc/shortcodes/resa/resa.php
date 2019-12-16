<div id="fullinpark_resa_form_container">
  <div id="fullinpark_resa_form_entete">
    <div id="fullinpark_resa_form_entete_resa_button">
      Réservations
    </div>

    <div id="fullinpark_resa_form_entete_question_button">
      <a href="#" target="_blank">Question ?</a>
    </div>
  </div>

  <div id="fullinpark_resa_form_content">
    <div>
      <p class="main_title">VOUS ÊTES: </p>

      <div class="grey_container">
        <p class="association_title">ASSOCIATIONS ENTREPRISES COLLECTIVITÉES </p>
        <a class="association_link">C'est par ici</a>
      </div>
    </div>

    <div>
      <p class="secondary_title">PARTICULIERS</p>

      <div class="grey_container">
        <p>Choisis <span class="blue bold">ton activité</span></p>
      </div>
    </div>

    <div>
      <p class="secondary_title">PARTICIPANTS</p>

      <div class="grey_container">
        <div id="all_tickets_details">
          <div class="tickets_infos_container">
            <p class="tickets_infos_title">Kids (1 à 5ans)</p>

            <div class="tickets_infos_content">
              <a class="resa_minus" onclick="remove_ticket('kids');">-</a>
              <p id="ticket_number_kids" class="resa_number">0</p>
              <a class="resa_add" onclick="add_ticket('kids');">+</a>
            </div>
          </div>

          <div class="tickets_infos_container">
            <p class="tickets_infos_title">Jump (6 à 77ans)</p>

            <div class="tickets_infos_content">
              <a class="resa_minus" onclick="remove_ticket('jump');">-</a>
              <p id="ticket_number_jump" class="resa_number">0</p>
              <a class="resa_add" onclick="add_ticket('jump');">+</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="date_hours_container">
      <div class="date_hours_box">
        <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/picto-calendrier-FIP.png'; ?>"/>
        <p><a>Date</a></p>
      </div>

      <div class="date_hours_box">
        <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/picto-horloge-FIP.png'; ?>"/>
        <p><a>Heure</a></p>
      </div>
    </div>

    <form action="#" method="POST">
      <input type="hidden" id="activity" name="activity"/>

      <div id="resa_form_submit_button">
        <button>Réserver</button>
        <a href="#" id="update_resa_button">Modifier ma reservation</a>
      </div>
    </form>
  </div>
</div>
