function show_datepicker(){
  var activity = jQuery('#resa_activity').val();

  if(activity == 'Coursep'){
    var parameters = [];
    parameters.push(jQuery('#resa_jump').val());

    jQuery( "#datepicker" ).datepicker("option", "minDate", "+3d");
    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      async: false,
      cache: false,
      dataType: 'JSON',
      data: {action: 'get_disabled_date_for_private_course', parameters: parameters},
      success: function(res) {
        disabledDays = res.dates;

        jQuery('#datepicker').datepicker('refresh');
      }
    });
  }

  if((jQuery('#resa_jump').val().length <= 0 || jQuery('#resa_jump').val() == '0') && (jQuery('#resa_kids').val().length <= 0 || jQuery('#resa_kids').val() == '0')){
    alert('Merci de sélectionner un nombre d\'entrée avant de choisir votre date.');
  }
  else if(activity == 'Coursec' && jQuery('#resa_collective_course_choice').val() == ""){
    alert('Merci de sélectionner un cour collectif.');
  }
  else if(activity == 'Stages' && jQuery('#resa_stage_choice').val() == ""){
    alert('Merci de sélectionner un stage.');
  }
  else if(activity == 'Anniversary' && jQuery('#resa_anniversary_formula').val() == ""){
    alert('Merci de sélectionner un anniversaire.');
  }
  else if(activity == ''){
    alert('Merci de sélectionner une activité.');
  }
  else{
    jQuery('#datepicker_container').css('display', 'flex');
  }
}
function hide_datepicker(){ jQuery('#datepicker_container').css('display', 'none'); }

function datepicker_move_step2(dateText){
  var activity = jQuery('#resa_activity').val();

  jQuery("#datepicker_step1").hide();
  jQuery('#resa_date').val(dateText);
  jQuery("#date_selected").text(convert_date_format(dateText));

  if(activity == 'Anniversary'){
    jQuery('#available_hours_container').empty();
    jQuery("#duration_selected").text('2:00');
    jQuery('#resa_duration').val('2:00');
    jQuery('#datepicker_loader').show();

    var date = jQuery('#resa_date').val();
    var formula = jQuery('#resa_anniversary_formula').val();
    var formula_food = jQuery('#resa_anniversary_food_formula').val();
    if(jQuery('#resa_anniversary_formula').val() == "FIPKids"){
      var resa_number = jQuery('#resa_kids').val();
    }
    else{
      var resa_number = jQuery('#resa_jump').val();
    }

    var parameters = [];
    parameters.push(date, formula, formula_food, resa_number);

    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'JSON',
      data: {action: 'get_anniversary_hours_available', parameters: parameters},
      success: function(res) {
        for (var i = 0; i < res.hours.length; i++) {
          jQuery('#available_hours_container').append('<li onclick="select_hour(this);" data-hour="'+ res.hours[i] +'">'+res.hours[i]+'</li>');
        }

        jQuery('#datepicker_loader').hide();
        jQuery('#datepicker_return_step2').hide();
        jQuery('#datepicker_return_step1').show();
        jQuery("#datepicker_step3").show();
      }
    });
  }
  else if(activity == 'Stages'){
    jQuery('#datepicker_loader').show();
    jQuery('#available_hours_container').empty();

    var parameters = [];
    parameters.push(dateText, jQuery('#resa_stage_choice').val(), jQuery('#resa_jump').val());

    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'json',
      data: {action: 'get_stage_hours_available', parameters: parameters},
      success: function(res) {
        jQuery('#available_hours_container').empty();

        for (var i = 0; i < res.hours.length; i++) {
          jQuery('#available_hours_container').append('<li onclick="select_hour(this);" data-hour="'+ res.hours[i] +'">'+res.hours[i]+'</li>');
        }

        jQuery('#datepicker_loader').hide();
        jQuery("#duration_selected").text('3:00');
        jQuery('#resa_duration').val('3:00');
        jQuery('#datepicker_return_step2').hide();
        jQuery('#datepicker_return_step1').show();
        jQuery("#datepicker_step3").show();
      }
    });
  }
  else if(activity == 'Coursep'){
    jQuery('#available_hours_container').empty();
    jQuery('#available_hours_container').append('<li onclick="select_hour(this);" data-hour="12:00">12:00</li>');
    jQuery("#duration_selected").text('1:00');
    jQuery('#resa_duration').val('1:00');
    jQuery('#datepicker_return_step2').hide();
    jQuery('#datepicker_return_step1').show();
    jQuery("#datepicker_step3").show();
  }
  else if(activity == 'Coursec'){
    jQuery('#datepicker_loader').show();
    jQuery("#duration_selected").text('1:00');
    jQuery('#resa_duration').val('1:00');

    var parameters = [];
    parameters.push(dateText, jQuery('#resa_collective_course_choice').val());

    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'json',
      data: {action: 'get_collective_course_hours_available', parameters: parameters},
      success: function(res) {
        jQuery('#available_hours_container').empty();

        for (var i = 0; i < res.hours.length; i++) {
          jQuery('#available_hours_container').append('<li onclick="select_hour(this);" data-hour="'+ res.hours[i] +'">'+res.hours[i]+'</li>');
        }

        jQuery('#datepicker_loader').hide();
        jQuery("#duration_selected").text('1:00');
        jQuery('#resa_duration').val('1:00');
        jQuery('#datepicker_return_step2').hide();
        jQuery('#datepicker_return_step1').show();
        jQuery("#datepicker_step3").show();
      }
    });
  }
  else{
    jQuery('#datepicker_return_step2').show();
    jQuery('#datepicker_return_step1').hide();
    jQuery("#datepicker_step2").show();
  }
}

