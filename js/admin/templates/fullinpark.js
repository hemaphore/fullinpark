function change_display_mode(elem){
  alert(jQuery(elem).val());
}

function show_resa_infos(resa_id){
  //fonction ajax pour remplir la popup
  var parameters = [];
  parameters.push(resa_id);

  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    dataType: 'JSON',
    data: {action: 'get_resa_info', parameters: parameters},
    success: function(res){
			jQuery("#resa_infos_value_jump").text(res.jump);
      jQuery("#resa_infos_value_kids").text(res.kids);
      jQuery("#resa_infos_value_date").text(res.date);
      jQuery("#resa_infos_value_hour").text(res.hour);
      jQuery("#resa_infos_value_fullname").text(res.fullname);
      jQuery("#resa_infos_value_email").text(res.email);
      jQuery("#resa_infos_value_phone").text(res.phone);
    }
  });

  jQuery('#resa_infos_popup').css('display', 'flex');
}

function hide_popup(id){
  jQuery(id).css('display', 'none');
}
