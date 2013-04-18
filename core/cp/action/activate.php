<?php
  $id = mysql_real_escape_string($_GET['appid']);
  if (!is_numeric($id))
  {
    trigger_error("Parameter appid oder styleid fehlerhaft.",E_USER_ERROR);
  }
  
  $db = new db();
  $db->query("SELECT * FROM ".pfw."_plugins WHERE id = $id");
  $row = $db->fetch();
  
  $new = "true";
  if ($row->activate == "true" || $row->activate == "1")
  {
    $new = "false";
  }
  
  $db->query("UPDATE ".pfw."_plugins SET `activate`='$new' WHERE id = $id;");
  
  echo "Der Status der Erweiterung wurde erfolgreich ge&auml;ndert.";