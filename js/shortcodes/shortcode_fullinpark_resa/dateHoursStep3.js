function return_to_step2(){
  jQuery("#datepicker_step1").hide();
  jQuery("#datepicker_step2").show();
  jQuery("#datepicker_step3").hide();
}

function return_to_step1(){
  jQuery("#datepicker_step1").show();
  jQuery("#datepicker_step2").hide();
  jQuery("#datepicker_step3").hide();
}

function select_hour(elem){
  var hour = jQuery(elem).attr('data-hour');
  jQuery('#resa_hour').val(hour);
  jQuery("#hour_selected").text(hour);

  var activity = jQuery('#resa_activity').val();
  var jump = jQuery('#resa_jump').val();
  var kids = jQuery('#resa_kids').val();
  var date = jQuery('#resa_date').val();
  var duration = jQuery('#resa_duration').val();
  var rider_selected = false;
  if(is_riders_selected()){ rider_selected = jQuery('#resa_riders').val();  }

  var parameters = [];
  parameters.push(date, hour, duration, rider_selected, activity, jump, kids);

  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    dataType: 'json',
    data: {action: 'is_valid_resa', parameters: parameters},
    success: function(res) {
      if(res.errors == true){

      }

      if(res.riders_unavailable == true){
        if(is_riders_selected()){
          jQuery('#resa_riders').val('');
          jQuery('#form_errors_message').empty();
          jQuery('#form_errors_message').html('<p>Location matériels "Riders" indisponible sur ce créneau horaire</p>');
          jQuery('#form_errors_message_container').show();
        }

        jQuery('#riders_default_txt').show();
        jQuery('#riders_reservation_unavailable_message').show();
        jQuery('#riders_reservation_kids_message').hide();
        jQuery('#riders_reservation_button').hide();
        jQuery('#riders_selected_container').hide();
      }

      if(parseInt(jQuery("#resa_jump").val()) <= 0 || jQuery("#resa_jump").val() == ''){
        if(is_riders_selected()){
          jQuery('#resa_riders').val('');
          jQuery('#form_errors_message').empty();
          jQuery('#form_errors_message').html('<p>Location matériels "Riders" indisponible pour les Kids</p>');
          jQuery('#form_errors_message_container').show();
        }

        jQuery('#riders_default_txt').show();
        jQuery('#riders_reservation_unavailable_message').hide();
        jQuery('#riders_reservation_kids_message').show();
        jQuery('#riders_reservation_button').hide();
        jQuery('#riders_selected_container').hide();
      }

      jQuery('#resa_jump_add').attr('onclick', 'add_ticket("jump", '+res.jump_max+');');
      jQuery('#resa_kids_add').attr('onclick', 'add_ticket("kids", '+res.kids_max+');');
    }
  });

  jQuery("#datepicker_container").hide();
}
