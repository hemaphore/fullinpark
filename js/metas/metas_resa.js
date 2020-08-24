jQuery(function() {
  jQuery.datepicker.setDefaults(jQuery.datepicker.regional["fr"]);
  jQuery( "#edit_resa_date" ).datepicker({
    dateFormat: "dd/mm/yy",
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
  });
});

function switch_extra_infos_content(elem){
  var activity = jQuery(elem).val();
  var activities = {
    "Jump" : "",
    "Structure" : "structure",
    "Anniversaire" : "anniversary",
    "Stage" : "stage",
    "Course" : "course",
    "Other" : ""
  };

  jQuery('.extra_infos_container').hide();
  jQuery('#'+activities[activity]).show();

  if(activity == 'Anniversaire'){
    jQuery('#edit_resa_duration').val('2:00');
    jQuery('#edit_resa_duration').attr('disabled', 'disabled');
    jQuery('#resa_statement_anniversary').show();
  }
  else{
    jQuery('#resa_statement_anniversary').hide();
  }

  if(activity == 'Stage'){
    jQuery('#edit_resa_duration').val('3:00');
    jQuery('#edit_resa_duration').attr('disabled', 'disabled');
  }
  else{

  }
}

function switch_course_type(elem){
  jQuery('.course_type').removeAttr('checked');
  jQuery(elem).attr('checked', 'checked');

  if(jQuery('#collective_course').is(":checked")){
    jQuery('#collective_course_container').show();
  }
  else{
    jQuery('#collective_course_container').hide();
  }
}

function switch_anniversary_type(elem){
  jQuery('.anniversary_type').removeAttr('checked');
  jQuery(elem).attr('checked', 'checked');
}

function switch_anniversary_formula(elem){
  jQuery('.anniversary_formula').removeAttr('checked');
  jQuery(elem).attr('checked', 'checked');
}

//Formulaire Résa Validation
function validDuration(duration) {
  var re = /^([0-9]|1[0-9]|2[0-3]):([03]|[00])[0]$/;
  return re.test(String(duration).toLowerCase());
}

function validHoursRange(duration){
  var hour = duration.split(':');

  if(hour[0] >= 9 && hour[0] <= 22){  return true;  }
  return false;
}

function validDate(date){
  var re = /^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/;
  return re.test(String(date).toLowerCase());
}

function valid_resa_cpt(){
  if(jQuery('#edit_contact_fullname').val().length < 3){ return false; }
  if(jQuery('#edit_contact_email').val().length < 3){ return false; }
  if(jQuery('#edit_contact_phone').val().length < 3){ return false; }
  if(!validDuration(jQuery('#edit_resa_duration').val())){ return false; }
  if(!validDuration(jQuery('#edit_resa_hour').val()) || !validHoursRange(jQuery('#edit_resa_hour').val())){ return false; }
  if(!validDate(jQuery('#edit_resa_date').val())){ return false; }
  if(jQuery('#edit_resa_jump').val() <= 0 && jQuery('#edit_resa_kids').val() <= 0){ return false; }

  return true;
}

function show_resa_cpt_errors(){
  var red = '#EDABAB';

  if(jQuery('#edit_contact_fullname').val().length < 3){ jQuery('#edit_contact_fullname').css('background', red); }else{ jQuery('#edit_contact_fullname').css('background', "#FFF"); }
  if(jQuery('#edit_contact_email').val().length < 3){ jQuery('#edit_contact_email').css('background', red); }else{ jQuery('#edit_contact_email').css('background', "#FFF"); }
  if(jQuery('#edit_contact_phone').val().length < 3){ jQuery('#edit_contact_phone').css('background', red); }else{ jQuery('#edit_contact_phone').css('background', "#FFF"); }
  if(!validDuration(jQuery('#edit_resa_duration').val())){ jQuery('#edit_resa_duration').css('background', red); }else{ jQuery('#edit_resa_duration').css('background', "#FFF"); }
  if(!validDuration(jQuery('#edit_resa_hour').val()) || !validHoursRange(jQuery('#edit_resa_hour').val())){ jQuery('#edit_resa_hour').css('background', red); }else{ jQuery('#edit_resa_hour').css('background', "#FFF"); }
  if(!validDate(jQuery('#edit_resa_date').val())){ jQuery('#edit_resa_date').css('background', red); }else{ jQuery('#edit_resa_date').css('background', "#FFF"); }
  if(jQuery('#edit_resa_jump').val() <= 0 && jQuery('#edit_resa_kids').val() <= 0){
    jQuery('#edit_resa_jump').css('background', red);
    jQuery('#edit_resa_kids').css('background', red);
  }
  else{
    jQuery('#edit_resa_jump').css('background', '#FFF');
    jQuery('#edit_resa_kids').css('background', '#FFF');
  }
}

