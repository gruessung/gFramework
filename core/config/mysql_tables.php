<?php
/*
Diese Datei sucht in den Endanwendungen nach den Dateien mit den def. Tabellen f�r die mysqlDB.
Au�erdem werden hier die gFramework Tables definiert.
(c) 2009 gVisions
*/

/*Definiere*/
define("LoginData","LoginData");
define("appdb","applications");
define("menu","menuentries");
define("plugins","plugins");



/*Suche und includiere
$ea = new EndAnwendung();
while ($ea->search()) {
  require_once($row->relativer_pfad_index.'/core/cfg/mysql_tables.php') or die ('Leider ist einer Ihrer Endanwendungen defekt. ID:'.$row->id);
}
*/
