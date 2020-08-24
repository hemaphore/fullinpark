<div id="fullinpark_second_step_form_content" style="display: none;">
  <div>
    <p class="main_title">Contact: </p>

    <div>
      <p class="secondary_title">Nom complet</p>
      <input type="text" id="resa_fullname" onchange="update_contact_infos();"/>
    </div>

    <div>
      <p class="secondary_title">Email</p>
      <input type="text" id="resa_email" onchange="update_contact_infos();"/>
    </div>

    <div>
      <p class="secondary_title">Téléphone</p>
      <input type="text" id="resa_phone" onchange="update_contact_infos();"/>
    </div>
  </div>

  <div id="resa_form_submit_button">
    <a class="return_button" onclick="show_resa_form();">Retour</a>
    <a class="next_step" onclick="submit_resa_form();">Réserver</a>
  </div>
</div>
