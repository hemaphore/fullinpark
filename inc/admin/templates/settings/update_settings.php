<?php
if(isset($_POST['update_fullinpark_settings']) AND $_POST['update_fullinpark_settings'] == "updated"):
  update_option('fullinpark_admin_email', $_POST['fullinpark_admin_email']);
  update_option('max_jump_resa', $_POST['max_jump_resa']);
  update_option('max_stage_resa', $_POST['max_stage_resa']);
  update_option('max_kids_resa', $_POST['max_kids_resa']);
  update_option('anniversary_resa_available', $_POST['anniversary_resa_available']);
  update_option('stage_resa_available', $_POST['stage_resa_available']);
  update_option('max_private_course', $_POST['max_private_course']);
endif;
