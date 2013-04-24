

<?php
  $db = new db();
  $count = count($_POST['checkbox']);
  for ($i=0;$i<=$count-1;$i++) {
    $db->query("SELECT * FROM ".pfw."_plugins WHERE `com_id` = '".$_POST['checkbox'][$i]."';");
    $row = $db->fetch();
    $db_us = new db();
    $db_us->query("SELECT * FROM ".pfw."_updateserver WHERE id = ".$row->updateServer);
    $updsrv = $db_us->fetch();
    
    $xml = simplexml_load_string(file_get_contents($updsrv->url."/get.php?comid=".$row->com_id));
    $updXml = $updsrv->url."/".$xml->extension[0]->attributes()->xml;
    $xml = simplexml_load_string(file_get_contents($updXml));
    echo "<li>Beginne Update f&uuml;r ".$row->name."!</li>";
    echo "<li>Pr&uuml;fe Systemanforderungen f�r ".$row->name."...</li>";

    $req = explode(",",$xml->requirements);
    $anzahl = count($req);
    if (empty($xml->requirements)) { $anzahl = 0; }
    $reqok = true;
    for ($s=0;$s < $anzahl; $s++) {
      $req2 = explode("-",$req[$s]);
      $comid = $req2[0];
      $version = $req2[1];
      $db = new db();
      $sql ="SELECT * FROM ".pfw."_plugins WHERE `com_id` = '$comid' LIMIT 1;";
      $db->query($sql);
      $row = $db->fetch();
      echo "Ben&ouml;tige $comid-$version";
    
      if (empty($row->version)) { $vorhanden = "nicht installiert"; } else { $vorhanden = $row->version; }
      if ($version <= $vorhanden AND $vorhanden != "nicht installiert") {
        echo '<font color="green"> - vorhanden: '.$vorhanden."<br></font>";
      }
      else
      {
        echo '<font color="red"> - vorhanden: '.$vorhanden."<br></font>";
        $reqok=false;
      }
    
    }
    
    if (!$reqok) {
      echo('<li><b><font color="red"><b>Leider sind die Vorraussetzungen nicht erf&uuml;llt. Installieren Sie erst die oben genannten Pakete.</b></font></li><br><br>');
      continue;
    }
    else
    {
      echo "<li><b><font color=green>Alle Anforderungen sind erf&uuml;llt. Installiere Update.</b></font></li>";
      $downloadFile = $xml->zipfile;
$comid = $xml->comid;
$desc = $xml->desc;
$version = $xml->version;
$name = $xml->name;
$fileName = basename($downloadFile);
$path = $xml->installpath;
$installPath = root.$path.$comid;
echo "<li>Lade Datei $downloadFile herunter</li>";		
			  
$zip= new ZipArchive;
copy($downloadFile,root."/temp/".$fileName);
echo "<li>Kopiere Datei $fileName nach ".root."temp/$fileName</li>";
#copy($fileName,root."temp/".$fileName);	
if(chmod(root."temp/".$fileName,0777)==false) {
echo('<li><font color="red"><b>Konnte Datei nicht kopieren. Abbruch.</font><br /><br></b></li>');
continue;
}
if ($xml->type=="style") {
  $newExt = new Style();
} elseif ($xml->type=="plugin") {
  $newExt = new plugin();
} else {
  trigger_error("Typenzuordnung nicht m&ouml;glich. Fehler in XML Datei.",E_USER_ERROR);
}

echo "<li>Entpacke ".$xml->typede." nach $installPath</li>";
if ($zip->open(root."/temp/".$fileName) === TRUE) {

$zip->extractTo($installPath);
$zip->close();
  $newExt->Update("version",$version,$comid);
  echo "<li>Version wurde in der Datenbank auf $version ge&auml;ndert.</li>";
}
else
{
echo "<li><b>Fehler beim entpacken! Abbruch.<br><br></li>";
continue;
}
  
      
      $sql = preg_replace("%PFW%",pfw,$xml->updatesql);
      if ($sql!="") {
        $db_update = new db();
		$queries = explode(";", $sql);
		for ($u = 0; $u < count($queries) - 1; $u++)
		{
			$db_update->query($queries[$u]);	
		}
        
        echo "<li>Plugintabelle in der Datenbank wurde editiert.</li>";
      
      }
      else
      {
        echo "<li>Plugintabelle in der Datenbank wurde nicht editiert.</li>";
      }
      
    }
    
echo '<li><b><font color="green">Update fertig.<br><br></font></b></li>';    
  }