<div id="fullinpark_question_form_content" style="display: none;">
  <p class="main_title">Votre question</p>

  <form action="#" method="POST" id="question_form">
    <div class="question_form_row">
      <label for="question_fullname">Nom complet</label>
      <input type="text" id="question_fullname" name="question_fullname"/>
    </div>

    <div class="question_form_row">
      <label for="question_email">Email</label>
      <input type="text" id="question_email" name="question_email"/>
    </div>

    <div class="question_form_row">
      <label for="question_phone">Téléphone</label>
      <input type="text" id="question_phone" name="question_phone"/>
    </div>

    <div class="question_form_row">
      <label for="question_core">Question</label>
      <textarea id="question_core" name="question_core"></textarea>
    </div>

    <input type="hidden" name="question_sent" value="sent"/>
    <button type="submit">Envoyer</button>
  </form>
</div>
