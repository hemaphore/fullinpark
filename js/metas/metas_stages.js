jQuery(function() {
  jQuery( "#start_date" ).datepicker({
    dateFormat: "yy-mm-dd",
    dayNames: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"]
  });

  jQuery( "#end_date" ).datepicker({
    dateFormat: "yy-mm-dd",
    dayNames: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"]
  });
});
