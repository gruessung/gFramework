

<?php
/*
Ok, der Nutzer will was installieren...
Schauen wir doch ersteinmal, ob fopen aktiv ist :)
*/

if (ini_get('allow_url_fopen')=="0" OR ini_get('allow_url_include')=="0") {
  echo 'Leider k&ouml;nnen Sie die praktische Installationsm&ouml;glichkeit nicht nutzen, da auf Ihren Webspace allow_url_fopen = Off; ist.<br /> Wenden Sie sich bei Bedarf an Ihren Hoster.';
}
    
echo '<a href="index.php?action=install_upload">Installation per Upload</a><br>';
                               
/*
Hole alle Server aus der DB
*/
$db = new db();
$server = array ();

$db->query("SELECT * FROM ".pfw."_updateserver WHERE id != 0 ORDER BY id");
$a=0;
while ($row = $db->fetch()) {
	$server[$a]['id']=$row->id;
	$server[$a]['url']=$row->url;
	$server[$a]['name']=$row->name;
	$a++;
}


/*
Lade die Serverpluginlisten
*/
$c = 0;
$b = $a;
$a = 0;
while ($c < $b) {
  $srvnr = $a;
  $srvname = $server[$a]['name'];
  $srvurl = $server[$a]['url'];
  $srvid = $server[$a]['id'];
  $xml = file_get_contents( $server[$a]['url']."get.php?type=plugin");
  if (!$xml)
  {
    echo "<b>Fehler beim Laden.</b><br>";
  }
  $xml = simplexml_load_string($xml);
  $j = 0;
  echo 'Pluginserver '.($a + 1).': '.$server[$a]['name'].'<br /><div class="cel" style="height:auto;">
<table style="width:100%;">
  <tr style="border: 1px black solid;">
<td style="width:5%;">#</td><td style="width:20%;">Pluginname</td><td style="width:20%;">Optionen</td></tr></table><table style="width:100%;">';
  foreach($xml->extension as $ext) {
    foreach($ext->attributes() as $attribute => $wert) {
      $attr[$attribute] = $wert;
     }
      echo '<tr style="border: 1px black solid;background-color:white;">
      <td style="width:5%;">'.($j+1).'</td><td style="width:20%;"><a href="http://site.gvisions.de/index.php?app_comid=com.gvisions.gallery&comid='.$attr['comid'].'">'.$attr['name'].'</a></td>
      <td style="width:20%;"><a href="index.php?action=download&file='.$attr['xml'].'&srv='.$srvid.'&step=1">Installieren</a></td></tr>';
     
  }
	echo "</table></div><br /><br />";	

	$c++;
	$a++;
	
}



/*
Lade die Serverstylelisten
*/
$c = 0;
$b = $a;
$a = 0;
while ($c < $b) {
  $srvnr = $a;
  $srvname = $server[$a]['name'];
  $srvurl = $server[$a]['url'];
  $srvid = $server[$a]['id'];
  $xml = file_get_contents( $server[$a]['url']."get.php?type=style");
  if (!$xml)
  {
    echo "<b>Fehler beim Laden.</b><br>";
  }
  $xml = simplexml_load_string($xml);
  $j = 0;
  echo 'Styleserver '.($a+1).': '.$server[$a]['name'].'<br /><div class="cel" style="height:auto;"><table style="width:100%;">
  <tr style="border: 1px black solid;">
<td style="width:5%;">#</td><td style="width:20%;">Stylename</td><td style="width:20%;">Optionen</td></tr></table><table style="width:100%;">';
  foreach($xml->extension as $ext) {
    foreach($xml->extension[$j]->attributes() as $attribute => $wert) {
      $attr[$attribute] = $wert;
    }
      echo '<tr style="border: 1px black solid;background-color:white;">
      <td style="width:5%;">'.($j+1).'</td><td style="width:20%;"><a href="http://site.gvisions.de/index.php?app_comid=com.gvisions.gallery&comid='.$attr['comid'].'">'.$attr['name'].'</a></td>
      <td style="width:20%;"><a href="index.php?action=download&file='.$attr['xml'].'&srv='.$srvid.'&step=1">Installieren</a></td></tr>';
    
  }
	echo "</table></div><br /><br />";	

	$c++;
	$a++;
	
}