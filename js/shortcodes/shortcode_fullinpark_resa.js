function remove_ticket(id){
  var ticket_number = parseInt(jQuery('#ticket_number_'+id).text());

  if(ticket_number > 0){  jQuery('#ticket_number_'+id).text(ticket_number-1); }
}

function add_ticket(id){
  var ticket_number = parseInt(jQuery('#ticket_number_'+id).text());
  jQuery('#ticket_number_'+id).text(ticket_number+1);
}
