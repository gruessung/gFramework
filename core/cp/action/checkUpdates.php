<?php
  $db = new db();
  $db->query("SELECT * FROM ".pfw."_".plugins." ORDER BY id ASC");
  $nichtMehrVorhanden = array();
  $updateVorhanden = array();
  $keinUpdate = array();
  while ($row = $db->fetch()) {
    $us = new db();
    $us->query("SELECT * FROM ".pfw."_updateserver WHERE `id`='".$row->updateServer."';");
    $updateserver = $us->fetch();
    $extXmlInfo = simplexml_load_string(file_get_contents($updateserver->url."/get.php?comid=".$row->com_id));
    $null = true;
    foreach($extXmlInfo->extension as $ext) {
      $null = false;
    }

    if (!$null) {
      foreach($extXmlInfo->extension[0]->attributes() as $attribute => $wert) {
        $attr[$attribute] = $wert;
      }
      $pluginXml = simplexml_load_string(file_get_contents($updateserver->url."/".$attr['xml']));
      $newVersion = $pluginXml->version;
      if ($row->version >= $newVersion) {
        array_push($keinUpdate,$row->com_id);
      } 
        else 
      {
        array_push($updateVorhanden,$row->com_id."-".$row->version."-".$pluginXml->version."-".$row->name);
      }
    }
      else //Plugin nicht mehr in der Datenbank vorhanden
    {
      array_push($nichtMehrVorhanden,$row->com_id);
    }
  
  }  
echo '  
<div class="cel" style="height:auto;">
<form action="index.php?action=installUpdates" method="POST">
<table style="width:100%;">
  <tr style="border: 1px black solid;">
<td style="width:2%;">#</td><td style="width:20%;">Pluginname</td><td style="width:20%;">Versionsvergleich</td></tr></table><table style="width:100%;">';      

for ($i=0;$i<=count($updateVorhanden)-1;$i++){
      $x = explode("-",$updateVorhanden[$i]);
      echo '<tr style="border: 1px black solid;background-color:white;">
      <td style="width:2%;"><input type="checkbox" name="checkbox[]" value="'.$x[0].'" checked /></td><td style="width:20%;"><a href="http://update.gvisions.de/comm/index.php?app=2&comid='.$x[0].'">'.$x[3].'</a></td>
      <td style="width:20%;">Ihre Version: '.$x[1].'<br>neue Version: '.$x[2].'</td></tr>';
      
}
if (count($updateVorhanden) == 0) {
   echo "</table></div><br><b>Es ist kein Update vorhanden.</b></form>";
}
else
{
   	echo "</table></div><input type=\"submit\" name=\"update\" value=\"Updates installieren\"></form><pre>  ";
}

