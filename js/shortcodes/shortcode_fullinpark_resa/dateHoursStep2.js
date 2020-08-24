function return_to_date_selector(){
  jQuery("#datepicker_step1").show();
  jQuery("#datepicker_step2").hide();
  jQuery("#datepicker_step3").hide();
}

function datepicker_move_step3(){
  jQuery("#datepicker_step1").hide();
  jQuery("#datepicker_step2").hide();
  jQuery('#datepicker_loader').show();
  jQuery('#resa_duration').val(jQuery('#step_2_duration').val());

  var dateText = jQuery('#resa_date').val();
  var jump_resa = jQuery('#resa_jump').val();
  var kids_resa = jQuery('#resa_kids').val();
  var duration = jQuery('#resa_duration').val();
  var resa_type = jQuery('#resa_activity').val();

  if(resa_type == "Coursep"){
    jQuery('#available_hours_container').empty();
    jQuery('#available_hours_container').append('<li onclick="select_hour(this);" data-hour="12:00">12:00</li>');
    jQuery('#datepicker_loader').hide();
    jQuery('#resa_date').val(dateText);
    jQuery("#date_selected").text(convert_date_format(dateText));
    jQuery("#duration_selected").text(duration);
    jQuery("#datepicker_step3_value").text(convert_date_format(dateText));
    jQuery("#datepicker_step3").show();
  }
  else if(resa_type == "Coursec"){
    jQuery('#available_hours_container').empty();
    jQuery('#available_hours_container').append('<li onclick="select_hour(this);" data-hour="15:30">15:30</li>');
    jQuery('#datepicker_loader').hide();
    jQuery('#resa_date').val(dateText);
    jQuery("#date_selected").text(convert_date_format(dateText));
    jQuery("#duration_selected").text(duration);
    jQuery("#datepicker_step3_value").text(convert_date_format(dateText));

    jQuery('#datepicker_return_step2').show();
    jQuery('#datepicker_return_step1').hide();
    jQuery("#datepicker_step3").show();
  }
  else{
    var parameters = [];
    parameters.push(dateText, jump_resa, kids_resa, duration);

    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      dataType: 'json',
      data: {action: 'get_hours_available', parameters: parameters},
      success: function(res) {
        jQuery('#available_hours_container').empty();

        for (var i = 0; i < res.hours.length; i++) {
          jQuery('#available_hours_container').append('<li onclick="select_hour(this);" data-hour="'+ res.hours[i] +'">'+res.hours[i]+'</li>');
        }

        jQuery('#datepicker_loader').hide();
        jQuery('#resa_date').val(dateText);
        jQuery("#date_selected").text(convert_date_format(dateText));
        jQuery("#duration_selected").text(duration);
        jQuery("#datepicker_step3_value").text(convert_date_format(dateText));
        jQuery("#datepicker_step3").show();
      }
    });
  }
}
