<?php
$countdown_value = fullinparkResaManager::get_resa_from_time_slot('10/10/2020', '9:30')
?>

<div id="fullinpark_admin_countdown_container">
  <a onclick="remove_to_countdown();">-</a>

  <div id="countdown">
    <p id="countdown_value"><?php echo $countdown_value; ?></p>
  </div>

  <a onclick="add_to_countdown();">+</a>
</div>
