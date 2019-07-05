<?php

function check_exist($name, $email)
{
  $query = \Drupal::database()->select('player_data', 'player');
  $query->fields('player', ['Nickname','Email']);
  $result = $query->execute();

  while ($row = $result->fetchAssoc()) {
    	if($row['Email']==$email)
      return 1;
  }
}
?>
