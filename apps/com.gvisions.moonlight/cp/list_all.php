<?php

$comid = "";
if (isset($_GET['comid'])) $comid = $_GET['comid'];

$appid = "";
if (isset($_GET['appid'])) $appid = $_GET['appid'];

$menu="<form action=\"index.php?action=verwalten&comid=".$comid."&appid=".$appid."&\" method=\"POST\"><select name=\"menuid\">";
$sql = new db();                  
$sql->query("SELECT * FROM ".pfw."_menus ORDER BY id ASC");
while ($row = $sql->fetch()){
$menu .='<option value="'.$row->id.'" >'.$row->name.'</option>';
}                              
$menu .="<input type=\"submit\" value=\"Anzeigen\" name=\"go\" /></select></form>";


$tabelle="<style>.tr {
  border: 1px black solid;
  background-color: lightgrey;
}
</style>";
$sql = new db();
If (!isset($_POST['menuid'])) { $menuid = 1; } else { $menuid = @$_POST['menuid']; }
if ($menuid) { $zusatz = "WHERE menu = ".$menuid;}else{ $zusatz="WHERE menu = 1";}
$sql->query("SELECT * FROM ".pfw."_gmoonpages WHERE `menu` = '".$menuid."' ORDER BY id ASC");
while ($row = $sql->fetch()){

$tabelle .='  
  <tr class="tr">
              <td>'.$row->id.'</td>
              <td>'.$row->titel.'</td>
              <td><a href="index.php?action=verwalten&appid='.$appid.'&comid='.$comid.'&ac=edit&pageid='.$row->id.'">Bearbeiten</a> | <a   href="index.php?action=verwalten&appid='.$appid.'&comid='.$comid.'&ac=delete&pageid='.$row->id.'">L&ouml;schen</a></td>
  </tr>';
}
$tabelle .="
";
$zahl = $sql->num_rows();
echo "<br>

Seiten: $zahl | <a href=\"index.php?action=verwalten&comid=".$comid."&appid=".$appid."&ac=new\">Neue Seite anlegen</a> <br />

<table style='border: 1px black solid; background-color:grey; color:black; width:70%;'>
  <tr style='border: 1px black solid;'>
    <td style='width:10%;'>ID</td>
    <td style='width:50%;'>Titel</td>
    <td style='width:30%;'>Optionen</td>
  </tr>




".$tabelle."</table><br />Nach Menu sortieren: ".$menu;
