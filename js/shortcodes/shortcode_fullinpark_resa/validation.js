function validEmail(email) {
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

function validPhone(phone) {
  var phone_to_test = phone.replace(" ", "");
  var re = /^(0|\+33)[1-9]([-.: ]?[0-9]{2}){4}$/;

  return re.test(phone_to_test);
}

function valid_step1(){
  if(jQuery('#resa_activity').val().length <= 0){ return false; }
  if(jQuery('#resa_jump').val().length <= 0 && jQuery('#resa_kids').val().length <= 0){ return false; }
  if(jQuery('#resa_date').val().length < 3){ return false; }
  if(jQuery('#resa_duration').val().length < 3){ return false; }
  if(jQuery('#resa_hour').val().length < 3){ return false; }

  return true;
}

function valid_step2(){
  if(jQuery('#resa_fullname').val().length < 3){ return false; }
  if(!validEmail(jQuery('#resa_email').val())){ return false; }
  if(!validPhone(jQuery('#resa_phone').val())){ return false; }

  return true;
}

function valid_question(){
  if(jQuery('#question_fullname').val().length < 3){ return false; }
  if(!validEmail(jQuery('#question_email').val())){ return false; }
  if(!validPhone(jQuery('#question_phone').val())){ return false; }

  return true;
}

function appendLeadingZeroes(n){
  if(n <= 9){ return "0" + n; }
  return n;
}

function convert_date_format(date){
  let current_datetime = new Date(date);
  let formatted_date = appendLeadingZeroes(current_datetime.getDate()) + "/" + appendLeadingZeroes(current_datetime.getMonth() + 1) + "/" + current_datetime.getFullYear();
  return formatted_date;
}

function is_riders_selected(){
  if(jQuery('#resa_riders').val().length > 0){
    return true;
  }
  else{
    return false;
  }
}
