<?php
$day_of_week = array(
  'lundi',
  'mardi',
  'mercredi',
  'jeudi',
  'vendredi',
  'samedi',
  'dimanche'
);

if(isset($_POST['update_open_hours']) AND $_POST['update_open_hours'] == 'updated'):
  foreach($day_of_week as &$value):
    if($_POST['open_hours_'.$value]):
      fullinparkCompanyManager::set_day_open_hours($value, false, false, $_POST['open_hours_'.$value.'_start_hour'], $_POST['open_hours_'.$value.'_end_hour']);
    else:
      fullinparkCompanyManager::get_day_open_hours($value, false, true);
    endif;


    if($_POST['open_hours_'.$value.'_holiday']):
      fullinparkCompanyManager::set_day_open_hours($value, true, false, $_POST['open_hours_'.$value.'_holiday_start_hour'], $_POST['open_hours_'.$value.'_holiday_end_hour']);
    else:
      fullinparkCompanyManager::set_day_open_hours($value, true, true);
    endif;
  endforeach;
endif;  ?>

<div>
  <form action="#" method="POST">
    <p>Horaires d'ouverture<p>

    <div>
      <?php
      foreach($day_of_week as &$value):
        $day_infos = fullinparkCompanyManager::get_day_open_hours($value, false); ?>

        <div class="main_label_container">
          <label class="main_label"><?php echo ucfirst($value); ?></label>
          <div class="wrapper">
            <div class="switch_box box_1">
              <input type="checkbox" name="open_hours_<?php echo $value; ?>" id="open_hours_<?php echo $value; ?>_input" class="switch_1" onchange="toogle_sub_section('#open_hours_<?php echo $value; ?>');" <?php echo ($day_infos[0]->close) ? '' : 'checked'; ?>/>
            </div>
          </div>
        </div>

        <div id="open_hours_<?php echo $value; ?>" class="open_hours_container" <?php echo ($day_infos[0]->close) ? 'style="display: none;"' : ''; ?>>
          <div>
            <label>Heure de début</label>
            <input type="text" name="open_hours_<?php echo $value; ?>_start_hour" value="<?php echo $day_infos[0]->start_hour; ?>"/>
          </div>


          <div>
            <label>Heure de fin</label>
            <input type="text" name="open_hours_<?php echo $value; ?>_end_hour" value="<?php echo $day_infos[0]->end_hour; ?>"/>
          </div>
        </div><?php
      endforeach; ?>
    </div>

    <button type="submit" class="button button-primary">Modifier</button>

    <p>Horaires d'ouverture (Vacances)<p>

    <div>
      <?php
      foreach($day_of_week as &$value):
        $day_infos = fullinparkCompanyManager::get_day_open_hours($value, true); ?>

        <div class="main_label_container">
          <label class="main_label"><?php echo ucfirst($value); ?></label>
          <div class="wrapper">
            <div class="switch_box box_1">
              <input type="checkbox" name="open_hours_<?php echo $value; ?>_holiday" id="open_hours_<?php echo $value; ?>_holiday_input" class="switch_1" onchange="show_sub_section('#open_hours_<?php echo $value; ?>_holiday');" <?php echo ($day_infos[0]->close) ? '' : 'checked'; ?>/>
            </div>
          </div>
        </div>

        <div id="open_hours_<?php echo $value; ?>_holiday" class="open_hours_container" <?php echo ($day_infos[0]->close) ? 'style="display: none;"' : ''; ?>>
          <div>
            <label>Heure de début</label>
            <input type="text" name="open_hours_<?php echo $value; ?>_holiday_start_hour" value="<?php echo $day_infos[0]->start_hour; ?>"/>
          </div>


          <div>
            <label>Heure de fin</label>
            <input type="text" name="open_hours_<?php echo $value; ?>_holiday_end_hour" value="<?php echo $day_infos[0]->end_hour; ?>"/>
          </div>
        </div><?php
      endforeach; ?>
    </div>

    <input type="hidden" name="update_open_hours" value="updated"/>
    <button type="submit" class="button button-primary">Modifier</button>
  </form>
</div>

<style>
.open_hours_container{
  display: flex;
  margin-bottom: 1em;
}
.open_hours_container div{  margin-right: 2em;  }
</style>
