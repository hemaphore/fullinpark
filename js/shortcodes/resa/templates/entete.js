function show_resa_form(){
  jQuery('#fullinpark_question_form_content').animate({'margin-left' : '+200%'}, 400);
  jQuery('#fullinpark_second_step_form_content').animate({'margin-left' : '+200%'}, 400);
  jQuery('#fullinpark_structure_form_content').animate({'margin-left' : '-200%'}, 400);
  jQuery('#fullinpark_resa_form_content').animate({'margin-left' : '10%'}, 400);

  jQuery('#fullinpark_question_form_content').css('display', 'none');
  jQuery('#fullinpark_second_step_form_content').css('display', 'none');
  jQuery('#fullinpark_structure_form_content').css('display', 'none');
  jQuery('#fullinpark_resa_form_content').css('display', 'block');
}
