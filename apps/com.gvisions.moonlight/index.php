<?php
  /*
  gMoon!ight for gFramework
  (c) 2009 gVisions.de
  GPL v3
 */

 /*
 So, dann starten wir mal die TPL Engine..*brum* xP
 */
 $template = new TPL();
 
   /*
  Schaue ob ein Plugin per GET aufgerufen wurde, wenn nein, lade normale Seite.
  Lade Seiteninformationen
  */
  if (!isset($_GET['p'])) {
    /* Wenn Aber get_url exestiert, leite weiter */
    if (isset($_GET['url'])) {
      @header('Location: '.$_GET['url']);
      echo 'Leite weiter...<br />Dies ist ein externer Link.';
      $u = $_GET["url"];
      if ($_GET["seo"]==true) { $u = "http://".$u;}
      echo '<meta http-equiv="refresh" content="0; URL='.$u.'">';
      die();
    }
  $page= new page();
  @$pageid = @$page->init();
  $id =@$page->sql($pageid,'id');
  $titel =@$page->sql($pageid,'titel');
  $text =@$page->sql($pageid,'text');
  $menuid =@$page->sql($pageid,'menu');
  /* Wenn die pageid Rueckgabe nichts enthalet, 404*/
  if ($id!="") {
    $template->sitename = $titel;
    $template->menuid = $menuid;
    $template->id = $id;
    $template->text = $text;
    $template->show();
  
  } else {
    $template->menuid = 1;
    $template->id = 1;
    $template->sitename = "Fehler 404";
    $template->text = "Es tut uns leid, die von Ihnen gesuchte Seite ist nicht vorhanden.";
    $template->show();
  }
  } else {
    trigger_error("Fehler beim Laden der Website. 500.",E_USER_NOTICE)    ;
  }