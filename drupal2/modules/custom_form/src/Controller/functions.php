<?php

function check_exist($name)
{
  $query = \Drupal::database()->select('player_data', 'player');
  $query->fields('player', ['Email'])->condition('Nickname' , $name);
  $result = $query->execute();

  while ($row = $result->fetchAssoc()) {
    	if($row['Email']==$email)
      return 1;
  }
}
?>
