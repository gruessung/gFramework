<?php
  
  $titel = mysql_real_escape_string(@$_POST["titel"]);
  if (empty($titel)) { $titel = "ohne Titel"; }
  $text = mysql_real_escape_string(@$_POST["text"]);
  if (empty($titel)) { die("Ein Beitrag muss Text enthalten."); }
  if (isset($_POST["topicid"]))
  {
    $topicid = mysql_real_escape_string($_POST["topicid"]);
    if (empty($topicid) || !is_numeric($topicid)) { die ("Fehler topicid"); }
    $boardid = mysql_real_escape_string($_POST["boardid"]);
  }
  elseif (isset($_POST["boardid"]))
  {
    $boardid = mysql_real_escape_string($_POST["boardid"]);
    $topicid = 0;
    if (empty($boardid) || !is_numeric($boardid)) { die ("Fehler boardid"); }
  }
  else
  {
    die("Fehler beim Erstellen der Antwort / des neuen Themas.");
  }
  $ip = $_SERVER["REMOTE_ADDR"];
  if ($ip == "::1")
  {
    $ip = "127.0.0.1";
  }
  $date = time();
  $text = utf8_decode($text);
  $sql = "INSERT INTO ".pfw."_bboard_post
          (name, text, autor, boardid, topic, date, ip)
          VALUES
          ('$titel', '$text', '".$_SESSION['userid']."', '$boardid', '$topicid', '$date', '$ip');
         ";
  $db = new db();
  $db->query($sql);
  $html .= "<center>";
  $lastID = mysql_insert_id();
  
  if ($topicid == 0)
  {
    
    $html .= "Ihr neues Thema wurde gespeichert.<br><a href=\"index.php?app_comid=com.gvisions.bboard&action=seeTopic&id=$lastID\">Hier klicken um dort hin zu gelangen.</a><br><a href=\"index.php?app_comid=com.gvisions.bboard&action=seeBoard&id=$boardid\">Hier klicken um zum Forum zu gelangen.</a>";
  }
  else
  {
    $html .= "Ihre Antwort wurde gespeichert.<br><a href=\"index.php?app_comid=com.gvisions.bboard&action=seeTopic&id=$topicid\">Hier klicken um dort hin zu gelangen.</a><br><a href=\"index.php?app_comid=com.gvisions.bboard&action=seeBoard&id=$boardid\">Hier klicken um zum Forum zu gelangen.</a>"; 
  }