function show_riders_reservation(){
  jQuery('#riders_reservation_container').css('display', 'flex');
}

function hide_riders_reservation(){
  jQuery('#riders_reservation_container').css('display', 'none');
}

function remove_rider(id){
  var ticket_number = parseInt(jQuery('#rider_number_'+id).text());

  if(ticket_number > 0){
    jQuery('#rider_number_'+id).text(ticket_number-1);
  }
}

function add_rider(id, max){
  var ticket_number = parseInt(jQuery('#rider_number_'+id).text());

  if(ticket_number < max){
    jQuery('#rider_number_'+id).text(ticket_number+1);
  }
}

function add_rider_to_resa(){
  var all_riders = '';
  jQuery('#riders_selected').empty();

  // Riders selected
  jQuery('.rider_line').each(function(index){
    var rider_number = parseInt(jQuery(this).find('.resa_number').text());

    if(rider_number > 0){
      var rider_id = jQuery(this).find('.resa_number').attr('data-id');
      jQuery('#riders_selected').append('<li>'+ jQuery(this).find('.resa_number').attr('data-name') +' (qty: '+ rider_number +')</li>');
      all_riders += (rider_id + ',');
    }
  });
  jQuery('#resa_riders').val(all_riders.slice(0,-1));

  //Riders display
  jQuery('#riders_default_txt').hide();
  jQuery('#riders_selected_container').show();

  hide_riders_reservation();
}
