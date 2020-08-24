<div id="fullinpark_resa_form_activities">
  <p class="secondary_title">PARTICULIERS</p>

  <div class="grey_container">
    <div class="custom_select">
      <a id="toogle_activities_button" onclick="toogle_activities();">
        <p class="custom_select_default">Choisis <span class="blue bold">ton activité</span></p>
        <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-blue.png'; ?> "/>
      </a>

      <div id="custom_select_activities">
        <ul>
          <li onclick="activity_selected('Jump', 'Entrée(s) Jump/Kids');">Entrée(s) Jump/Kids</li>
          <li onclick="activity_selected('Coursep', 'Cours Privés');">Cours Privés</li>
          <!--<li onclick="show_collective_course_selector();">Cours Collectifs</li>-->
          <li onclick="show_stages_selector();">Stages</li>
          <li onclick="show_anniversary_box();">Anniversaire</li>
        </ul>
      </div>
    </div>
  </div>
</div><!-- #fullinpark_resa_form_activities -->
