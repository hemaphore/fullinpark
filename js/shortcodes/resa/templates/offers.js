function remove_ticket(id, min){
  var ticket_number = parseInt(jQuery('#ticket_number_'+id).text());
  var activity = jQuery('#resa_activity').val();

  if(activity == 'Stages' && ticket_number > 1){
    jQuery('#stage_extra_infos .stagiaire').last().remove();
  }

  if(ticket_number > 0 && ticket_number > min){
    jQuery('#ticket_number_'+id).text(ticket_number-1);
    jQuery('#resa_'+id).val(ticket_number-1);
  }
}

function add_ticket(id, max){
  var ticket_number = parseInt(jQuery('#ticket_number_'+id).text());
  var activity = jQuery('#resa_activity').val();

  if(activity == 'Stages' && ticket_number >= 1){
    stagiaire_id = ticket_number +1;
    jQuery('#stage_extra_infos').append('<div id="stagiaire'+stagiaire_id+'" class="stagiaire"><p>Stagiaire n°'+stagiaire_id+'</p><input type="text" name="stagiaire'+stagiaire_id+'_lastname" id="stagiaire'+stagiaire_id+'_lastname" class="infos_require" data-error="Nom du stagiaire n°'+stagiaire_id+'" placeholder="Nom du stagiaire"/><input type="text" name="stagiaire'+stagiaire_id+'_firstname" id="stagiaire'+stagiaire_id+'_firstname" class="infos_require"data-error="Prénom du stagiaire n°'+stagiaire_id+'"  placeholder="Prénom du stagiaire"/><input type="text" name="stagiaire'+stagiaire_id+'_age" id="stagiaire'+stagiaire_id+'_age" class="infos_require" data-error="Âge du stagiaire n°'+stagiaire_id+'" placeholder="Âge du stagiaire (6ans minimum)"/></div>');
  }

  if(ticket_number < max){
    jQuery('#ticket_number_'+id).text(ticket_number+1);
    jQuery('#resa_'+id).val(ticket_number+1);
  }
}

function update_kids_info(){
  jQuery('#resa_anniversary_kids_name').val(jQuery('#anniversary_kids_name').val());
  jQuery('#resa_anniversary_kids_age').val(jQuery('#anniversary_kids_age').val());
}

function check_formula(elem){
  var age = jQuery(elem).val();
  var formula = jQuery('#resa_anniversary_formula').val();

  if((age < 6 && formula != 'FIPKids') || (age >= 6 && formula == 'FIPKids')){
    alert('L’âge de votre enfant ne correspond pas à la formule choisie !');
    jQuery('#resa_anniversary_formula').val('');
    jQuery('#toogle_anniversary_button p').html('Choisis <span class="blue bold">ta formule</span>');
  }

  update_kids_info();
}

function update_formula_extra_info(elem){
  jQuery('.extra_infos_checkbox').removeAttr('checked');
  jQuery(elem).attr('checked', 'checked');

  jQuery('#resa_anniversary_cake_choice').val(jQuery(elem).attr('data-cake'));
}
