<?php
    $styleid = $_GET['styleid'];
    if (!isset($_GET['styleid']) or !is_numeric($_GET['styleid'])) { 
      trigger_error("Wie soll ich ohne Styleid arbeiten!?",E_USER_ERROR);
    }
    
    if (isset($_GET['activate'])) {
      $db = new db();
      $db->query("SELECT * FROM  `".db."`.`".pfw."_styles`  WHERE  `".pfw."_styles`.`id` ='$styleid';");
      $row = $db->fetch();
      $cfg = new gConfig();
      $cfg->update("style",$row->com_id);
      
      echo "Style wurde aktiviert und wird nun von allen Apps verwendet, welche keine gesonderten Optionen bereitstellen.";
    } 
    else
    {
      echo 'Soll der Style aktiviert werden?<br><a href="index.php?action=verwalten&appid=1&ac=editStyle&styleid='.$styleid.'&activate">Ja</a> | <a href="index.php">Nein</a>';
    }  
?>