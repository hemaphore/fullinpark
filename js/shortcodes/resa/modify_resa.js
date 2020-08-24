function validDuration(duration) {
  var re = /^([0-9]|1[0-9]|2[0-3]):([03]|[00])[0]$/;
  return re.test(String(duration).toLowerCase());
}

function validDate(date){
  var re = /^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/;
  return re.test(String(date).toLowerCase());
}

function edit_resa_infos(id){ jQuery(id).removeAttr('disabled');  }
function confirm_delete(elem){
  if(confirm("Êtes-vous sûr de vouloir supprimer cette réservation?")){
    document.location.href = jQuery(elem).attr('data-href');
  }
}

function valid_resa_edited(){
  var valid = true;

  if(!validDuration(jQuery('#edit_resa_duration').val())){ return false; }
  if(!validDuration(jQuery('#edit_resa_hour').val())){ return false; }
  if(!validDate(jQuery('#edit_resa_date').val())){ return false; }

  var parameters = [];
  parameters.push(jQuery('#edit_resa_date').val(), jQuery('#edit_resa_hour').val(), jQuery('#edit_resa_duration').val(), jQuery('#edit_resa_jump').val(), jQuery('#edit_resa_kids').val());

  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    async: false,
    cache: false,
    dataType: 'JSON',
    data: {action: 'valid_resa_edited' , parameters: parameters},
    success: function(res) {
      if(!res.valid){
        alert('Le nombre de place disponible est insuffisant !');
        valid = false;
      }
    }
  });

  return valid;
}

function show_errors_resa_edited(){
  var red = '#EDABAB';

  if(!validDuration(jQuery('#edit_resa_duration').val())){ jQuery('#edit_resa_duration').css('background', red); }else{ jQuery('#edit_resa_duration').css('background', "#FFF"); }
  if(!validDuration(jQuery('#edit_resa_hour').val())){ jQuery('#edit_resa_hour').css('background', red); }else{ jQuery('#edit_resa_hour').css('background', "#FFF"); }
  if(!validDate(jQuery('#edit_resa_date').val())){ jQuery('#edit_resa_date').css('background', red); }else{ jQuery('#edit_resa_date').css('background', "#FFF"); }
}

function submit_modify_resa(){
  if(valid_resa_edited()){
    jQuery('#edit_resa_form').submit();
  }
  else{
    show_errors_resa_edited();
  }
}

jQuery(function(){
  var disabledDays = new Array();

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
      beforeShowDay: checkDisabledDays
    });
  }, 2000);
});
