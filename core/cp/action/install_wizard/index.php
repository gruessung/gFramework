<?php

$test = new UserManagement();
date_default_timezone_set('UTC');
/*
  gFramework Install Wizward for new applications and styles
*/

if (!Isset($_GET['step']) OR !is_numeric($_GET['step'])) {trigger_error("Paramater step fehlt oder ist falsch!",E_USER_ERROR);}


$step = $_GET['step'];
$pfad = preg_replace("%index.php%","",__FILE__ );
require_once($pfad."/../../../init.php");
$xmlFile = $_GET['file'];
$sql = new db();
#var_dump($_GET);
$srv = $_GET['srv'];
if (empty($srv) && $srv != "0") { die("Kein Updateserver vorhanden."); }
$sql->query("SELECT * FROM ".pfw."_updateserver WHERE `id` = '$srv'");
$x = $sql->fetch();

if ($srv == "0")
{
  $url = root."/upload/";
  $lokal = true;
}
else
{
  $url = $x->url;
  $lokal = false;
}

$xmlFile =  $url.$xmlFile;
$xmlFileName = basename($xmlFile);

$gInstall = new Install();

$t = require_once("$pfad/step$step.php");
if (!$t) { trigger_error("File step$step.php not found.",E_USER_ERROR); }

?>