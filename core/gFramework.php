<?php
error_reporting(E_ALL); @session_start(); 
 /*
   Dies ist die Hauptdatei des gFramework.
   Diese Datei durchsucht den Ordner "classes" nach alles Dateien nach dem Namensmster g*.php und includiert diese.
   (c) 2009 gVisions
   www.gvisions.de
 */

 class gFramework
 {
 
 }
 
 
$debug = "<!-- \n\n***FRAMEWORK-DEBUG***\n";
$debug .=  "Lade Pfad-Dateien...\n";



define("root",preg_replace("%core%", "", dirname(__FILE__)));	
define("core",root."core/");	


$debug .=  "Fertig.\n\n";
$debug .=  "Lade mysql Konfigurationsdaten.....".core."/config/mysql.php \n";
require_once(core."/config/mysql.php");
require_once(core."/config/mysql_tables.php");
$debug .=  "\nFertig!\nLade Frameworkklassen...\n";

foreach (glob(core."/classes/g*.php") as $filename) {
    $file = $filename;
    $t = require_once $file;
    
    if ($t==false ) { trigger_error("Fehler beim einbinden der Datei $file",E_USER_ERROR);}
   $debug.=  "*** Includiere Frameworkklasse: ".$file." - Groesse: " . filesize($filename) . "kb\n";
}
$debug .= "Lade Config aus Datenbank...\n";
/* Verbinde nun zur mySQL DB */
$dbc = new db();
$dbc->connect($host,$user,$pass,$db);
$dbc->query("SELECT * FROM ".pfw."_config");
while ($cfg=$dbc->fetch()) {
  define($cfg->name,$cfg->value);
  $debug .= "Name: $cfg->name Value: $cfg->value\n";
}
$debug .= "Framework fertig geladen. Script wird nun ausgefuehrt!\n\n";
$debug .= "***FRAMEWORK-DEBUG***-->\n\n";
if (debug=="true") {
  echo $debug;
}

if (function_exists("gError")) {
  set_error_handler("gError");
}




/* So fertig :)
Puh, alles geschafft.
Ab nach Hause!
*/ 
?>
