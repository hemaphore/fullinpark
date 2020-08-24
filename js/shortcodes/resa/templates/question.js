function valid_question(){
  if(jQuery('#question_fullname').val().length < 3){ return false; }
  if(!validEmail(jQuery('#question_email').val())){ return false; }
  if(!validPhone(jQuery('#question_phone').val())){ return false; }
  if(jQuery('#question_core').val().length < 3){ return false; }

  return true;
}

function question_errors(){
  var red = '#EDABAB';

  if(jQuery('#question_fullname').val().length < 3){ jQuery('#question_fullname').css('background', red); }else{  jQuery('#question_fullname').css('background', '#FFF'); }
  if(!validEmail(jQuery('#question_email').val())){ jQuery('#question_email').css('background', red); }else{  jQuery('#question_email').css('background', '#FFF'); }
  if(!validPhone(jQuery('#question_phone').val())){ jQuery('#question_phone').css('background', red); }else{  jQuery('#question_phone').css('background', '#FFF'); }
  if(jQuery('#question_core').val().length < 3){ jQuery('#question_core').css('background', red); }else{  jQuery('#question_core').css('background', '#FFF'); }
}

jQuery(function(){
  jQuery('#question_form').on('submit', function(event){
    if(!valid_question()){
      event.preventDefault();
      question_errors();
    }
  });
});
