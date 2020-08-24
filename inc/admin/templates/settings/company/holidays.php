<?php
global $wpdb;

if(isset($_POST['add_holiday']) AND $_POST['add_holiday'] == 'added'):
  if(!empty($_POST['holiday_title']) AND !empty($_POST['holiday_start_date']) AND !empty($_POST['holiday_end_date'])):
    $wpdb->insert("{$wpdb->prefix}company_holidays", array('title' => $_POST['holiday_title'], 'start_date' => fullinparkResaManager::convertDateFormat($_POST['holiday_start_date']), 'end_date' => fullinparkResaManager::convertDateFormat($_POST['holiday_end_date'])));
  endif;
endif;

$all_holiday = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}company_holidays");  ?>

<div>
  <div>
    <?php
    if(count($all_holiday) == 0):
      echo '<p>Aucune date de vacances enregistrée</p>';
    else:
      foreach ($all_holiday as $holiday): ?>
        <div>
          <p><?php echo $holiday->title; ?></p>
          <p><?php echo date('d/m/Y', strtotime($holiday->start_date)); ?></p>
          <p><?php echo date('d/m/Y', strtotime($holiday->end_date)); ?></p>
        </div>
        <?php
      endforeach;
    endif; ?>
  </div>

  <div>
    <form action="#" method="POST">
      <div>
        <label>Titre</label>
        <input type="text" name="holiday_title" id="holiday_title"/>
      </div>

      <div>
        <label>Date de début</label>
        <input type="text" name="holiday_start_date" id="holiday_start_date"/>
      </div>

      <div>
        <label>Date de fin</label>
        <input type="text" name="holiday_end_date" id="holiday_end_date"/>
      </div>

      <input type="hidden" name="add_holiday" value="added"/>
      <button type="submit">Ajouter</button>
    </form>
  </div>
</div>
