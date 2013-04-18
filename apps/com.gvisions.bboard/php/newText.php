<?php
  $user = new UserManagement();
  if ($user->ifLogin() == false)
  {
    $html .= "<center>Zum Schreiben bitte einloggen.<br><a href=\"javascript:history.back();\">Zur&uuml;ck</a></center>";
  }
  else
  {
  
      $html .= '<form action="index.php?app_comid=com.gvisions.bboard&action=saveText" method="POST" />';
    
      if (isset($_GET["topicid"]))
      {
        $topicid = mysql_real_escape_string($_GET["topicid"]);
        if (empty($topicid) || !is_numeric($topicid)) { die ("Fehler topicid"); }
        $html .= "<input type=\"hidden\" name=\"topicid\" value=\"$topicid\">"; 
        $sql = "SELECT * FROM ".pfw."_bboard_post WHERE id = $topicid";
        $db->query($sql);
        $row = $db->fetch();
        if ($row->active == "false")
        {
          $html .= "Dieses Thema ist gesperrt, es kann nicht mehr geantwortet werden.<br><a href=\"javascript:history.back();\">Zur&uuml;ck</a>";
          echo $html; die();
        }
    
        $html .= "<input type=\"hidden\" name=\"boardid\" value=\"".$row->boardid."\">";
        $titel = "RE: ".$row->name;
      }
      elseif (isset($_GET["boardid"]))
      {
        $boardid = mysql_real_escape_string($_GET["boardid"]);
        if (empty($boardid) || !is_numeric($boardid)) { die ("Fehler boardid"); }
        $html .= "<input type=\"hidden\" name=\"boardid\" value=\"$boardid\">"; 
        $titel = "";
      }
      else
      {
        die("Fehler beim Erstellen der Antwort / des neuen Themas.");
      
      }
    
      if (isset($_POST["text"])) { $text = $_POST["text"]; } else { $text = ""; }
    
      $html .= "Titel: <input type=\"text\" name=\"titel\" value=\"$titel\" /><br>";
      $html .= showEditor($text);
      $html .= "<noscript>BBCode erlaubt; HTML verboten.</noscript>";
      $html .= '<input type="submit"></form>';    
    }
?>