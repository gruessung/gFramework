<?php
    $current = site_online;
    $new = "true";
    if ($current == "true") { $new = "false"; }
    if (isset($_GET['change'])) {
      $cfg = new gConfig();
     # echo $new;
      $cfg->update("site_online",$new);
      if (isset($_POST['change'])) {
        $cfg->update("site_offline_reason",mysql_real_escape_string($_POST['reason']));
      }
      echo "Status wurde ge&auml;ndert.";
      exit();
    }
    
    if ($current == "true") {
      echo 'Wollen Sie die Website wirklich offline schalten?<br>
            Grund eintragen:
            <form action="index.php?action=verwalten&appid=1&ac=offlineMode&change" method="POST">
              <textarea name="reason" rows="6" cols="65">'.site_offline_reason.'</textarea><br><input type="submit" name="change" value="Ja" />';
    } elseif ($current=="false") {
       echo 'Wollen Sie die Website wirklich online schalten?<br><a href="index.php?action=verwalten&appid=1&ac=offlineMode&change">Ja</a>';
    
    } else {
      trigger_error("Fehler in Datenbank. Tabelle: ".pfw."_config, Wert: site_online [true|false]");
    }
?>