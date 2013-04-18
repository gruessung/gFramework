<?php
if (!isset($_GET['sure'])) {
  echo 'Sind sie sich sicher ? <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?action=verwalten&comid='.$_GET['comid'].'&appid='.$_GET['appid'].'&ac=delete&pageid='.$_GET['pageid'].'&sure=true">Ja</a> | <a href="index.php?action=verwalten&comid='.$_GET['comid'].'&appid='.$_GET['appid'].'">Nein</a>';
} else {
  if (!is_numeric($_GET['pageid'])) {
    die('Fehler in der Parameter&uuml;bergabe');
  }
$db = new db();
$db->query('SELECT * FROM '.pfw.'_gmoonpages WHERE id = '.mysql_real_escape_string($_GET['pageid']).'');
$row = $db->fetch();
if ($row->delete=="false") {
  echo"Die Seite konnte nicht gel&ouml;scht werden: <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[Information] Diese Seite ist vor dem l&ouml;schen gesch&uuml;tzt.";
} else {
$db->query('DELETE FROM `'.pfw.'_gmoonpages` WHERE `'.pfw.'_gmoonpages`.`id` = '.mysql_real_escape_string($_GET['pageid']).' LIMIT 1;');
$db->query('DELETE FROM `'.pfw.'_menuentries` WHERE `'.pfw.'_menuentries`.`link` = "pageid='.mysql_real_escape_string($_GET['pageid']).'" LIMIT 1;');
echo "Die Seite wurde gel&ouml;scht und aus den Menus entfernt!";
}
}
?>