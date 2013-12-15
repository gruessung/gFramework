<?php
//hard coded redirect
if (isset($_GET["action"]))
{
    if ($_GET["action"] == "fm")
    {
        header("Location: core/cp/index.php?action=fm");
    }
}
/*
gFramework
Copyright (C) 2012 gVisions

This program is free software; you can redistribute it and/or modify it under 
the terms of the GNU General Public License as published by the 
Free Software Foundation; 
either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but 
WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for 
more details.

You should have received a copy of the GNU General Public License 
along with this program; if not, see <http://www.gnu.org/licenses/>.
*/
  
 	//SEO URLS, get Parameter for GET
	$self = explode("/index.php",$_SERVER['PHP_SELF']);
	$self = $self[0];

	$rs = preg_replace("%$self/%", "",$_SERVER['REQUEST_URI']);
	$explode = explode("/", $rs);
	
	for ($i = 0; $i < count($explode); $i++)
	{
		if ($i % 2 == 0)
		{
			$_GET[$explode[$i]] = @$explode[$i+1];	
			$i ++;
		}
		
	}
	define ("web_root", $self);


  
  $debug = "";
  require_once("./core/init.php");
  
  if (site_online == "false") {
    require_once(root."/core/site_offline.php");
    die();
  }

  
  /*
  Dies ist die Index Datei des Frameworks.
  eine AppID wird immer bevorzugt, falls parralel eine app_comid angeben ist!
  */
  $appid = "";
  $app_comid = "";
  if (isset($_GET['app']) ){
    $appid = $_GET['app'];
  }
  if (isset($_GET['app_comid'])) {
    $app_comid = $_GET['app_comid'];
  }
  DEFINE("appid", $appid);
  DEFINE("app_comid", $app_comid);
  if (empty($appid) AND empty($app_comid)) {

    /*
    Baue DB Verb. auf und schaue, welche App als aller erstes in der DB steht,  laden wir dann einfach diese. Der Nutzer wird darauf per trigger_error(); hingewisen!
    */
    $db = new db();
    $db->query("SELECT * FROM ".pfw."_".plugins." WHERE `id` = '".firstApp."' OR `com_id` = '".firstApp."' ORDER BY id ASC LIMIT 0,1");
    $app = $db->fetch();
    #trigger_error("Bitte eine ID angeben. Sonst wird die erste verf�gbare App gestartet.",E_USER_NOTICE);
    if ($app->activate != "true" AND $app->activate != "1") {
      require_once("apps/com.gvisions.framework/pluginnotfound.php");
      die();
    }
    require_once(root."/apps/".$app->com_id."/index.php");
    /*
    So, dann hoffen wir mal, es war richtig.
    */
    die();
    
  }

  #if ($appid=="1" OR $app_comid=="com.gvisions.framework") { trigger_error("Die App mit der ID1 stellt das Framework dar, und kann nicht geladen werden.",E_USER_ERROR);}
  /*
  Gibt es diese Applikation denn in unserer Datenbank ?
  
  Baue DB Verb. daf�r auf:
  */
  $db = new db();
  /*
  Suche nun in der DB nach der Applikation.
  Eigentlich sollte ja nur eine �bereinstimmung vorhanden sein :)
  */
  if (!empty($appid)) {
    $db->query("SELECT * FROM ".pfw."_".plugins." WHERE id = ".$appid."");
  }
  elseif (!empty($app_comid)) {
    $db->query("SELECT * FROM ".pfw."_".plugins." WHERE `com_id` = '".$app_comid."'");
  }
  else
  {
    trigger_error("Interner Fehler bei appid und app_comid.",E_USER_ERROR);
  }
  /*
  So, dann mal alles in einem array speichern
  */
  $row = $db->fetch();
  /* Und z�hlen */
  $num = $db->num_rows();
  /*
  Wenn nun mehr als eine �bereinstimmung bzw.keine �bereinstimmung gefunden werden konnte liegt ein Fehler vor. trigger_error() kommt zum Einsatz!
  */
  if ($num!=1){
    #trigger_error("Die Applikation wurde nicht gefunden und/oder die ID ist mehrmals vorhanden und/oder die Applikation wurde deaktiviert und es ist keine eindeutige Identifikation mehr m&ouml;glich!",E_USER_ERROR);
  }
  /*
  Es gibt eine �bereinstimmung, gut, dann binden wir das Teil mal ein :)
  Und �berlassen wir der Applikation den Rest.
  */
  if ($row->activate != "true" AND $row->activate != "1")
  {
    require_once("apps/com.gvisions.framework/pluginnotfound.php");
    die();
  }
  if ($num==1){
    require_once(root."apps/".$row->com_id."/index.php");
  }

  