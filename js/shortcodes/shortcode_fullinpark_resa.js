var disabledDays = new Array();

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

function show_question_form(){
  jQuery('#fullinpark_resa_form_content').animate({'margin-left' : '-200%'}, 400);
  jQuery('#fullinpark_second_step_form_content').animate({'margin-left' : '-200%'}, 400);
  jQuery('#fullinpark_question_form_content').animate({'margin-left' : '10%'}, 400);

  jQuery('#fullinpark_resa_form_content').css('display', 'none');
  jQuery('#fullinpark_second_step_form_content').css('display', 'none');
  jQuery('#fullinpark_question_form_content').css('display', 'block');
}

function show_resa_form(){
  jQuery('#fullinpark_question_form_content').animate({'margin-left' : '+200%'}, 400);
  jQuery('#fullinpark_second_step_form_content').animate({'margin-left' : '+200%'}, 400);
  jQuery('#fullinpark_resa_form_content').animate({'margin-left' : '10%'}, 400);

  jQuery('#fullinpark_question_form_content').css('display', 'none');
  jQuery('#fullinpark_second_step_form_content').css('display', 'none');
  jQuery('#fullinpark_resa_form_content').css('display', 'block');
}

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
    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'JSON',
      data: {action: 'get_disabled_dates'},
      success: function(res) {
        disabledDays = res.dates;

        jQuery('#datepicker').datepicker('refresh');
      }
    });
  }

  if(activity == "Coursep"){
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

function activity_selected(name, label){
  reset_resa_infos();

  jQuery('#toogle_activities_button p').html('<span class="blue bold">' + label + '</span>');
  jQuery('#resa_activity').val(name);

  if(name == "Coursep" || name == "Coursec"){ jQuery("#tickets_kids").hide(); }else{jQuery("#tickets_kids").css('display', 'flex'); }
  if(name != "Coursec"){  jQuery('#collectives_courses_selector_container').hide(); }
  if(name != "Stages"){  jQuery('#stage_selector_container').hide(); }
  if(name != "Anniversary"){
    jQuery('#anniversary_infos_container').hide();
    jQuery('#tickets_details_anniversary').hide();
  }

  //Hide Riders
  if(name != 'Jump'){ jQuery('#riders_container').hide(); }else{ jQuery('#riders_container').show(); }

  toogle_activities();
}

function show_stages_selector(){
  jQuery('#stage_selector_container').show();
  activity_selected('Stages', 'Stages');
}

function stage_selected(name, label){
  jQuery('#toogle_stages_button p').html('<span class="blue bold">' + label + '</span>');
  jQuery('#resa_stage_choice').val(name);

  var parameters = [];
  parameters.push(name);

  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    dataType: 'JSON',
    data: {action: 'get_stage_diabled_dates' , parameters: parameters},
    success: function(res) {
      disabledDays = res.dates;

      jQuery('#datepicker').datepicker('refresh');
    }
  });

  toogle_stages();
}

function toogle_stages(){
  jQuery('#custom_select_stages').toggleClass('active');
  jQuery('#toogle_stages_button').toggleClass('active');
}

function show_collective_course_selector(){
  jQuery('#collectives_courses_selector_container').show();
  activity_selected('Coursec', 'Cours Collectifs');
}

function toogle_collective_course(){
  jQuery('#custom_select_collectives_courses').toggleClass('active');
  jQuery('#toogle_collectives_courses_button').toggleClass('active');
}

function collective_course_selected(name, label){
  jQuery('#toogle_collectives_courses_button p').html('<span class="blue bold">' + label + '</span>');
  jQuery('#resa_collective_course_choice').val(name);

  var parameters = [];
  parameters.push(name);

  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    dataType: 'JSON',
    data: {action: 'get_disabled_date_for_collective_course', parameters: parameters},
    success: function(res) {
      disabledDays = res.dates;

      jQuery('#datepicker').datepicker('refresh');
    }
  });

  toogle_collective_course();
}

function show_anniversary_box(){
  jQuery('#anniversary_infos_container').show();
  activity_selected('Anniversary', 'Anniversaire');
}

function anniversary_formula_selected(name, label){
  jQuery('#toogle_anniversary_button p').html('<span class="blue bold">' + label + '</span>');
  jQuery('#resa_anniversary_formula').val(name);

  if(name == "FIPKids"){
    jQuery("#tickets_kids").show();
    jQuery("#tickets_jump").hide();
    jQuery('#tickets_kids').css('border', 'none');
    jQuery('#resa_jump').val('');
  }
  else{
    jQuery("#tickets_jump").show();
    jQuery("#tickets_kids").hide();
    jQuery('#tickets_kids').css('border-bottom', '1px solid #3161AC');
    jQuery('#resa_kids').val('');
  }

  jQuery('#anniversary_popup').hide();
  toogle_anniversary_formula();
}

function toogle_anniversary_formula(){
  jQuery('#custom_select_anniversary').toggleClass('active');
  jQuery('#toogle_anniversary_button').toggleClass('active');

  jQuery('#tickets_details_anniversary').show();
}

function switch_anniversary_resa_formula(elem, value){
  jQuery('.anniversary_formula').removeAttr('checked');
  jQuery('#resa_anniversary_food_formula').val(value);
  jQuery(elem).attr('checked', 'checked');
  jQuery('#anniversary_popup').hide();
}

function update_contact_infos(){
  jQuery('#resa_contact_fullname').val(jQuery('#resa_fullname').val());
  jQuery('#resa_contact_email').val(jQuery('#resa_email').val());
  jQuery('#resa_contact_phone').val(jQuery('#resa_phone').val());
}

function hide_popup(id){  jQuery(id).hide();  }

function show_anniverssary_popup(name){
  var elem = jQuery('#anniversary_formula_container').offset();
  var elem_container_width = parseInt(jQuery('#fullinpark_resa_form_container').css('width'));
  var elem_width = parseInt(jQuery('#anniversary_formula_container').css('width'));

  jQuery('#anniversary_popup').css('top', (elem.top / 4)+'px');
  jQuery('#anniversary_popup').css('left', (elem.left + elem_width + ((elem_container_width - elem_width) / 2) + 30)+'px');

  jQuery('.anniversary_popup_formula').hide();
  jQuery('#'+name+'_popup').show();

  jQuery('#anniversary_popup').show();
}
