<?php
  
  /*
  Checke die Paratemter in der GET
  */
  
  if ((!isset($_GET['appid']) OR !is_numeric($_GET['appid'])) AND !isset($_GET['comid'])){
    trigger_error("Die Variable \"appid\" ist entweder nicht übergeben worden oder entspricht nicht den Vorraussetzungen.",E_USER_ERROR);
  }
  $appid = 0;
  if (isset($_GET['comid']) && !empty($_GET['comid']))
  {
    $db = new db();
    $sql = "SELECT ID FROM ".pfw."_plugins WHERE `com_id` = '".mysql_real_escape_string($_GET['comid'])."';";
    $db->query($sql);
    $row = $db->fetch();
    if (!$row)
    {
      trigger_error("Anwendung ".mysql_real_escape_string($_GET['comid'])." nicht gefunden.",E_USER_ERROR);
    }
    $appid = $row->ID;

  }
  else
  {
    $appid = $_GET['appid'];
  }
  
  
  /*
  Baue DB Verb. auf
  */
  
  $db = new db();
  
  /*
  Schauen wir mal nach der  und laden alle Daten in ein array() ^^
  Und natürlich wider zählen
  */
  
  $db->query("SELECT * FROM ".pfw."_".plugins." WHERE ID = ".$appid);
  
  $row = $db->fetch();
  
  $num = $db->num_rows();
  
  /*
  Wenn jetzt $num = 0 oder > 1 ist, dan stimmt was nicht
  */
  
  if ($num != 1) {
    trigger_error("Die ID ist nicht vorhanden und/oder mehrmals vergeben. Dies macht eine eindeutige Identifikation unmöglich.",E_USER_ERROR);
  }
  
  /*
  So, dann schauen wir mal OptionFile an und laden die Datei hier rein^^
  */
  define("apppath",root."/apps/".$row->com_id."/");
  require_once(apppath."/cp/index.php");
  
  /*
  Für mich ist die Sache damit erledigt :)
  */