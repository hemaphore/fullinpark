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

  return valid;
}

function show_errors_resa_edited(){
  var red = '#EDABAB';

  if(!validDuration(jQuery('#edit_resa_duration').val())){ jQuery('#edit_resa_duration').css('background', red); }else{ jQuery('#edit_resa_duration').css('background', "#FFF"); }
  if(!validDuration(jQuery('#edit_resa_hour').val())){ jQuery('#edit_resa_hour').css('background', red); }else{ jQuery('#edit_resa_hour').css('background', "#FFF"); }
  if(!validDate(jQuery('#edit_resa_date').val())){ jQuery('#edit_resa_date').css('background', red); }else{ jQuery('#edit_resa_date').css('background', "#FFF"); }
}

jQuery(function(){
  jQuery('#edit_resa_form').on('submit', function(event){
    if(valid_resa_edited()){
      jQuery('#edit_resa_jump').removeAttr('disabled');
      jQuery('#edit_resa_kids').removeAttr('disabled');
      jQuery('#edit_resa_date').removeAttr('disabled');
      jQuery('#edit_resa_hour').removeAttr('disabled');
      jQuery('#edit_resa_duration').removeAttr('disabled');
      jQuery('#edit_resa_contact_fullname').removeAttr('disabled');
      jQuery('#edit_resa_contact_email').removeAttr('disabled');
      jQuery('#edit_resa_contact_phone').removeAttr('disabled');
    }
    else{
      event.preventDefault();
      show_errors_resa_edited();
    }
  });
});

// ^([0-9]|1[0-9]|2[0-3]):([03]|[00])[0]$ regex pour la durée et l'heure
