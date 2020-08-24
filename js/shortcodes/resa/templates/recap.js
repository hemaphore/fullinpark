function valid_step1(){
  var valid = true;
  var activity = jQuery('#resa_activity').val();

  if(jQuery('#resa_activity').val().length <= 0){ return false; }
  if((jQuery('#resa_jump').val().length <= 0 || jQuery('#resa_jump').val() == '0') && (jQuery('#resa_kids').val().length <= 0 || jQuery('#resa_kids').val() == '0')){ return false; }
  if(jQuery('#resa_date').val().length < 3){ return false; }
  if(jQuery('#resa_duration').val().length < 3){ return false; }
  if(jQuery('#resa_hour').val().length < 3){ return false; }

  if(activity == 'Stages'){
    jQuery('.infos_require').each(function(){
      if(jQuery(this).val().length < 1){
        valid = false;
      }
    });
  }

  return valid;
}

function show_step1_errors(){
  var error_message = '<p>Merci de renseigner les élements ci-dessous: </p><ul>';
  jQuery('#form_errors_message').empty();

  if(jQuery('#resa_activity').val().length <= 0){ error_message += '<li>Activité</li>'; }
  if((jQuery('#resa_jump').val().length <= 0 || jQuery('#resa_jump').val() == '0') && (jQuery('#resa_kids').val().length <= 0 || jQuery('#resa_kids').val() == '0')){ error_message += '<li>Nombre de participant</li>';  }
  if(jQuery('#resa_date').val().length < 3){ error_message += '<li>Date</li>'; }
  if(jQuery('#resa_duration').val().length < 3){ error_message += '<li>Durée</li>'; }
  if(jQuery('#resa_hour').val().length < 3){ error_message += '<li>Heure</li>'; }

  if(jQuery('#resa_activity').val() == 'Stages'){
    jQuery('.infos_require').each(function(){
      if(jQuery(this).val().length < 1){
        error_message += '<li>'+ jQuery(this).attr('data-error') +'</li>';
      }
    });
  }

  error_message += '</ul>';
  jQuery('#form_errors_message').html(error_message);
  jQuery('#form_errors_message_container').css('display', 'flex');
}

function scrollTo(target){
  if(target.length){
    jQuery("html, body").stop().animate( { scrollTop: (target.offset().top - 150) }, 1000);
  }
}

function go_to_step2(){
  if(valid_step1()){
    jQuery('.infos_require').each(function(){
      jQuery('#fullinpark_resa_form').append('<input type="hidden" name="'+jQuery(this).attr('name')+'" value="'+jQuery(this).val()+'"/>');
    });

    scrollTo(jQuery('#fullinpark_resa_container'));

    jQuery('#fullinpark_resa_form_content').animate({'margin-left' : '+200%'}, 400);
    jQuery('#fullinpark_second_step_form_content').animate({'margin-left' : '10%'}, 400);

    jQuery('#fullinpark_resa_form_content').css('display', 'none');
    jQuery('#fullinpark_second_step_form_content').css('display', 'block');
  }
  else{
    show_step1_errors();
  }
}
