<?php
global $wpdb;
$url = esc_url(home_url()).'/wp-admin/admin.php?page=fullinpark_team';

if(isset($_GET['add_team_member'])):
  if(isset($_POST['add_team_member']) AND $_POST['add_team_member'] == "added"):
    $wpdb->insert("{$wpdb->prefix}team_member", array('first_name' => $_POST['team_member_first_name'], 'last_name' => $_POST['team_member_last_name']));

    echo '<p class="submit_message">Membre ajouté à l\'équipe</p>';
  endif;  ?>

  <div id="add_team_member_page">
    <a class="return_link" href="<?php echo $url; ?>">Retour</a>

    <form action="#" method="POST">
      <div class="form_row">
        <label>Prénom:</label>
        <input type="text" name="team_member_first_name"/>
      </div>

      <div class="form_row">
        <label>Nom:</label>
        <input type="text" name="team_member_last_name"/>
      </div>

      <input type="hidden" name="add_team_member" value="added"/>
      <button>Ajouter</button>
    </form>
  </div>
  <?php
else:
  $all_team_member = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}team_member");  ?>

  <div id="team_member_page">
    <div id="add_team_member_link_container">
      <a id="add_team_member_link" href="<?php echo $url.'&add_team_member=1';?>">Ajouter un membre à l'équipe</a>
    </div>

    <table>
      <thead>
        <tr>
          <th>Prénom</th>
          <th>Nom</th>
        </tr>
      </thead>

      <tbody>
        <?php
        foreach($all_team_member as $team_member):  ?>
          <tr>
            <td><?php echo $team_member->first_name;  ?></td>
            <td><?php echo $team_member->last_name;  ?></td>
          </tr><?php
        endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php
endif;
