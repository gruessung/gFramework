<?php
  $user = new UserManagement();
  $db = new db();
  $action = 'index';
  $html = "";
  if (isset($_GET["action"])) { $action = $_GET["action"]; }

  if (com_gvisions_news_load_from_bboard == 'false')
  {
    switch ($action)
    {
      case "index":
        $seite = 1;
        if (isset($_GET["seite"])) { $seite = $_GET["seite"]; }
        $artikel_pro_seite = 5;
        $sql = "SELECT * FROM ".pfw."_gvisions_news ORDER BY id DESC LIMIT ".($artikel_pro_seite * $seite - $artikel_pro_seite).",$artikel_pro_seite;";
        $db->query($sql);
        
        $titel = '&Uuml;bersicht';
        
        while ($row = $db->fetch())
        {
          $html .= '<div style="width: 50%;">';
          $html .= '<font style="font-size:16pt;"><a style="a:link, a:visited { text-decoration:none; }" href="index.php?app='.appid.'&action=seeNews&id='.$row->id.'">'.$row->titel.'<br></a></font>';
          $html .= "<hr>";
          $db_ = new db();
          $db_->query("SELECT COUNT(id) AS anzahl FROM ".pfw."_gvisions_news_comments WHERE newsid = $row->id");
          $t = $db_->fetch(); 
          $html .= '<i><small>am '.$row->date.' von '.$user->getUserName($row->author).' - <a href="index.php?app='.appid.'&action=seeNews&id='.$row->id.'#comments">'.$t->anzahl.' Kommentare</a>; Tags: '.$row->tags.'</small></i>';
          $text = explode("page-break-after: always;",$row->text);
          $html .= "<br>".$text[0];
          $html .= '<br><i><small><a href="index.php?app='.appid.'&action=seeNews&id='.$row->id.'">weiterlesen</a></small></i>';
          $html .= '<br><br><br></div>';
        }
        
        $sql = "SELECT COUNT(id) AS anzahl FROM ".pfw."_gvisions_news;";
        $db->query($sql);
        $row = $db->fetch();
        $gesamtSeiten = $row->anzahl / $artikel_pro_seite;
        $html .= "<br><br>Seiten: ";
        for ($i = 0; $i < $gesamtSeiten; $i++)
        {
          $b = $i + 1;
          if ($b == $seite)
          {
            $html .= '&nbsp; &nbsp;<b>'.$b.'</b>';
          }
          else
          {
            $html .= '&nbsp; &nbsp;<a href="index.php?app='.appid.'&action=index&seite='.$b.'">'.$b.'</a>';
          }
        }
        $html .= "<br><br>";
      break;
      
      case 'seeNews':
      
        $titel = "";
        $id = mysql_real_escape_string($_GET["id"]);
        if (empty($id) || !is_numeric($id)) { die ('Die News ID ist nicht korrekt.'); }
        
        if (isset($_POST["go"])) //kommentar wurde geschickt
        {
          if ($user->ifLogin()==false) { die ('Sessionfehler.'); }
          $text = mysql_real_escape_string(strip_tags($_POST["text"]));
          $id =   mysql_real_escape_string($_POST["newsid"]);
          
          $date = date("d.m.Y - H:i", time()); 
          $sql = "INSERT INTO ".pfw."_gvisions_news_comments(text,author,date, newsid) VALUES('$text', '".$_SESSION["userid"]."','$date', '$id');";
          $db->query($sql);
          $html .= '<font color="green">Kommentar wurde gespeichert.</font><br><br>';
        }
        
        $sql = "SELECT * FROM ".pfw."_gvisions_news WHERE `id` = $id;";
        $db->query($sql);
        if ($db->num_rows()<=0)
        {
          $titel = "Fehler";
          $html .= ("Artikel nicht gefunden.");
          $template = new TPL();
          $template->menuid = gnews_menuid;
          $template->id = 1;
          $template->sitename = "News - ".$titel;
          $template->text = $html;
          $template->show(); 
          die();
        }
        $row = $db->fetch();   
        $titel = $row->titel;
        
        $html .= '<font style="font-size:18pt;">'.$row->titel.'</font><br>';
        $html .= '<small><img src="apps/com.gvisions.framework/icons/calendar.png" border="0" height="14">'.$row->date.'<br><img src="apps/com.gvisions.framework/icons/user.png" border="0" height="14">'.$user->getUserName($row->author).'<br><img src="apps/com.gvisions.framework/icons/note.png" border="0" height="14">Tags: '.$row->tags.'</small><br><br>';
        $html .= $row->text;
 
        $html .= '<br><br><h3><a name="comments"></a>Kommentare</h3>'; 
        
        $sql = "SELECT * FROM ".pfw."_gvisions_news_comments WHERE newsid = $id ORDER BY id DESC;";
        $db->query($sql);
        
       
        
        if ($user->ifLogin())
        {
          $html .= '<div id="commentbox">
            <form action="index.php?app_comid=com.gvisions.news&action=seeNews&id='.$id.'#comments" method="POST">
              Username: '.$user->getUserName($_SESSION["userid"]).'<br>
              <textarea name="text" id="text"  class="input-xxlarge" rows="5"></textarea><br>
              <input type="hidden" name="name"><input type="hidden" name="newsid" value="'.$id.'" />
              <input type="submit" class="btn" name="go" value="Kommentieren" />                            
            </form>
          </div>';
        }
        else
        {
          $html .= "Zum kommentieren bitte einloggen.";
        }
        
        while ($row = $db->fetch())
        {
          $html .= '<fieldset style="width:50%;"><legend>'.$user->getUserName($row->author).' am '.$row->date.'</legend>'.$row->text.'</fieldset>';
        }
        $html .= '<br><br><br>';
      break;
      
      default:
        $html .= 'Ich habe keine Ahnung, was du willst, diese Aktion gibt es nicht :)';
      break; 
    }
  }
  
  $template = new TPL();
  $template->menuid = gnews_menuid;
  $template->id = 1;
  $template->sitename = "News - ".$titel;
  $template->text = $html;
  $template->show();  