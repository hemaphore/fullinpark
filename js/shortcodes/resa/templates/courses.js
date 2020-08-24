var disabledDays = new Array();

function toogle_collective_course(){
  jQuery('#custom_select_collectives_courses').toggleClass('active');
  jQuery('#toogle_collectives_courses_button').toggleClass('active');
}

function collective_course_selected(name, label){
  jQuery('#toogle_collectives_courses_button p').html('<span class="blue bold">' + label + '</span>');
  jQuery('#resa_collective_course_choice').val(name);

  var parameters = [];
  parameters.push(name);

  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    dataType: 'JSON',
    data: {action: 'get_disabled_date_for_collective_course', parameters: parameters},
    success: function(res) {
      disabledDays = res.dates;

      jQuery('#datepicker').datepicker('refresh');
    }
  });

  toogle_collective_course();
}
