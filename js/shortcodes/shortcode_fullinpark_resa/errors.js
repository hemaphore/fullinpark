function show_step1_errors(){
  var error_message = '<p>Merci de renseigner les élements ci-dessous: </p><ul>';
  jQuery('#form_errors_message').empty();

  if(jQuery('#resa_activity').val().length <= 0){ error_message += '<li>Activité</li>'; }
  if(jQuery('#resa_jump').val().length <= 0 && jQuery('#resa_kids').val().length <= 0){ error_message += '<li>Tickets</li>';  }
  if(jQuery('#resa_date').val().length < 3){ error_message += '<li>Date</li>'; }
  if(jQuery('#resa_duration').val().length < 3){ error_message += '<li>Durée</li>'; }
  if(jQuery('#resa_hour').val().length < 3){ error_message += '<li>Heure</li>'; }

  error_message += '</ul>';
  jQuery('#form_errors_message').html(error_message);
  jQuery('#form_errors_message_container').css('display', 'flex');
}

function question_errors(){
  var red = '#EDABAB';

  if(jQuery('#question_fullname').val().length < 3){ jQuery('#question_fullname').css('background', red); }else{  jQuery('#question_fullname').css('background', '#FFF'); }
  if(!validEmail(jQuery('#question_email').val())){ jQuery('#question_email').css('background', red); }else{  jQuery('#question_email').css('background', '#FFF'); }
  if(!validPhone(jQuery('#question_phone').val())){ jQuery('#question_phone').css('background', red); }else{  jQuery('#question_phone').css('background', '#FFF'); }
}

function step2_errors(){
  var red = '#EDABAB';

  if(jQuery('#resa_fullname').val().length < 3){ jQuery('#resa_fullname').css('background', red); }else{  jQuery('#resa_fullname').css('background', '#FFF'); }
  if(!validEmail(jQuery('#resa_email').val())){ jQuery('#resa_email').css('background', red); }else{  jQuery('#resa_email').css('background', '#FFF'); }
  if(!validPhone(jQuery('#resa_phone').val())){ jQuery('#resa_phone').css('background', red); }else{  jQuery('#resa_phone').css('background', '#FFF'); }
}
