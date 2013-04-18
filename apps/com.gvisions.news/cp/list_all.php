<style>.tr {

  border: 1px black solid;

  background-color: lightgrey;

}

</style> 
<?php
/**
 * gNews Administration
 */
$ac ="";
if (isset($_GET["ac"])) { $action = $_GET["ac"]; }

$sql = new db();
$sql->query("SELECT * FROM ".pfw."_gvisions_news ORDER BY id DESC");
$tabelle = "";
$comid = "";
if (isset($_GET['comid'])) $comid = $_GET['comid'];

$appid = "";
if (isset($_GET['appid'])) $appid = $_GET['appid'];
while ($row = $sql->fetch()){

$tabelle .='  
  <tr class="tr">
              <td>'.$row->date.'</td>
              <td>'.$row->titel.'</td>
              <td><a href="index.php?action=verwalten&appid='.$appid.'&comid='.$comid.'&ac=edit&id='.$row->id.'">Bearbeiten</a> | <a   href="index.php?action=verwalten&appid='.$appid.'&comid='.$comid.'&ac=delete&pageid='.$row->id.'">L&ouml;schen</a></td>
  </tr>';
}
$tabelle .="
";
$zahl = $sql->num_rows();
echo "<br>

Seiten: $zahl | <a href=\"index.php?action=verwalten&comid=".$comid."&appid=".$appid."&ac=new\">Neuen Artikel anlegen</a> <br />

<table style='border: 1px black solid; background-color:grey; color:black; width:70%;'>
  <tr style='border: 1px black solid;'>
    <td style='width:10%;'>Datum</td>
    <td style='width:50%;'>Titel</td>
    <td style='width:30%;'>Optionen</td>
  </tr>




".$tabelle."</table><br />";
