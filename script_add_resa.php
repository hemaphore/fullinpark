<?php
$user_infos = array(
  'resa_contact_fullname' => 'Maxime PORPIGLIA',
  'resa_contact_email' => 'maxime.porpiglia@gmail.com',
  'resa_contact_phone' => '0750376864'
);

$hours = array(
  array("hour" => "9:30","jump" => 3,  "kids" => 5),
  array("hour" => "9:30", "jump" => 10,  "kids" => 0),
  array("hour" => "10:00", "jump" => 2,  "kids" => 2),
  array("hour" => "10:30", "jump" => 15,  "kids" => 5),
  array("hour" => "10:30", "jump" => 30,  "kids" => 7),
  array("hour" => "10:30", "jump" => 10,  "kids" => 0),
  array("hour" => "10:30", "jump" => 0,  "kids" => 10),
  array("hour" => "11:00", "jump" => 5,  "kids" => 0),
  array("hour" => "11:30", "jump" => 5,  "kids" => 3),
  array("hour" => "12:00", "jump" => 5,  "kids" => 3),
  array("hour" => "12:30", "jump" => 2,  "kids" => 2),
  array("hour" => "13:00","jump" => 3,  "kids" => 5),
  array("hour" => "13:00", "jump" => 10,  "kids" => 0),
  array("hour" => "13:30", "jump" => 15,  "kids" => 5),
  array("hour" => "14:00", "jump" => 30,  "kids" => 7),
  array("hour" => "14:00", "jump" => 10,  "kids" => 0),
  array("hour" => "14:30", "jump" => 0,  "kids" => 10),
  array("hour" => "15:00", "jump" => 5,  "kids" => 0)
);

$fip_start_date = '2020-1-11';
$fip_end_date = '2020-01-22';
$fip_current_date = strtotime($fip_start_date);
$interval = (24 * 3600);

while ($fip_current_date <= strtotime($fip_end_date)):
  foreach ($hours as $hour):
    $resa_infos = array(
  	  'post_title'    => $user_infos['resa_contact_fullname'].' - '.date('d/m/Y', $fip_current_date),
  	  'post_content'  => '',
  	  'post_status'   => 'publish',
  	  'post_author'   => 1,
  	  'post_category' => array(),
  		'post_type'     => 'fip_resa',
  	);

  	$resa_id = wp_insert_post($resa_infos);

    update_post_meta($resa_id, 'resa_activity', 'jump');
    update_post_meta($resa_id, 'resa_jump', $hour['jump']);
    update_post_meta($resa_id, 'resa_kids', $hour['kids']);
    update_post_meta($resa_id, 'resa_date', date('d/m/Y', $fip_current_date));
    update_post_meta($resa_id, 'resa_hour', $hour['hour']);

    //Contact infos
    update_post_meta($resa_id, 'resa_contact_fullname', $user_infos['resa_contact_fullname']);
    update_post_meta($resa_id, 'resa_contact_email', $user_infos['resa_contact_email']);
    update_post_meta($resa_id, 'resa_contact_phone', $user_infos['resa_contact_phone']);
  endforeach;

  $fip_current_date = $fip_current_date + $interval;
endwhile;