function valid_course_resa_cpt(){
  if(jQuery('#edit_contact_fullname').val().length < 3){ return false; }
  if(jQuery('#edit_contact_email').val().length < 3){ return false; }
  if(jQuery('#edit_contact_phone').val().length < 3){ return false; }

  if(!validDuration(jQuery('#edit_resa_duration').val())){ return false; }
  if(!validDuration(jQuery('#edit_resa_hour').val())){ return false; }
  if(!validDate(jQuery('#edit_resa_date').val())){ return false; }
  if(jQuery('#edit_resa_kids').val() != 0){ return false; }
  if(jQuery('#edit_resa_jump').val() > 10){ return false; }
  if(!jQuery('#private_course').is(':checked') && !jQuery('#collective_course').is(':checked')){ return false; }

  if(jQuery('#collective_course').is(':checked')){
    if(jQuery('#collective_course_choice').val() == null || jQuery('#collective_course_choice').val() == undefined || jQuery('#collective_course_choice').val() == ""){ return false; }
  }

  return true;
}

function show_course_resa_cpt_errors(){
  var red = '#EDABAB';

  if(jQuery('#edit_contact_fullname').val().length < 3){ jQuery('#edit_contact_fullname').css('background', red); }else{ jQuery('#edit_contact_fullname').css('background', "#FFF"); }
  if(jQuery('#edit_contact_email').val().length < 3){ jQuery('#edit_contact_email').css('background', red); }else{ jQuery('#edit_contact_email').css('background', "#FFF"); }
  if(jQuery('#edit_contact_phone').val().length < 3){ jQuery('#edit_contact_phone').css('background', red); }else{ jQuery('#edit_contact_phone').css('background', "#FFF"); }
  if(!validDuration(jQuery('#edit_resa_duration').val())){ jQuery('#edit_resa_duration').css('background', red); }else{ jQuery('#edit_resa_duration').css('background', "#FFF"); }
  if(!validDuration(jQuery('#edit_resa_hour').val())){ jQuery('#edit_resa_hour').css('background', red); }else{ jQuery('#edit_resa_hour').css('background', "#FFF"); }
  if(!validDate(jQuery('#edit_resa_date').val())){ jQuery('#edit_resa_date').css('background', red); }else{ jQuery('#edit_resa_date').css('background', "#FFF"); }
  if(jQuery('#edit_resa_kids').val() != 0){ jQuery('#edit_resa_kids').css('background', red); }else{ jQuery('#edit_resa_kids').css('background', "#FFF"); }
  if(jQuery('#edit_resa_jump').val() > 10){ jQuery('#edit_resa_jump').css('background', red); }else{ jQuery('#edit_resa_jump').css('background', "#FFF"); }
  if(!jQuery('#private_course').is(':checked') && !jQuery('#collective_course').is(':checked')){
    jQuery('#private_course').parent().css('color', red);
    jQuery('#collective_course').parent().css('color', red);
  }
  else{
    jQuery('#private_course').parent().css('color', '#000');
    jQuery('#collective_course').parent().css('color', '#000');
  }
}

function valid_stage_resa_cpt(){
  if(jQuery('#edit_contact_fullname').val().length < 3){ return false; }
  if(jQuery('#edit_contact_email').val().length < 3){ return false; }
  if(jQuery('#edit_contact_phone').val().length < 3){ return false; }
  if(!validDuration(jQuery('#edit_resa_duration').val())){ return false; }
  if(!validDuration(jQuery('#edit_resa_hour').val())){ return false; }
  if(!validDate(jQuery('#edit_resa_date').val())){ return false; }

  return true;
}

function show_stage_resa_cpt_errors(){
  var red = '#EDABAB';

  if(jQuery('#edit_contact_fullname').val().length < 3){ jQuery('#edit_contact_fullname').css('background', red); }else{ jQuery('#edit_contact_fullname').css('background', "#FFF"); }
  if(jQuery('#edit_contact_email').val().length < 3){ jQuery('#edit_contact_email').css('background', red); }else{ jQuery('#edit_contact_email').css('background', "#FFF"); }
  if(jQuery('#edit_contact_phone').val().length < 3){ jQuery('#edit_contact_phone').css('background', red); }else{ jQuery('#edit_contact_phone').css('background', "#FFF"); }
  if(!validDuration(jQuery('#edit_resa_duration').val())){ jQuery('#edit_resa_duration').css('background', red); }else{ jQuery('#edit_resa_duration').css('background', "#FFF"); }
  if(!validDuration(jQuery('#edit_resa_hour').val())){ jQuery('#edit_resa_hour').css('background', red); }else{ jQuery('#edit_resa_hour').css('background', "#FFF"); }
  if(!validDate(jQuery('#edit_resa_date').val())){ jQuery('#edit_resa_date').css('background', red); }else{ jQuery('#edit_resa_date').css('background', "#FFF"); }
}

