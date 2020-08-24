<div>
  <div id="company_nav">
    <ul>
      <li><a href="<?php echo $url.'&subpage=company'; ?>">Horaires</a></li>
      <li><a href="<?php echo $url.'&subpage=company&section=holidays'; ?>">Vacances</a></li>
      <li><a href="<?php echo $url.'&subpage=company&section=exceptional_opening_closure'; ?>">Ouvertures/Fermetures exceptionnelles</a></li>
    </ul>
  </div>

  <?php
  if(isset($_GET['section']) AND $_GET['section'] == 'holidays'):
    require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/settings/company/holidays.php');
  elseif(isset($_GET['section']) AND $_GET['section'] == 'exceptional_opening_closure'):
    require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/settings/company/exceptional_opening_closure.php');
  else:
    require(PLUGIN_FIP_DIRECTORY.'inc/admin/templates/settings/company/open_hours.php');
  endif;  ?>
</div>

<style>
#company_nav ul{  display: flex;  }
#company_nav ul li{ margin-right: 1em; }
</style>
