<div id="fullinpark_structure_form_content" style="display: none;">
  <p class="main_title">Votre Demande</p>

  <form action="#" method="POST" id="structure_form">
    <div class="question_form_row">
      <label for="structure_fullname">Nom de la structure</label>
      <input type="text" id="structure_fullname" name="structure_fullname"/>
    </div>

    <div class="question_form_row">
      <label for="structure_adresse">Adresse de la structure</label>
      <input type="text" id="structure_adresse" name="structure_adresse"/>
    </div>

    <div class="structure_half_row">
      <div class="structure_form_row">
        <label for="structure_town">Ville</label>
        <input type="text" id="structure_town" name="structure_town"/>
      </div>

      <div class="structure_form_row">
        <label for="structure_zipcode">Code postal</label>
        <input type="text" id="structure_zipcode" name="structure_zipcode"/>
      </div>
    </div>

    <div class="question_form_row">
      <label for="structure_date">Date de l'animation</label>
      <input type="text" id="structure_date" name="structure_date"/>
    </div>

    <div class="structure_half_row">
      <div class="structure_form_row">
        <label for="structure_start_hour">Heure d’arrivée</label>
        <select id="structure_start_hour" name="structure_start_hour">
          <option value="">Choisir</option>
          <option value="9:00">9:00</option>
          <option value="9:30">9:30</option>
          <option value="10:00">10:00</option>
          <option value="10:30">10:30</option>
          <option value="11:00">11:00</option>
          <option value="11:30">11:30</option>
          <option value="12:00">12:00</option>
          <option value="12:30">12:30</option>
          <option value="13:00">13:00</option>
          <option value="13:30">13:30</option>
          <option value="14:00">14:00</option>
          <option value="14:30">14:30</option>
          <option value="15:00">15:00</option>
          <option value="15:30">15:30</option>
          <option value="16:00">16:00</option>
          <option value="16:30">16:30</option>
          <option value="17:00">17:00</option>
          <option value="17:30">17:30</option>
          <option value="18:00">18:00</option>
        </select>
      </div>

      <div class="structure_form_row">
        <label for="structure_end_hour">Heure de départ</label>
        <select id="structure_end_hour" name="structure_end_hour">
          <option value="">Choisir</option>
          <option value="10:00">10:00</option>
          <option value="10:30">10:30</option>
          <option value="11:00">11:00</option>
          <option value="11:30">11:30</option>
          <option value="12:00">12:00</option>
          <option value="12:30">12:30</option>
          <option value="13:00">13:00</option>
          <option value="13:30">13:30</option>
          <option value="14:00">14:00</option>
          <option value="14:30">14:30</option>
          <option value="15:00">15:00</option>
          <option value="15:30">15:30</option>
          <option value="16:00">16:00</option>
          <option value="16:30">16:30</option>
          <option value="17:00">17:00</option>
          <option value="17:30">17:30</option>
          <option value="18:00">18:00</option>
          <option value="18:30">18:30</option>
          <option value="19:00">19:00</option>
          <option value="19:30">19:30</option>
          <option value="20:00">20:00</option>
          <option value="20:30">20:30</option>
          <option value="21:00">21:00</option>
          <option value="21:30">21:30</option>
          <option value="22:00">22:00</option>
        <select>
      </div>
    </div>

    <div class="question_form_row">
      <label for="structure_participants">Nombre et âge des participants</label>
      <textarea id="structure_participants" name="structure_participants"></textarea>
    </div>

    <div class="structure_half_row">
      <div class="structure_form_row">
        <label for="structure_accompany">Nombre d’accompagnateur</label>
        <select id="structure_accompany" name="structure_accompany">
          <option value="">Choisir</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
        <select>
      </div>

      <div class="structure_form_row">
        <label for="structure_duration">Durée de la séance</label>
        <select id="structure_duration" name="structure_duration">
          <option value="">Choisir</option>
          <option value="1:00">1:00</option>
          <option value="1:30">1:30</option>
          <option value="2:00">2:00</option>
        <select>
      </div>
    </div>

    <div class="question_form_row">
      <label for="structure_formula">Formule choisie</label>
      <select id="structure_formula" name="structure_formula">
        <option value="null">Choisir</option>
        <option value="Acrobate">Acrobate (cours avec coach)</option>
        <option value="Découverte">Découverte (accès libre)</option>
      </select>
    </div>

    <div class="question_form_row">
      <label for="structure_email">Email de contact</label>
      <input type="text" id="structure_email" name="structure_email"/>
    </div>

    <div class="question_form_row">
      <label for="structure_phone">Téléphone de contact</label>
      <input type="text" id="structure_phone" name="structure_phone"/>
    </div>

    <div class="question_form_row">
      <label for="structure_divers">Remarques / Divers</label>
      <textarea id="structure_divers" name="structure_divers"></textarea>
    </div>

    <input type="hidden" name="structure_sent" value="sent"/>
    <button type="submit">Envoyer</button>
  </form>
</div>
