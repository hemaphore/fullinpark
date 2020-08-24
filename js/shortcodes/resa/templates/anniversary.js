function toogle_anniversary_formula(){
  jQuery('#custom_select_anniversary').toggleClass('active');
  jQuery('#toogle_anniversary_button').toggleClass('active');

  jQuery('#tickets_details_anniversary').show();
}

function anniversary_formula_selected(name, label){
  jQuery('#toogle_anniversary_button p').html('<span class="blue bold">' + label + '</span>');
  jQuery('#resa_anniversary_formula').val(name);

  if(name == "FIPKids"){
    jQuery("#tickets_kids").show();
    jQuery("#tickets_jump").hide();
    jQuery('#tickets_kids').css('border', 'none');
    jQuery('#resa_jump').val('');
    jQuery('#ticket_number_jump').text('0');

    if(parseInt(jQuery('#resa_kids').val()) < 8 || jQuery('#resa_kids').val() == ''){
      jQuery('#ticket_number_kids').text('8');
      jQuery('#resa_kids').val(8);
    }
  }
  else{
    jQuery("#tickets_jump").show();
    jQuery("#tickets_kids").hide();
    jQuery('#tickets_kids').css('border-bottom', '1px solid #3161AC');
    jQuery('#resa_kids').val('');
    jQuery('#ticket_number_kids').text('0');

    if(parseInt(jQuery('#resa_jump').val()) < 8 || jQuery('#resa_jump').val() == ''){
      jQuery('#ticket_number_jump').text('8');
      jQuery('#resa_jump').val(8);
    }
  }

  jQuery('#anniversary_popup').hide();
  toogle_anniversary_formula();
}

function show_anniverssary_popup(call_to_action, name){
  var elem = jQuery(call_to_action).offset();
  var form_container_width = parseInt(jQuery('#fullinpark_resa_form_container').css('width'));
  var elem_width = parseInt(jQuery('#anniversary_formula_container').css('width'));

  if(name == 'riders_infos'){
    elem_width = parseInt(jQuery('#riders_container').css('width'));
  }

  jQuery('#anniversary_popup').find('.triangle').css('margin-left', (elem_width - 60)+'px');
  jQuery('#anniversary_popup').css('width', (elem_width +2) +'px');

  jQuery('#anniversary_popup').css('top', (((elem.top) + 35))+'px');
  jQuery('#anniversary_popup').css('left', (((elem.left) - elem_width) + parseInt(jQuery(call_to_action).css('width')) + 20)+'px');

  jQuery('.anniversary_popup_formula').hide();
  jQuery('#'+name+'_popup').show();

  jQuery('#anniversary_popup').show();
}

function hide_anniverssary_popup(call_to_action, name){
  jQuery('#anniversary_popup').hide();
}

function switch_anniversary_resa_formula(elem, value){
  jQuery('.anniversary_formula').removeAttr('checked');
  jQuery('#resa_anniversary_food_formula').val(value);
  jQuery(elem).attr('checked', 'checked');
  jQuery('#anniversary_popup').hide();

  if(value == 'anniversary_salty'){
    jQuery('#anniversary_cake_container').hide();
  }
  else{
    jQuery('#anniversary_cake_container').css('display', 'flex');
  }
}
