<div id="stagepicker_container">
  <a id="hide_stagepicker" onclick="hide_stagepicker();"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/close.png'; ?>"/></a>

  <div id="stagepicker_content">
    <p>Cochez les créneaux que vous souhaitez réserver</p>

    <div id="stagepicker_table">
      <div class="head row">
        <div></div>
        <div>9:00</div>
        <div>14:00</div>
      </div>

      <?php
      $day = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

      for($i=1; $i <= 7; $i++): ?>
        <div id="row<?php echo $i; ?>" class="row">
          <div><?php echo $day[($i -1)]; ?></div>
          <div id="day<?php echo $i; ?>m"></div>
          <div id="day<?php echo $i; ?>a"></div>
        </div>
        <?php
      endfor; ?>
    </div>

    <a onclick="valid_stage_resa();" class="resa_submit_button">Valider</a>
  </div>
</div>
