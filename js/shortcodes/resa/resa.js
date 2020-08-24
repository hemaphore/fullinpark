function appendLeadingZeroes(n){
  if(n <= 9){ return "0" + n; }
  return n;
}

function convert_date_format(date){
  let current_datetime = new Date(date);
  let formatted_date = appendLeadingZeroes(current_datetime.getDate()) + "/" + appendLeadingZeroes(current_datetime.getMonth() + 1) + "/" + current_datetime.getFullYear();
  return formatted_date;
}
