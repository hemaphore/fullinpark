function edit_resa_infos(id){
  jQuery(id).removeAttr('disabled');
}

jQuery(function(){
  jQuery('#edit_resa_form').on('submit', function(){
    jQuery('#edit_resa_jump').removeAttr('disabled');
    jQuery('#edit_resa_kids').removeAttr('disabled');
    jQuery('#edit_resa_date').removeAttr('disabled');
    jQuery('#edit_resa_hour').removeAttr('disabled');
    jQuery('#edit_resa_contact_fullname').removeAttr('disabled');
    jQuery('#edit_resa_contact_email').removeAttr('disabled');
    jQuery('#edit_resa_contact_phone').removeAttr('disabled');
  });
});