function checkDisabledDays(d) {
  var ymd = d.getFullYear();

  if(d.getMonth() < 9){ ymd += ('-0' + (parseInt(d.getMonth())+1)); }else{  ymd += ('-' + (parseInt(d.getMonth())+1));  }
  if(d.getDate() < 10){ ymd += ('-0' + d.getDate());  }else{  ymd += ('-' + d.getDate()); }
  if(disabledDays.indexOf(ymd) >= 0) {  return [false, "notav", 'Not Available']; }else{  return [true, "av", "available"]; }
}

jQuery(function(){
  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    dataType: 'JSON',
    data: {action: 'get_disabled_dates'},
    success: function(res) {
      disabledDays = res.dates;
    }
  });

  setTimeout(function(){
    jQuery('#datepicker_loader').hide();
    jQuery('#datepicker_step1').show();

    jQuery.datepicker.setDefaults(jQuery.datepicker.regional["fr"]);
    jQuery( "#datepicker" ).datepicker({
      dateFormat: "yy-mm-dd",
      firstDay: 1,
      minDate: 0,
      maxDate: "+6m",
      loseText: 'Fermer',
      prevText: 'Précédent',
      nextText: 'Suivant',
      currentText: 'Aujourd\'hui',
      monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
      monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
      dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
      dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
      dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
      weekHeader: 'Sem.',
      showOtherMonths:true,
      selectOtherMonths: false,
      regional : 'fr',
      onSelect: function(dateText) {
        datepicker_move_step2(dateText);
      },
      beforeShowDay: checkDisabledDays
    });
  }, 2000);
});

function return_to_date_selector(){
  jQuery("#datepicker_step1").show();
  jQuery("#datepicker_step2").hide();
  jQuery("#datepicker_step3").hide();
}

function datepicker_move_step3(){
  jQuery("#datepicker_step1").hide();
  jQuery("#datepicker_step2").hide();
  jQuery('#datepicker_loader').show();
  jQuery('#resa_duration').val(jQuery('#step_2_duration').val());

  var dateText = jQuery('#resa_date').val();
  var jump_resa = jQuery('#resa_jump').val();
  var kids_resa = jQuery('#resa_kids').val();
  var duration = jQuery('#resa_duration').val();
  var resa_type = jQuery('#resa_activity').val();

  if(resa_type == "Coursep"){
    jQuery('#available_hours_container').empty();
    jQuery('#available_hours_container').append('<li onclick="select_hour(this);" data-hour="12:00">12:00</li>');
    jQuery('#datepicker_loader').hide();
    jQuery('#resa_date').val(dateText);
    jQuery("#date_selected").text(convert_date_format(dateText));
    jQuery("#duration_selected").text(duration);
    jQuery("#datepicker_step3_value").text(convert_date_format(dateText));
    jQuery("#datepicker_step3").show();
  }
  else if(resa_type == "Coursec"){
    jQuery('#available_hours_container').empty();
    jQuery('#available_hours_container').append('<li onclick="select_hour(this);" data-hour="15:30">15:30</li>');
    jQuery('#datepicker_loader').hide();
    jQuery('#resa_date').val(dateText);
    jQuery("#date_selected").text(convert_date_format(dateText));
    jQuery("#duration_selected").text(duration);
    jQuery("#datepicker_step3_value").text(convert_date_format(dateText));

    jQuery('#datepicker_return_step2').show();
    jQuery('#datepicker_return_step1').hide();
    jQuery("#datepicker_step3").show();
  }
  else{
    var parameters = [];
    parameters.push(dateText, jump_resa, kids_resa, duration);

    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'json',
      data: {action: 'get_hours_available', parameters: parameters},
      success: function(res) {
        jQuery('#available_hours_container').empty();

        for (var i = 0; i < res.hours.length; i++) {
          jQuery('#available_hours_container').append('<li onclick="select_hour(this);" data-hour="'+ res.hours[i] +'">'+res.hours[i]+'</li>');
        }

        jQuery('#datepicker_loader').hide();
        jQuery('#resa_date').val(dateText);
        jQuery("#date_selected").text(convert_date_format(dateText));
        jQuery("#duration_selected").text(duration);
        jQuery("#datepicker_step3_value").text(convert_date_format(dateText));
        jQuery("#datepicker_step3").show();
      }
    });
  }
}

