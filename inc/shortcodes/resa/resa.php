<!-- <div style="width:37%; "> -->
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
        <div class="custom_select">
          <a id="toogle_activities_button" onclick="toogle_activities();">
            <p class="custom_select_default">Choisis <span class="blue bold">ton activité</span></p>
            <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-blue.png'; ?> "/>
          </a>

          <div id="custom_select_activities">
            <ul>
              <li>Jump</li>
              <li>Anniversaire</li>
              <li>Stage</li>
            </ul>
          </div>
        </div>
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
        <a onclick="show_datepicker();">
          <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/picto-calendrier-FIP.png'; ?>"/>
          <p><span>Date</span> <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-blue.png'; ?> "/></p>
        </a>
      </div>

      <div class="date_hours_box">
        <a onclick="show_datepicker();">
          <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/picto-horloge-FIP.png'; ?>"/>
          <p><span>Heure</span> <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-blue.png'; ?>"/></p>
        </a>
      </div>

      <div id="datepicker_container">
        <a id="hide_datepicker" onclick="hide_datepicker();"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/delete-white.png'; ?> "/></a>
        <div id="datepicker"></div>
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
<!-- </div> -->
