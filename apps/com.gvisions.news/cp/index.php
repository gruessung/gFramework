<?php
  /*
  Dann wollen wir mal ^^
  Wir brauchen def. immer eine DB Verbindung
  */
  
  $db = new db();
  
  /*
  Schauen wir, was der Nutzer will.
  
  $ac = empty => alle art auflisten
  $ac = edit => art edietieren
  $ac = new => neuen art erstellen
  $ac = delete => na was ich das bloß ? genau, löschen
  
  */
  
  if (!isset($_GET['ac'])) {
    $ac = "list_all";
  } else {
    $ac = $_GET['ac'];
  }
  
  /*
  Sollte $ation jetzt trotzdem leer sein, stimmt was nicht
  */
  if (empty($ac)) { trigger_error("Fehler bei der Verarbeitung / Übermittlung der Daten 'ac'.",E_USER_ERROR); }
  
  /*
  Laden wir nun die Datei, die den $ac Par definiert
  */  
  
  
  require_once(apppath."/cp/".$ac.".php");
  
  