function valid_anniversary_resa_cpt(){
  if(jQuery('#edit_contact_fullname').val().length < 3){ return false; }
  if(jQuery('#edit_contact_email').val().length < 3){ return false; }
  if(jQuery('#edit_contact_phone').val().length < 3){ return false; }
  if(!validDuration(jQuery('#edit_resa_duration').val())){ return false; }
  if(!validDuration(jQuery('#edit_resa_hour').val())){ return false; }
  if(!validDate(jQuery('#edit_resa_date').val())){ return false; }

  if(!jQuery('#anniversary_fip').is(':checked') && !jQuery('#anniversary_fipplus').is(':checked') && !jQuery('#anniversary_fipprem').is(':checked') && !jQuery('#anniversary_kids').is(':checked')){ return false; }
  if(jQuery('#anniversary_fip').is(':checked') || jQuery('#anniversary_fipplus').is(':checked') || jQuery('#anniversary_fipprem').is(':checked')){
    if(jQuery('#edit_resa_jump').val() < 8 || jQuery('#edit_resa_kids').val() != 0){
      return false;
    }
  }

  if(jQuery('#anniversary_kids').is(':checked')){
    if(jQuery('#edit_resa_kids').val() < 8 || jQuery('#edit_resa_jump').val() != 0){
      return false;
    }
  }

  return true;
}

function show_anniversary_resa_cpt_errors(){
  var red = '#EDABAB';

  if(jQuery('#edit_contact_fullname').val().length < 3){ jQuery('#edit_contact_fullname').css('background', red); }else{ jQuery('#edit_contact_fullname').css('background', "#FFF"); }
  if(jQuery('#edit_contact_email').val().length < 3){ jQuery('#edit_contact_email').css('background', red); }else{ jQuery('#edit_contact_email').css('background', "#FFF"); }
  if(jQuery('#edit_contact_phone').val().length < 3){ jQuery('#edit_contact_phone').css('background', red); }else{ jQuery('#edit_contact_phone').css('background', "#FFF"); }
  if(!validDuration(jQuery('#edit_resa_duration').val())){ jQuery('#edit_resa_duration').css('background', red); }else{ jQuery('#edit_resa_duration').css('background', "#FFF"); }
  if(!validDuration(jQuery('#edit_resa_hour').val())){ jQuery('#edit_resa_hour').css('background', red); }else{ jQuery('#edit_resa_hour').css('background', "#FFF"); }
  if(!validDate(jQuery('#edit_resa_date').val())){ jQuery('#edit_resa_date').css('background', red); }else{ jQuery('#edit_resa_date').css('background', "#FFF"); }

  if(!jQuery('#anniversary_fip').is(':checked') && !jQuery('#anniversary_fipplus').is(':checked') && !jQuery('#anniversary_fipprem').is(':checked') && !jQuery('#anniversary_kids').is(':checked')){
    jQuery('#anniversary_fip').parent().css('color', red);
    jQuery('#anniversary_fipplus').parent().css('color', red);
    jQuery('#anniversary_fipprem').parent().css('color', red);
    jQuery('#anniversary_kids').parent().css('color', red);
  }
  else{
    jQuery('#anniversary_fip').parent().css('color', '#000');
    jQuery('#anniversary_fipplus').parent().css('color', '#000');
    jQuery('#anniversary_fipprem').parent().css('color', '#000');
    jQuery('#anniversary_kids').parent().css('color', '#000');
  }

  if(jQuery('#anniversary_fip').is(':checked') || jQuery('#anniversary_fipplus').is(':checked') || jQuery('#anniversary_fipprem').is(':checked')){
    if(jQuery('#edit_resa_jump').val() < 8 || jQuery('#edit_resa_kids').val() != 0){
      jQuery('#edit_resa_jump').css('background', red);
      jQuery('#edit_resa_kids').css('background', red);
    }
    else{
      jQuery('#edit_resa_jump').css('background', '#FFF');
      jQuery('#edit_resa_kids').css('background', '#FFF');
    }
  }

  if(jQuery('#anniversary_kids').is(':checked')){
    if(jQuery('#edit_resa_kids').val() < 8 || jQuery('#edit_resa_jump').val() != 0){
      jQuery('#edit_resa_jump').css('background', red);
      jQuery('#edit_resa_kids').css('background', red);
    }
    else{
      jQuery('#edit_resa_jump').css('background', '#FFF');
      jQuery('#edit_resa_kids').css('background', '#FFF');
    }
  }
}

jQuery(document).ready(function(){
  jQuery('#post').on('submit', function(event){
    var resa_type = jQuery('#edit_resa_activity').val();
    jQuery('#edit_resa_duration').removeAttr('disabled');

    if(jQuery('#stage_date_edit').val() == 'edit'){ return; }
    switch (resa_type) {
      case 'Course':
        if(!valid_course_resa_cpt()){
          event.preventDefault();
          show_course_resa_cpt_errors();
        }
        break;
      case 'Stage':
        if(!valid_stage_resa_cpt()){
          event.preventDefault();
          show_stage_resa_cpt_errors();
        }
        break;
      case 'Anniversaire':
        if(!valid_anniversary_resa_cpt()){
          event.preventDefault();
          show_anniversary_resa_cpt_errors();
        }
        break;
      case undefined:
        break;
      default:
        if(!valid_resa_cpt()){
          event.preventDefault();
          show_resa_cpt_errors();
        }
        break;
    }
  });
});
