<?php
if (!isset($_GET['sure'])) {
  echo 'Sind sie sich sicher ? <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?action=verwalten&comid='.$_GET['comid'].'&appid='.$_GET['appid'].'&ac=delete&id='.$_GET['pageid'].'&sure=true">Ja</a> | <a href="index.php?action=verwalten&comid='.$_GET['comid'].'&appid='.$_GET['appid'].'">Nein</a>';
} else {
  if (!is_numeric($_GET['id'])) {
    die('Fehler in der Parameter&uuml;bergabe');
  }
$db = new db();
$db->query('DELETE FROM `'.pfw.'_gvisions_news` WHERE `'.pfw.'_gvisions_news`.`id` = '.mysql_real_escape_string($_GET['id']).' LIMIT 1;');
$db->query('DELETE FROM `'.pfw.'_gvisions_news_comments` WHERE `'.pfw.'_gvisions_news_comments`.`newsid` = "'.mysql_real_escape_string($_GET['id']).'" LIMIT 1;');
echo "Der Artikel wurde gel&ouml;scht und die Kommentare entfernt";
}
?>