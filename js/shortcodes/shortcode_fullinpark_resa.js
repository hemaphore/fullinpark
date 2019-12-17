function toogle_activities(){
  jQuery('#custom_select_activities').toggleClass('active');
  jQuery('#toogle_activities_button').toggleClass('active');
}

function remove_ticket(id){
  var ticket_number = parseInt(jQuery('#ticket_number_'+id).text());

  if(ticket_number > 0){  jQuery('#ticket_number_'+id).text(ticket_number-1); }
}

function add_ticket(id){
  var ticket_number = parseInt(jQuery('#ticket_number_'+id).text());
  jQuery('#ticket_number_'+id).text(ticket_number+1);
}

function show_datepicker(){
  jQuery('#datepicker_container').css('display', 'flex');
}

function hide_datepicker(){
  jQuery('#datepicker_container').css('display', 'none');
}

jQuery(function() {
  jQuery( "#datepicker" ).datepicker(
    jQuery.datepicker.regional['fr']
  );
});
