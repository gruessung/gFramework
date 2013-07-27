<?php
$test = new gUserManagement();
?>
Bereite Installation vor...
<?php
echo "<li>Lade Datei $xmlFile herunter</li>";		
$xmlFileName = basename($xmlFile);			  

copy($xmlFile,root."/temp/".$xmlFileName);
echo "<li>Kopiere Datei $xmlFileName nach ".root."temp/$xmlFileName</li>";
#copy($fileName,root."temp/".$fileName);	
chmod(root."temp/".$xmlFileName,0777) or die('Konnte Datei nicht kopieren.<br />');


echo "<li>Pr&uuml;fe Systemanforderungen....</li>";

$xml  = simplexml_load_file(root."temp/$xmlFileName");
$req = explode(",",$xml->requirements);
$anzahl = count($req);
$reqok = true;
for ($s=0;$s < $anzahl; $s++) {
  $req2 = explode("-",$req[$s]);
  $comid = $req2[0];
  $version = $req2[1];
  $db = new db();
  $sql ="SELECT * FROM ".pfw."_plugins WHERE `com_id` = '$comid' LIMIT 1;";
  $db->query($sql);
  $row = $db->fetch();
  echo "Ben�tige $comid-$version";

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
  die('<br><br><font color="red"><b>Leider sind die Vorraussetzungen nicht erf&uuml;llt. Installieren Sie erst die oben genannten Pakete.</b></font>');
}
else
{
  echo "<br><b><font color=green>Alle Anforderungen sind erf&uuml;llt. Fahren Sie fort.</b></font><br><br>";
}

echo "<a href=index.php?action=download&step=2&srv=$srv&file=$xmlFileName>Weiter</a>"  ;