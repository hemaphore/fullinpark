function change_display_mode(elem){
  alert(jQuery(elem).val());
}

function show_resa_popup(section, activity, hour){
  jQuery('.fullinpark_planning_elem_popup').hide();
  jQuery('#fullinpark_planning_elem_popup_'+section+'_'+activity+'_'+hour).show();
}

function show_resa_anniv_popup(section, activity, hour, extra){
  jQuery('.fullinpark_planning_elem_popup').hide();
  jQuery('#fullinpark_planning_elem_popup_'+section+'_'+activity+'_'+hour+extra).show();
}

function show_user_infos(elem){
  jQuery(elem).parent().find('.popup_user_infos').show();
}

function hide_user_infos(elem){
  jQuery(elem).parent().hide();
}

function hide_resa_popup(id){
  jQuery(id).hide();
}

function modify_current_date(){
  jQuery('#datepicker_planning_nav_container').css('display', 'flex');
}

function hide_datepicker_popup(){
  jQuery('#datepicker_planning_nav_container').hide();
}

function register_resa_extra_infos(id, section, hour){
  var arrived = jQuery('#resa_arrived_'+section+'_'+id+'_'+hour).val();
  var out = jQuery('#resa_out_'+section+'_'+id+'_'+hour).val();
  var notes = jQuery('#resa_notes_'+id+'_'+hour).val();

  jQuery('.popup_modify_button').hide();

  //Ajax
  var parameters = [];
  parameters.push(id, arrived, out, notes, section);

  jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    async: false,
    cache: false,
    dataType: 'JSON',
    data: {action: 'add_extra_infos_to_resa', parameters: parameters},
    success: function(res) {
      alert('Modifié !');
      document.location.href = document.location.href;
    }
  });
}

function dateDiff(date1, date2){
    var diff = {}                           // Initialisation du retour
    var tmp = date2 - date1;

    tmp = Math.floor(tmp/1000);             // Nombre de secondes entre les 2 dates
    diff.sec = tmp % 60;                    // Extraction du nombre de secondes

    tmp = Math.floor((tmp-diff.sec)/60);    // Nombre de minutes (partie entière)
    diff.min = tmp % 60;                    // Extraction du nombre de minutes

    tmp = Math.floor((tmp-diff.min)/60);    // Nombre d'heures (entières)
    diff.hour = tmp % 24;                   // Extraction du nombre d'heures

    tmp = Math.floor((tmp-diff.hour)/24);   // Nombre de jours restants
    diff.day = tmp;

    return diff;
}

function datepicker_select_new_date(dateText){
  var dateTmp = new Date().toISOString().split('T')[0];
  date1 = new Date(dateTmp);
  date2 = new Date(dateText);
  diff = dateDiff(date1, date2);

  document.location = "http://fullinpa.odns.fr/wp-admin/admin.php?page=fullinpark_admin&day="+diff.day;
}

jQuery(function(){
  jQuery.datepicker.setDefaults(jQuery.datepicker.regional["fr"]);
  jQuery( "#datepicker_planning_nav" ).datepicker({
    dateFormat: "yy-mm-dd",
    firstDay: 1,
    minDate: "-2m",
    maxDate: "+6m",
    loseText: 'Fermer',
    prevText: 'Précédent',
    nextText: 'Suivant',
    currentText: 'Aujourd\'hui',
    monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
    monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
    dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
    dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
    weekHeader: 'Sem.',
    showOtherMonths:true,
    selectOtherMonths: false,
    regional : 'fr',
    onSelect: function(dateText) {
      datepicker_select_new_date(dateText);
    }
  });

  jQuery('.resa_listing').each(function(){
    /*var items = jQuery(this).children('li').get();
    items.sort(function(a, b){
        return +jQuery(a).data('name') - +jQuery(b).data('name');
    });

    items.appendTo('ul');*/

    jQuery(this).children().detach().sort(function(a, b) {
      return jQuery(a).attr('data-name').localeCompare(jQuery(b).attr('data-name'));
    }).appendTo(jQuery(this));
  });
});
