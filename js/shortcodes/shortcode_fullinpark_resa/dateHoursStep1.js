function show_datepicker(){
  var activity = jQuery('#resa_activity').val();

  if(jQuery('#resa_jump').val().length <= 0 && jQuery('#resa_kids').val().length <= 0){
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
    var formula = jQuery('#resa_anniversary_food_formula').val();
    if(jQuery('#resa_anniversary_formula').val() == "FIPKids"){
      var resa_number = jQuery('#resa_kids').val();
    }
    else{
      var resa_number = jQuery('#resa_jump').val();
    }

    var parameters = [];
    parameters.push(date, name, formula, resa_number);

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
    parameters.push(dateText, jQuery('#resa_stage_choice').val());

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
