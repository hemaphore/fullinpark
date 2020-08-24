function update_contact_infos(){
  jQuery('#resa_contact_fullname').val(jQuery('#resa_fullname').val());
  jQuery('#resa_contact_email').val(jQuery('#resa_email').val());
  jQuery('#resa_contact_phone').val(jQuery('#resa_phone').val());
}

function validEmail(email) {
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

function validPhone(phone) {
  var phone_to_test = phone.replace(" ", "");
  var re = /^(0|\+33)[1-9]([-.: ]?[0-9]{2}){4}$/;

  return re.test(phone_to_test);
}

function valid_step2(){
  if(jQuery('#resa_fullname').val().length < 3){ return false; }
  if(!validEmail(jQuery('#resa_email').val())){ return false; }
  if(!validPhone(jQuery('#resa_phone').val())){ return false; }

  return true;
}

function step2_errors(){
  var red = '#EDABAB';

  if(jQuery('#resa_fullname').val().length < 3){ jQuery('#resa_fullname').css('background', red); }else{  jQuery('#resa_fullname').css('background', '#FFF'); }
  if(!validEmail(jQuery('#resa_email').val())){ jQuery('#resa_email').css('background', red); }else{  jQuery('#resa_email').css('background', '#FFF'); }
  if(!validPhone(jQuery('#resa_phone').val())){ jQuery('#resa_phone').css('background', red); }else{  jQuery('#resa_phone').css('background', '#FFF'); }
}

function submit_resa_form(){
  if(valid_step2()){
    jQuery('#fullinpark_resa_form').submit();
  }
  else{
    step2_errors();
  }
}
