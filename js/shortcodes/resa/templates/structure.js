function validZipcode(zipcode) {
  var zipcode_to_test = zipcode.replace(" ", "");
  var re = /^\d{5}$/ ;

  return re.test(zipcode_to_test);
}

function validEmail(email) {
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

function validPhone(phone) {
  var phone_to_test = phone.replace(" ", "");
  var re = /^(0|\+33)[1-9]([-.: ]?[0-9]{2}){4}$/;

  return re.test(phone_to_test);
}

function valid_structure_form(){
  if(jQuery('#structure_fullname').val().length < 3){ return false; }
  if(jQuery('#structure_adresse').val().length < 3){ return false; }
  if(jQuery('#structure_town').val().length < 3){ return false; }
  if(!validZipcode(jQuery('#structure_zipcode').val())){ return false; }
  if(jQuery('#structure_date').val().length < 3){ return false; }
  if(jQuery('#structure_start_hour').val().length < 3){ return false; }
  if(jQuery('#structure_end_hour').val().length < 3){ return false; }
  if(jQuery('#structure_participants').val().length < 1){ return false; }
  if(jQuery('#structure_accompany').val().length < 1){ return false; }
  if(jQuery('#structure_duration').val().length < 3){ return false; }
  if(jQuery('#structure_formula').val().length < 3 || jQuery('#structure_formula').val() == 'null'){ return false; }
  if(!validEmail(jQuery('#structure_email').val())){ return false; }
  if(!validPhone(jQuery('#structure_phone').val())){ return false; }
  if(jQuery('#structure_divers').val().length < 3){ return false; }


  return true;
}

function show_structure_errors(){
  var red = '#EDABAB';

  if(jQuery('#structure_fullname').val().length < 3){ jQuery('#structure_fullname').css('background', red); }else{  jQuery('#structure_fullname').css('background', '#FFF'); }
  if(jQuery('#structure_adresse').val().length < 3){ jQuery('#structure_adresse').css('background', red); }else{  jQuery('#structure_adresse').css('background', '#FFF'); }
  if(jQuery('#structure_town').val().length < 3){ jQuery('#structure_town').css('background', red); }else{  jQuery('#structure_town').css('background', '#FFF'); }
  if(!validZipcode(jQuery('#structure_zipcode').val())){ jQuery('#structure_zipcode').css('background', red); }else{  jQuery('#structure_zipcode').css('background', '#FFF'); }
  if(jQuery('#structure_date').val().length < 3){ jQuery('#structure_date').css('background', red); }else{  jQuery('#structure_date').css('background', '#FFF'); }
  if(jQuery('#structure_start_hour').val().length < 3){ jQuery('#structure_start_hour').css('background', red); }else{  jQuery('#structure_start_hour').css('background', '#FFF'); }
  if(jQuery('#structure_end_hour').val().length < 3){ jQuery('#structure_end_hour').css('background', red); }else{  jQuery('#structure_end_hour').css('background', '#FFF'); }
  if(jQuery('#structure_participants').val().length < 3){ jQuery('#structure_participants').css('background', red); }else{  jQuery('#structure_participants').css('background', '#FFF'); }
  if(jQuery('#structure_accompany').val().length < 1){ jQuery('#structure_accompany').css('background', red); }else{  jQuery('#structure_accompany').css('background', '#FFF'); }
  if(jQuery('#structure_duration').val().length < 3){ jQuery('#structure_duration').css('background', red); }else{  jQuery('#structure_duration').css('background', '#FFF'); }
  if(jQuery('#structure_formula').val().length < 3 || jQuery('#structure_formula').val() == 'null'){ jQuery('#structure_formula').css('background', red); }else{  jQuery('#structure_formula').css('background', '#FFF'); }
  if(!validEmail(jQuery('#structure_email').val())){ jQuery('#structure_email').css('background', red); }else{  jQuery('#structure_email').css('background', '#FFF'); }
  if(!validPhone(jQuery('#structure_phone').val())){ jQuery('#structure_phone').css('background', red); }else{  jQuery('#structure_phone').css('background', '#FFF'); }
  if(jQuery('#structure_divers').val().length < 3){ jQuery('#structure_divers').css('background', red); }else{  jQuery('#structure_divers').css('background', '#FFF'); }

}

jQuery(function(){
  jQuery('#structure_form').on('submit', function(event){
    if(!valid_structure_form()){
      event.preventDefault();
      show_structure_errors();
    }
  });

  jQuery.datepicker.setDefaults(jQuery.datepicker.regional["fr"]);
  jQuery( "#structure_date" ).datepicker({
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
