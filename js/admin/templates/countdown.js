function add_to_countdown(){
  current_val = parseInt(jQuery('#countdown_value').text());
  jQuery('#countdown_value').text(current_val + 1);
}

function remove_to_countdown(){
  current_val = parseInt(jQuery('#countdown_value').text());

  if(current_val > 0){
    jQuery('#countdown_value').text(current_val - 1);
  }
}
