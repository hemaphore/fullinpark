function go_to_step2(){
  if(valid_step1()){
    jQuery('#fullinpark_resa_form_content').animate({'margin-left' : '+200%'}, 400);
    jQuery('#fullinpark_second_step_form_content').animate({'margin-left' : '10%'}, 400);

    jQuery('#fullinpark_resa_form_content').css('display', 'none');
    jQuery('#fullinpark_second_step_form_content').css('display', 'block');
  }
  else{
    show_step1_errors();
  }
}

function submit_resa_form(){
  if(valid_step2()){
    jQuery('#fullinpark_resa_form').submit();
  }
  else{
    step2_errors();
  }
}

jQuery(function(){
  jQuery('#question_form').on('submit', function(event){
    if(!valid_question()){
      event.preventDefault();
      question_errors();
    }
  });
});
