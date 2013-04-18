<?php
$test = new UserManagement();   #geht dies nicht, wird die Datei manuell aufgerufen, das wollen wir nicht xd

$zip= new ZipArchive;
echo "<li>&Ouml;ffne ".root."temp/$xmlFileName und lese aus...</li>";
$xml = simplexml_load_file(root."temp/$xmlFileName");
$downloadFile = $xml->zipfile;
if ($lokal)
{
  $downloadFile = preg_replace("%PFAD%", root."/upload/", $downloadFile);
}
$comid = $xml->comid;
$desc = $xml->desc;
$version = $xml->version;
$name = $xml->name;
$fileName = basename($downloadFile);
$path = $xml->installpath;
$installPath = root.$path.$comid;
echo "<li>Lade Datei $downloadFile herunter</li>";		
			  

copy($downloadFile,root."/temp/".$fileName);
echo "<li>Kopiere Datei $fileName nach ".root."temp/$fileName</li>";
#copy($fileName,root."temp/".$fileName);	
chmod(root."temp/".$fileName,0777) or die('Konnte Datei nicht kopieren.<br />');


if ($xml->type=="style") {
  $newExt = new Style();
} elseif ($xml->type=="plugin") {
  $newExt = new plugin();
} else {
  trigger_error("Typenzuordnung nicht möglich. Fehler in XML Datei.",E_USER_ERROR);
}




/*
Entpacke und registriere Erweiterung
*/

                  
echo "<li>Registriere ".$xml->typede." in der Datenbank...";
if ($newExt->Registration($name,$desc,$comid,$installPath,$version,$srv,true) OR isset($_GET['forceupdate'])) {
echo "<li>".$xml->typede." wurde registriert</li>";
echo "<li>Entpacke ".$xml->typede." nach $installPath</li>";
if ($zip->open(root."/temp/".$fileName) === TRUE) {

$zip->extractTo($installPath);
$zip->close();

echo '<li>'.$xml->typede.' entpackt</li>';
if (isset($_GET['forceupdate'])) {
  $newExt->Update("version",$version,$comid);
  echo "<li>Version wurde in der Datenbank auf $version ge&auml;ndert.</li>";
}

}
 
else {
echo 'Fehler beim entpacken!<br />';
$newExt->Delete($comid);
echo $xml->typede." wurde aus der Datenbank gelöscht<br />";
@unlink(root."temp/".$fileName);
echo "<li>Temporäre Dateien wurden gelöscht";
#}
}
if (!empty($xml->installsql)) {
  $db = new db();
  echo "<li>Datenbank wird angepasst:<br><blockqoute><i>".preg_replace("%PFW%",pfw,$xml->installsql)."</i></blockquote><br></li>";
  
  $data = explode(";",$xml->installsql);
  
  foreach ($data as $que)
  {
    $que = preg_replace("%AID%",$newExt->getID($comid),$que);
    if($db->query(preg_replace("%PFW%",pfw,$que))==false) {  
    echo "<li>Fehler beim vornehmen der Datenbank&auml;nderungen";
    $newExt->Delete($comid);
    echo $xml->typede." wurde aus der Datenbank gelöscht<br />";
    }
    else 
    {
    echo "<li>Datenbank&auml;nderungen wurden vorgenommen...";
    }
  }
}
} else {
echo "<li><b>".$xml->typede." ist bereits registriert. Daten werden nicht entpackt</b><br>";
$aktuelleVersion = $newExt->getVersion($comid);
echo "<br>Wollen Sie die bereits vorhandene Version $aktuelleVersion durch die Version ".$version." ersetzen? Dabei werden die Daten im ".$xml->typede."verzeichnis &uuml;berschrieben.<br><a href=\"index.php?action=download&srv=$srv&file=$xmlFileName&step=3&forceupdate\">Ja, weiter.</a><br><a href=\"index.php?file=$xmlFileName&action=download&srv=$srv&step=0\">Nein, aufh&ouml;ren!</a></li>";
}

echo "<li>Fertig</li>";
echo '</ul>';
