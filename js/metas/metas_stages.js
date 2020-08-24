var disabledDays = new Array();

function checkDisabledDays(d) {
  var ymd = d.getFullYear();

  if(d.getMonth() < 9){ ymd += ('-0' + (parseInt(d.getMonth())+1)); }else{  ymd += ('-' + (parseInt(d.getMonth())+1));  }
  if(d.getDate() < 10){ ymd += ('-0' + d.getDate());  }else{  ymd += ('-' + d.getDate()); }
  if(disabledDays.indexOf(ymd) >= 0) {  return [false, "notav", 'Not Available']; }else{  return [true, "av", "available"]; }
}

jQuery(function() {
  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    dataType: 'JSON',
    data: {action: 'get_non_holiday_dates'},
    success: function(res) {
      disabledDays = res.dates;
    }
  });

  jQuery.datepicker.setDefaults(jQuery.datepicker.regional["fr"]);

  jQuery( "#stage_start_date" ).datepicker({
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
    onSelect: function(dateText){},
    beforeShowDay: checkDisabledDays
  });

  jQuery( "#stage_end_date" ).datepicker({
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
    onSelect: function(dateText){},
    beforeShowDay: checkDisabledDays
  });
});

function valid_stage_dates(){
  //check if start date < end date
  var tmp_start_date = jQuery('#stage_start_date').val().split('/');
  var start_date = new Date(tmp_start_date[2], (parseInt(tmp_start_date[1]) - 1), tmp_start_date[0]);
  var tmp_end_date = jQuery('#stage_end_date').val().split('/');
  var end_date = new Date(tmp_end_date[2], (parseInt(tmp_end_date[1]) - 1), tmp_end_date[0]);

  var diffTime = Math.ceil(end_date - start_date);
  var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

  if(diffDays < 0){
    alert('Date de début > Date de fin');
    return false;
  }

  //check if date range not same as another stage
  /*var parameters = [];
  parameters.push(jQuery('#stage_start_date').val(), jQuery('#stage_end_date').val(), jQuery('#stage_id').val());

  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    dataType: 'JSON',
    data: {action: 'is_available_stage_date', parameters: parameters},
    success: function(res){
      if(res.statement){
        jQuery('#metas_stages_step2').show();
        return true;
      }
      else{
        alert('Créneau déjà pris');
        return false;
      }
    }
  });*/

  jQuery('#metas_stages_step2').show();
  return true;
}

function submit_stage_form(){
  if(valid_stage_dates()){  jQuery('.post-type-fip_stage #post').submit();  }
}

jQuery(document).ready(function(){
  jQuery('.post-type-fip_stage #post').on('submit', function(event){
    if(!valid_stage_dates()){
      event.preventDefault();
    }
  });
});

/*
function show_add_date_form(){
  jQuery('#stage_add_date_form').slideDown();
}

function add_date_to_stage(){
  var date = jQuery('#add_date_to_stage').val();
  var hour = jQuery('#add_hour_to_stage').val();

  jQuery('#no_date_message').hide();
  jQuery('#date_to_add').val(jQuery('#date_to_add').val() + date + '@' + hour + ',');
  jQuery('#stage_all_dates').append('<div class="date_container"><p>' + date + '</p><p>' + hour + '</p><p><a onclick="remove_date('+ date +'@'+ hour +')">x</a></p></div>');

  jQuery('#add_date_to_stage').val('');
  jQuery('#add_hour_to_stage').val('');
  jQuery('#stage_add_date_form').slideUp();
}

function remove_date(date){

}

function remove_date_to_stage(date_id){
  if(confirm("Êtes-vous sûr de vouloir supprimer cette date?")){
    jQuery('#date_container'+date_id).remove();
    jQuery('#date_to_delete').val(jQuery('#date_to_delete').val() + date_id + ',');
  }
}*/
