<?php
  if (isset($_GET['appid']) && is_numeric($_GET['appid']))
  {
      $id = mysql_real_escape_string($_GET['appid']);
      $para = "appid";
  }
  elseif (isset($_GET['styleid']) && is_numeric($_GET['appid']))
  {
       $id = mysql_real_escape_string($_GET['styleid']);
       $para = "styleid";
  }
  else
  {
    trigger_error("Parameter appid oder styleid fehlerhaft.",E_USER_ERROR);
  }
  
  
  if (!isset($_GET['sure']))
  {
    echo "Sind Sie sich <b>sicher</b>, dass Sie die Erweiterung / den Style <b>vollst&auml;nstig</b> l&ouml;schen wollen?<br>";
    echo '<a href="index.php?action=unistall&'.$para.'='.$id.'&sure">Ja</a>&nbsp;|&nbsp;<a href="index.php?action=list">Nein</a>';
    die();
  }
  $db = new db();
  $sql = "
    SELECT p . * , srv.url AS uSrv
    FROM gframework_plugins p, gframework_updateserver srv
    WHERE p.id = $id
    AND srv.id = p.updateServer
    ";
  $db->query($sql);
  $row = $db->fetch();
  $id = $row->id;
  $path = $row->path;
  $comid = $row->com_id;
  $name = $row->name;
  $uSrv = $row->uSrv;
  
  echo 'Deinstalliere '.$name.'...<br>';
  echo "<li>Lade XML Datei von $uSrv</li>";
