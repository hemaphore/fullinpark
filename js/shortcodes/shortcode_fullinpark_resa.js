function show_question_form(){
  jQuery('#fullinpark_resa_form_content').animate({'margin-left' : '-200%'}, 400);
  jQuery('#fullinpark_second_step_form_content').animate({'margin-left' : '-200%'}, 400);
  jQuery('#fullinpark_question_form_content').animate({'margin-left' : '10%'}, 400);

  jQuery('#fullinpark_resa_form_content').css('display', 'none');
  jQuery('#fullinpark_second_step_form_content').css('display', 'none');
  jQuery('#fullinpark_question_form_content').css('display', 'block');
}

function show_resa_form(){
  jQuery('#fullinpark_question_form_content').animate({'margin-left' : '+200%'}, 400);
  jQuery('#fullinpark_second_step_form_content').animate({'margin-left' : '+200%'}, 400);
  jQuery('#fullinpark_resa_form_content').animate({'margin-left' : '10%'}, 400);

  jQuery('#fullinpark_question_form_content').css('display', 'none');
    jQuery('#fullinpark_second_step_form_content').css('display', 'none');
  jQuery('#fullinpark_resa_form_content').css('display', 'block');
}

function go_to_step2(){
  jQuery('#fullinpark_resa_form_content').animate({'margin-left' : '+200%'}, 400);
  jQuery('#fullinpark_second_step_form_content').animate({'margin-left' : '10%'}, 400);

  jQuery('#fullinpark_resa_form_content').css('display', 'none');
  jQuery('#fullinpark_second_step_form_content').css('display', 'block');
}

function toogle_activities(){
  jQuery('#custom_select_activities').toggleClass('active');
  jQuery('#toogle_activities_button').toggleClass('active');
}

function toogle_stages(){
  jQuery('#custom_select_stages').toggleClass('active');
  jQuery('#toogle_stages_button').toggleClass('active');
}

function activity_selected(name){
  jQuery('#toogle_activities_button p').html('<span class="blue bold">' + name + '</span>');
  toogle_activities();
}

function show_stages_selector(){
  jQuery('#stage_selector_container').show();
  activity_selected('Stages');
}

function stage_selected(name){
  jQuery('#toogle_stages_button p').html('<span class="blue bold">' + name + '</span>');
  toogle_stages();
}

function remove_ticket(id){
  var ticket_number = parseInt(jQuery('#ticket_number_'+id).text());

  if(ticket_number > 0){
    jQuery('#ticket_number_'+id).text(ticket_number-1);
    jQuery('#resa_'+id).val(ticket_number-1);
  }
}

function add_ticket(id){
  var ticket_number = parseInt(jQuery('#ticket_number_'+id).text());
  jQuery('#ticket_number_'+id).text(ticket_number+1);
  jQuery('#resa_'+id).val(ticket_number+1);
}

function show_datepicker(){
  jQuery('#datepicker_container').css('display', 'flex');
}

function hide_datepicker(){
  jQuery('#datepicker_container').css('display', 'none');
}

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
    alert('submitted');
    jQuery('#fullinpark_resa_form').submit();
  }
  else{
    step2_errors();
  }
}

function valid_question(){
  if(jQuery('#question_fullname').val().length < 3){ return false; }
  if(!validEmail(jQuery('#question_email').val())){ return false; }
  if(!validPhone(jQuery('#question_phone').val())){ return false; }

  return true;
}

function question_errors(){
  var red = '#EDABAB';

  if(jQuery('#question_fullname').val().length < 3){ jQuery('#question_fullname').css('background', red); }else{  jQuery('#question_fullname').css('background', '#FFF'); }
  if(!validEmail(jQuery('#question_email').val())){ jQuery('#question_email').css('background', red); }else{  jQuery('#question_email').css('background', '#FFF'); }
  if(!validPhone(jQuery('#question_phone').val())){ jQuery('#question_phone').css('background', red); }else{  jQuery('#question_phone').css('background', '#FFF'); }
}

jQuery(function() {
  jQuery( "#datepicker" ).datepicker(
    jQuery.datepicker.regional['fr']
  );

  jQuery('#question_form').on('submit', function(event){
    if(!valid_question()){
      event.preventDefault();
      question_errors();
    }
  });
});
