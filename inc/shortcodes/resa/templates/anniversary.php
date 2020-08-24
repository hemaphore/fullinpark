<div id="anniversary_infos_container">
  <p class="secondary_title">Anniversaire</p>

  <div class="grey_container">
    <div class="custom_select">
      <a id="toogle_anniversary_button" onclick="toogle_anniversary_formula();">
        <p class="custom_select_default">Choisis <span class="blue bold">ta formule</span></p>
        <img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/arrow-blue.png'; ?> "/>
      </a>

      <div id="custom_select_anniversary">
        <ul>
          <li onclick="anniversary_formula_selected('FIP', 'Full In Party');">Full In Party <a class="infobulle" onmouseover="show_anniverssary_popup(this, 'anniversary_fip');" onmouseout="hide_anniverssary_popup(this, 'anniversary_fip');">?</a></li>
          <li onclick="anniversary_formula_selected('FIP+', 'Full In Party +');">Full In Party + <a class="infobulle" onmouseover="show_anniverssary_popup(this, 'anniversary_fipplus');" onmouseout="hide_anniverssary_popup(this, 'anniversary_fipplus');">?</a></li>
          <li onclick="anniversary_formula_selected('FIPprem', 'Full In Party Premium');">Full In Party Premium <a class="infobulle" onmouseover="show_anniverssary_popup(this, 'anniversary_fipprem');" onmouseout="hide_anniverssary_popup(this, 'anniversary_fipprem');">?</a></li>
          <li onclick="anniversary_formula_selected('FIPKids', 'Full In Party Kids');">Full In Party Kids <a class="infobulle" onmouseover="show_anniverssary_popup(this, 'anniversary_fipkids');" onmouseout="hide_anniverssary_popup(this, 'anniversary_fipkids');">?</a></li>
        </ul>
      </div>
    </div>
  </div>

  <p class="secondary_title">Choisissez votre option</p>

  <div id="anniversary_formula_container" class="grey_container">
    <div class="anniversary_formula_box">
      <label><input type="checkbox" class="anniversary_formula" onchange="switch_anniversary_resa_formula(this, 'anniversary_sweet');"/>Formule Sucrée</label>
      <a class="infobulle" onmouseover="show_anniverssary_popup(this, 'anniversary_sweet');" onmouseout="hide_anniverssary_popup(this, 'anniversary_sweet');">?</a>
    </div>

    <div class="anniversary_formula_box">
      <label><input type="checkbox" class="anniversary_formula" onchange="switch_anniversary_resa_formula(this, 'anniversary_salty');"/>Formule Salée</label>
      <a class="infobulle" onmouseover="show_anniverssary_popup(this, 'anniversary_salty');" onmouseout="hide_anniverssary_popup(this, 'anniversary_salty');">?</a>
    </div>

    <div class="anniversary_formula_box">
      <label><input type="checkbox" class="anniversary_formula" onchange="switch_anniversary_resa_formula(this, 'anniversary_sweetandsalty');"/>Formule Sucrée + Salée (supplément 3€/personne)</label>
      <a class="infobulle" onmouseover="show_anniverssary_popup(this, 'anniversary_sweetandsalty');" onmouseout="hide_anniverssary_popup(this, 'anniversary_sweetandsalty');">?</a>
    </div>
  </div>
</div> <!-- #anniversary_infos_container -->
