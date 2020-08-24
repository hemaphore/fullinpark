function hide_all_selector(){
  jQuery('#custom_select_stages').removeClass('active');
  jQuery('#toogle_stages_button').removeClass('active');

  jQuery('#custom_select_collectives_courses').removeClass('active');
  jQuery('#toogle_collectives_courses_button').removeClass('active');

  jQuery('#custom_select_anniversary').removeClass('active');
  jQuery('#toogle_anniversary_button').removeClass('active');
}

function toogle_activities(){
  jQuery('#custom_select_activities').toggleClass('active');
  jQuery('#toogle_activities_button').toggleClass('active');

  hide_all_selector();

  var activity = jQuery('#resa_activity').val();

  if(activity == "Jump" || activity == 'Anniversary'){
    if(activity == 'Anniversary'){
      jQuery('#tickets_details_anniversary').show();
    }
    else{
      jQuery('#tickets_details_anniversary').hide();
    }

    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'JSON',
      data: {action: 'get_disabled_dates'},
      success: function(res) {
        disabledDays = res.dates;

        if(activity == 'Anniversary'){
          jQuery( "#datepicker" ).datepicker("option", "minDate", '+3d');
        }
        else{
          jQuery( "#datepicker" ).datepicker("option", "minDate", 0);
        }
        jQuery('#datepicker').datepicker('refresh');
      }
    });
  }

  if(activity == 'Stages'){
    jQuery('#stage_extra_infos_container').show();
  }
  else{
    jQuery('#stage_extra_infos_container').hide();
  }

  if(activity == "Coursep"){
    jQuery( "#datepicker" ).datepicker("option", "minDate", '+3d');
    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'JSON',
      data: {action: 'get_disabled_date_for_private_course'},
      success: function(res) {
        disabledDays = res.dates;

        jQuery('#datepicker').datepicker('refresh');
      }
    });
  }
}

function reset_resa_infos(){
  jQuery("#date_selected").text('');
  jQuery("#duration_selected").text('');
  jQuery("#hour_selected").text('');

  jQuery("#resa_date").val('');
  jQuery("#resa_duration").val('');
  jQuery("#resa_hour").val('');

  jQuery("#datepicker_step1").show();
  jQuery("#datepicker_step2").hide();
  jQuery("#datepicker_step3").hide();
}

function activity_selected(name, label){
  reset_resa_infos();

  jQuery('#toogle_activities_button p').html('<span class="blue bold">' + label + '</span>');
  jQuery('#resa_activity').val(name);

  if(name == "Coursep" || name == "Coursec" || name == "Stages"){ jQuery("#tickets_kids").hide(); }else{jQuery("#tickets_kids").css('display', 'flex'); }
  if(name != "Coursec"){  jQuery('#collectives_courses_selector_container').hide(); }
  if(name != "Stages"){
    jQuery('#stage_selector_container').hide();
    jQuery('#date_hours_container').css('display', 'flex');
    jQuery('#stagerecap_container').hide();
  }
  else{
    jQuery('#date_hours_container').hide();
    jQuery('#stagerecap_container').css('display', 'flex');
  }

  if(name != "Anniversary"){
    jQuery('#anniversary_infos_container').hide();
    jQuery('#tickets_details_anniversary').hide();
    jQuery('#fullinpark_resa_form_offers').find('#offer_title').text('NOS OFFRES');
  }
  else{
    jQuery('#fullinpark_resa_form_offers').find('#offer_title').text('NOMBRE D\'INVITÉS ');

    jQuery('#resa_jump_remove').attr("onclick", "remove_ticket('jump', 8);");
    jQuery('#resa_jump_add').attr("onclick", "add_ticket('jump', 14);");

    jQuery('#resa_kids_remove').attr("onclick", "remove_ticket('kids', 8);");
    jQuery('#resa_kids_add').attr("onclick", "add_ticket('kids', 14);");
  }

  //Hide Riders
  if(name != 'Jump'){ jQuery('#riders_container').hide(); }else{ jQuery('#riders_container').show(); }

  toogle_activities();
}

function show_stages_selector(){
  jQuery('#stage_selector_container').show();
  activity_selected('Stages', 'Stages');
}

function show_collective_course_selector(){
  jQuery('#collectives_courses_selector_container').show();
  activity_selected('Coursec', 'Cours Collectifs');
}

function show_anniversary_box(){
  jQuery('#anniversary_infos_container').show();
  activity_selected('Anniversary', 'Anniversaire');
}
