<div id="collectives_courses_selector_container">
  <p class="secondary_title">Cours Collectifs</p>

  <div class="grey_container">
    <div class="custom_select">
      <a id="toogle_collectives_courses_button" onclick="toogle_collective_course();">
        <p class="custom_select_default">Choisis <span class="blue bold">ton cour collectif</span></p>
        <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-blue.png'; ?> "/>
      </a>

      <div id="custom_select_collectives_courses">
        <ul>
          <li onclick="collective_course_selected('trampo', 'Trampoline');">Trampoline</li>
          <li onclick="collective_course_selected('parkour', 'Parkour & Free Run');">Parkour & Free Run</li>
          <li onclick="collective_course_selected('fitramp', 'Fit Tramp');">Fit Tramp</li>
        </ul>
      </div>
    </div>
  </div>
</div><!-- #collectives_courses_selector_container -->
