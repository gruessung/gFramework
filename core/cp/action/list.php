<?php
  /*
  Listet alle installierten Applikationen und Plugins auf!
  */
  
  /*
  Bauen wir ersteinmal eine DB Verbindung auf...
  */
  
  $db = new db();
  
  /*
  Suchen wir nun alle applikationen
  */
  
  $db->query("SELECT * FROM ".pfw."_".plugins." ORDER BY id");
  
  /*
  Und nun alles z�hlen und ab in einen array()
  Dann schonmal die Tabellenzeile erstellen
  */
  
  $AppsNum = $db->num_rows();
  $AppsTd="";
  while ($AppsArray = $db->fetch()) {
      $color ="red";
      
      if ($AppsArray->activate=="1" || $AppsArray->activate=="true") { $color = "lightgreen"; }
      $AppsTd .= '<tr style="background-color:'.$color.';"><td style="width:20%;">'.$AppsArray->name.'</td><td "width:5%;">'.$AppsArray->version.'</td><td "width:45%;">'.$AppsArray->desc.'</td><td "width:35%;"><a href="index.php?action=verwalten&appid='.$AppsArray->id.'">Administrieren</a> | <a href="index.php?action=activate&appid='.$AppsArray->id.'">(De)Aktivieren</a></td></tr>';
  }
  
  /* 
  So, nun muss das alles ausgegeben werden.
  */
  
  /*
  Da alles noch entwickelt wird, geben wir reines html mal aus
  */
  
  echo 'Installierte Erweiterungen:<br><div class="cel" style="height:auto;">
    <table class="table table-bordered"><tr style="border: 1px black solid;"><th>Name</th><th>Version</th><th>Beschreibung</th><th>Optionen</th></tr> '.$AppsTd.'</table></div><br /><br />';
  
  
  /************************************************************************************************/
    /*
  Listet alle installierten Styles auf
  */
  
  /*
  Bauen wir ersteinmal eine DB Verbindung auf...
  */
  
  $db = new db();
  
  /*
  Suchen wir nun alle applikationen
  */
  
  $db->query("SELECT * FROM ".pfw."_styles ORDER BY id");
  
    /*
  Und nun alles z�hlen und ab in einen array()
  Dann schonmal die Tabellenzeile erstellen
  */
  
  $AppsNum = $db->num_rows();
  $AppsTd="";
  while ($AppsArray = $db->fetch()) {
      $color ="red";
      if ($AppsArray->com_id == style) { $color = "lightgreen"; }
      $AppsTd .= '<tr style="background-color:'.$color.';"><td style="width:20%;">'.$AppsArray->name.'</td><td "width:5%;">'.$AppsArray->version.'</td><td "width:45%;">'.$AppsArray->desc.'</td><td "width:35%;"><a href="index.php?action=verwalten&appid=1&ac=editStyle&styleid='.$AppsArray->id.'&style_comid='.$AppsArray->com_id.'">Administrieren</a><!-- | <a href="index.php?action=unistall&styleid='.$AppsArray->id.'">Deinstallieren</a>--></td></tr>';
  }
  
  /* 
  So, nun muss das alles ausgegeben werden.
  */
  
  /*
  Da alles noch entwickelt wird, geben wir reines html mal aus
  */
  
  echo 'Installierte Styles:<br><div class="cel" style="height:auto;">
    <table class="table table-bordered"><tr style="border: 1px black solid;"><th>Name</th><th>Version</th><th>Beschreibung</th><th>Optionen</th></tr> '.$AppsTd.'</table></div><br /><br />';
  
  