function return_to_step2(){
  jQuery("#datepicker_step1").hide();
  jQuery("#datepicker_step2").show();
  jQuery("#datepicker_step3").hide();
}

function return_to_step1(){
  jQuery("#datepicker_step1").show();
  jQuery("#datepicker_step2").hide();
  jQuery("#datepicker_step3").hide();
}

function select_hour(elem){
  var hour = jQuery(elem).attr('data-hour');
  jQuery('#resa_hour').val(hour);
  jQuery("#hour_selected").text(hour);

  var activity = jQuery('#resa_activity').val();
  var jump = jQuery('#resa_jump').val();
  var kids = jQuery('#resa_kids').val();
  var date = jQuery('#resa_date').val();
  var duration = jQuery('#resa_duration').val();
  var rider_selected = false;
  if(is_riders_selected()){ rider_selected = jQuery('#resa_riders').val();  }

  var parameters = [];
  parameters.push(date, hour, duration, rider_selected, activity, jump, kids);

  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    dataType: 'json',
    data: {action: 'is_valid_resa', parameters: parameters},
    success: function(res) {
      if(res.errors == true){

      }

      if(res.riders_unavailable == true){
        if(is_riders_selected()){
          jQuery('#resa_riders').val('');
          jQuery('#form_errors_message').empty();
          jQuery('#form_errors_message').html('<p>Location matériels "Riders" indisponible sur ce créneau horaire</p>');
          jQuery('#form_errors_message_container').show();
        }

        jQuery('#riders_default_txt').show();
        jQuery('#riders_reservation_unavailable_message').show();
        jQuery('#riders_reservation_kids_message').hide();
        jQuery('#riders_reservation_button').hide();
        jQuery('#riders_selected_container').hide();
      }
      else{
        jQuery('#riders_reservation_button').show();
        jQuery('#riders_reservation_unavailable_message').hide();
        jQuery('#riders_reservation_kids_message').show();
      }

      if(parseInt(jQuery("#resa_jump").val()) <= 0 || jQuery("#resa_jump").val() == ''){
        if(is_riders_selected()){
          jQuery('#resa_riders').val('');
          jQuery('#form_errors_message').empty();
          jQuery('#form_errors_message').html('<p>Location matériels "Riders" indisponible pour les Kids</p>');
          jQuery('#form_errors_message_container').show();
        }

        jQuery('#riders_default_txt').show();
        jQuery('#riders_reservation_unavailable_message').hide();
        jQuery('#riders_reservation_kids_message').show();
        jQuery('#riders_reservation_button').hide();
        jQuery('#riders_selected_container').hide();
      }
      else {
        jQuery('#riders_reservation_button').show();
        jQuery('#riders_reservation_unavailable_message').hide();
        jQuery('#riders_reservation_kids_message').show();
      }

      jQuery('#resa_jump_add').attr('onclick', 'add_ticket("jump", '+res.jump_max+');');
      jQuery('#resa_kids_add').attr('onclick', 'add_ticket("kids", '+res.kids_max+');');
    }
  });

  jQuery("#datepicker_container").hide();
}

function is_riders_selected(){
  if(jQuery('#resa_riders').val().length > 0){
    return true;
  }
  else{
    return false;
  }
}
