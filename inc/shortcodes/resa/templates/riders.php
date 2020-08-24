<div id="riders_container">
  <p class="secondary_title">Location matériels "Riders"</p>

  <div class="grey_container">
    <div id="riders_container_button">
      <div id="riders_reservation_button_container">
        <a id="riders_reservation_button" onclick="show_riders_reservation();">Réserver</a>
      </div>
      <a class="infobulle" onmouseover="show_anniverssary_popup(this, 'riders_infos');" onmouseout="hide_anniverssary_popup(this, 'riders_infos');">?</a>
    </div>

    <div id="riders_default_txt">
      <p id="riders_reservation_unavailable_message" style="display: none;">Location matériels "Riders" indisponible sur ce créneau horaire</p>
      <p id="riders_reservation_kids_message" style="display: none;">Location matériels "Riders" indisponible pour les Kids</p>
    </div>

    <div id="riders_selected_container" style="display: none;">
      <ul id="riders_selected"></ul>

      <a id="riders_update_button" onclick="show_riders_reservation();">Modifier</a>
    </div>
  </div>
</div><!-- #riders_container -->
