var disabledDays = new Array();

function toogle_stages(){
  jQuery('#custom_select_stages').toggleClass('active');
  jQuery('#toogle_stages_button').toggleClass('active');
}

function stage_selected(name, label){
  jQuery('#toogle_stages_button p').html('<span class="blue bold">' + label + '</span>');
  jQuery('#resa_stage_choice').val(name);

  var parameters = [];
  parameters.push(name, jQuery('#resa_jump').val());

  jQuery( "#datepicker" ).datepicker("option", "minDate", 0);
  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    dataType: 'JSON',
    data: {action: 'get_stage_diabled_dates' , parameters: parameters},
    success: function(res) {
      disabledDays = res.dates;

      jQuery('#datepicker').datepicker('refresh');
    }
  });

  toogle_stages();
}
