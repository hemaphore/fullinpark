<div id="datepicker_container">
  <a id="hide_datepicker" onclick="hide_datepicker();"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/delete-white.png'; ?>"/></a>

  <div id="datepicker_step1">
    <p id="datepicker_step1_title">Sélectionnez une date</p>
    <div id="datepicker"></div>
  </div>

  <div id="datepicker_step2">
    <p>Séléctionnez une durée</p>

    <div>
      <select name="step_2_duration" id="step_2_duration">
        <option value="1:00">1:00</option>
        <option value="1:30">1:30</option>
        <option value="2:00">2:00</option>
        <option value="2:30">2:30</option>
        <option value="3:00">3:00</option>
        <option value="3:30">3:30</option>
        <option value="4:00">4:00</option>
        <option value="4:30">4:30</option>
        <option value="5:00">5:00</option>
      </select>
    </div>

    <div id="datepicker_step2_arrow">
      <a class="datepicker_step2_arrow_back" onclick="return_to_date_selector();"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/back.png'; ?>"/></a>
      <a class="datepicker_step2_arrow_next" onclick="datepicker_move_step3();"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/next.png'; ?>"/></a>
    </div>
  </div>

  <div id="datepicker_step3">
    <p>Séléctionnez une heure</p>

    <div>
      <ul id="available_hours_container"></ul>
    </div>

    <div id="datepicker_step3_arrow">
      <a id="datepicker_return_step1" class="datepicker_step2_arrow_back" onclick="return_to_step1();"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/back.png'; ?>"/></a>
      <a id="datepicker_return_step2" class="datepicker_step2_arrow_back" onclick="return_to_step2();"><img src="<?php echo PLUGIN_FIP_URL.'/fullinpark/img/back.png'; ?>"/></a>
    </div>
  </div>

  <div id="datepicker_loader" class="loader"></div>
</div>
