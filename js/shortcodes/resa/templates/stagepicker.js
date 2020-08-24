function show_stagepicker(){
  var stage_id = jQuery('#resa_stage_choice').val();

  if(stage_id.length == 0){
    alert("Sélectionnez un stage");
    return;
  }
  else if(jQuery('#resa_jump').val().length <= 0){
    alert('Sélectionnez un nombre de participant');
    return;
  }

  var activities = {
    "tramp": "Cours de trampoline",
    "free": "Cours de free-run",
    "rider": "Matériels rider"
  };
  var parameters = [];
  parameters.push(stage_id, jQuery('#resa_jump').val());

  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    dataType: 'JSON',
    async: false,
    cache: false,
    data: {action: 'get_stage_planning' , parameters: parameters},
    success: function(res) {
      console.info(res.activities);
      for (var i = 1; i <= 7; i++) {
        if(res.activities["day"+i+"m"]['activity'] != "null"){
          jQuery("#day"+i+"m").addClass(res.activities["day"+i+"m"]['activity']);
          jQuery("#day"+i+"m").html('<input type="checkbox" class="resa_stage_checkbox " data-date="'+res.activities["day"+i+"m"]['date']+'" data-hour="'+res.activities["day"+i+"m"]['hour']+'" data-activity="'+res.activities["day"+i+"m"]['activity']+'"/> <label>'+ activities[res.activities["day"+i+"m"]['activity']] +'</label>');
        }
        else{
          jQuery("#day"+i+"m").html('-');
        }

        if(res.activities["day"+i+"a"]['activity'] != "null"){
          jQuery("#day"+i+"a").addClass(res.activities["day"+i+"a"]['activity']);
          jQuery("#day"+i+"a").html('<input type="checkbox" class="resa_stage_checkbox" data-date="'+res.activities["day"+i+"a"]['date']+'" data-hour="'+res.activities["day"+i+"a"]['hour']+'" data-activity="'+res.activities["day"+i+"a"]['activity']+'"/> <label>'+ activities[res.activities["day"+i+"a"]['activity']] +'</label>');
        }
        else{
          jQuery("#day"+i+"a").html('-');
        }

      }
    }
  });

  jQuery('#stagepicker_container').css('display', 'flex');
}

function hide_stagepicker(){
  jQuery('#stagepicker_container').css('display', 'none');
}

function is_resa_selected(){
  valid = false;
  jQuery('.resa_stage_checkbox').each(function(){
    if(jQuery(this).is(':checked')){
      valid = true;
    }
  });

  return valid;
}

function get_resa_selected(){
  var stage_resa = '';

  jQuery('.resa_stage_checkbox').each(function(){
    if(jQuery(this).is(':checked')){
      var date = jQuery(this).attr('data-date');
      var hour = jQuery(this).attr('data-hour');

      stage_resa = stage_resa + date + '-'+ hour +',';
    }
  });

  return stage_resa;
}

function get_resa_list(){
  var stage_list = '';
  var activities = {
    "tramp": "Cours de trampoline",
    "free": "Cours de free-run",
    "rider": "Matériels rider"
  };

  jQuery('.resa_stage_checkbox').each(function(){
    if(jQuery(this).is(':checked')){
      var date = jQuery(this).attr('data-date');
      var hour = jQuery(this).attr('data-hour');
      var activity = jQuery(this).attr('data-activity');

      stage_list = stage_list+'<li>'+ date + ' à '+ hour +' ('+ activities[activity] +')</li>';
    }
  });

  return stage_list;
}

function valid_stage_resa(){
  if(!is_resa_selected()){
    alert('Merci de sélectionner un crénau de stage');
  }
  else{
    //Save info
    jQuery('#resa_date').val(get_resa_selected());
    jQuery('#resa_hour').val(get_resa_selected());
    jQuery('#resa_duration').val('3:00');

    jQuery('#recap_resa_list').html(get_resa_list());

    hide_stagepicker();
  }
}
