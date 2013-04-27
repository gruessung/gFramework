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
        $artikel_pro_seite = 3;
        $sql = "SELECT * FROM ".pfw."_gvisions_news ORDER BY id DESC LIMIT ".($artikel_pro_seite * $seite - $artikel_pro_seite).",$artikel_pro_seite;";
        $db->query($sql);
        
        $titel = '&Uuml;bersicht';
        
        while ($row = $db->fetch())
        {
          $db_ = new db();
          $db_->query("SELECT COUNT(id) AS anzahl FROM ".pfw."_gvisions_news_comments WHERE newsid = $row->id");
          $t = $db_->fetch(); 
          
			$text = explode("page-break-after: always;",$row->text);

			$tags = explode(",",$row->tags);
			$html .= '<div class="row">
						
							<div class="row">
								<div class="span8">
									<h4><strong><a href="index.php?app='.appid.'&action=seeNews&id='.$row->id.'">'.$row->titel.'</a></strong></h4>
								</div>
							</div>
						<div class="row">
							<!--<div class="span2">
								<a href="#" class="thumbnail">
									<img src="http://placehold.it/260x180" alt="">
								</a>
							</div>-->
							<div class="span6">
								<p>
									'.$text[0].'
								</p>
								<p><a class="btn" href="index.php?app='.appid.'&app_comid='.@$_GET["app_comid"].'&action=seeNews&id='.$row->id.'">weiterlesen</a></p>
							</div>
						</div>
						<div class="row">
							<div class="span8">
								<p></p>
								<p>
								<i class="icon-user"></i> by <a href="#">'.$user->getUserName($row->author).'</a>
								| <i class="icon-calendar"></i> '.$row->date.'
								| <i class="icon-comment"></i> <a href="index.php?app='.appid.'&action=seeNews&id='.$row->id.'#comments">'.$t->anzahl.' Kommentare</a>
								<!--| <i class="icon-share"></i> <a href="#">39 Shares</a>-->
								| <i class="icon-tags"></i> Tags :'; 
								for ($i = 0; $i < count($tags); $i++)
								{
									$html .= '<a href="#"><span class="label label-info">'.$tags[$i].'</span></a>&nbsp;';
								}
					$html .= '</p>
							</div>
						</div>
						
					 </div>
					';
		  
        }
        
        $sql = "SELECT COUNT(id) AS anzahl FROM ".pfw."_gvisions_news;";
        $db->query($sql);
        $row = $db->fetch();
        $gesamtSeiten = $row->anzahl / $artikel_pro_seite;
        $html .= '<div class="pagination pagination-left"><ul><li ><a href="index.php?app='.appid.'&action=index&seite=';
		if($seite-1 == 0) $html .= "1"; else $html .= $seite-1;
		$html .='"><<</a></li>';
        for ($i = 0; $i < $gesamtSeiten; $i++)
        {
          $b = $i + 1;
          if ($b == $seite)
          {
            $html .= '<li class="disabled"><a href="#">'.$b.'</a></li>';
          }
          else
          {
            $html .= '<li><a href="index.php?app='.appid.'&action=index&seite='.$b.'">'.$b.'</a></li>';
          }
        }
		
        $html .= '<li ><a href="index.php?app='.appid.'&action=index&seite=';
		if($seite+1 > ceil($gesamtSeiten)) $html .= $seite; else $html .= $seite+1;
		$html .= '">>></a></li></ul></div>';
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
        
        $sql = "SELECT ".pfw."_gvisions_news . * , count( ".pfw."_gvisions_news_comments.newsid ) AS anzahl
				FROM ".pfw."_gvisions_news, ".pfw."_gvisions_news_comments
				WHERE ".pfw."_gvisions_news.`id` =$id
				AND ".pfw."_gvisions_news_comments.newsid =$id
				LIMIT 0 , 30";
        $db->query($sql);
		$row = $db->fetch();
        if (empty($row->titel))
        {
          $titel = "Fehler";
          $html .= ('<div class="alert alert-error"><b>Fehler: </b>Artikel nicht gefunden.</div>');
          $template = new TPL();
          $template->menuid = gnews_menuid;
          $template->id = 1;
          $template->sitename = "News - ".$titel;
          $template->text = $html;
          $template->show(); 
          die();
        }
           
        $titel = $row->titel;
        
		
		
		
			$text = $row->text;

			$tags = explode(",",$row->tags);
			$html .= '<div class="row">
					<div class="span8">
					<div class="row">
					<div class="span8">
					<h4><strong><a href="index.php?app='.appid.'&action=seeNews&id='.$row->id.'">'.$row->titel.'</a></strong></h4>
					</div>
					</div>
					<div class="row">
					<!--<div class="span2">
					<a href="#" class="thumbnail">
					<img src="http://placehold.it/260x180" alt="">
					</a>
					</div>-->
					<div class="span6">
					<p>
					'.$text.'
					</p>
					</div>
					</div>
					<div class="row">
					<div class="span8">
					<p></p>
					<p>
					<i class="icon-user"></i> by <a href="#">'.$user->getUserName($row->author).'</a>
					| <i class="icon-calendar"></i> '.$row->date.'
					| <i class="icon-comment"></i> <a href="index.php?app='.appid.'&action=seeNews&id='.$row->id.'#comments">'.$row->anzahl.' Kommentare</a>
					<!--| <i class="icon-share"></i> <a href="#">39 Shares</a>-->
					| <i class="icon-tags"></i> Tags :'; 
					for ($i = 0; $i < count($tags); $i++)
					{
						$html .= '<a href="#"><span class="label label-info">'.$tags[$i].'</span></a>&nbsp;';
					}
					$html .= '</p>
					</div>
					</div>
					</div>
					</div>
					';
        
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
        $html .= '<div class="alert alert-error">Fehler: Aktion nicht gefunden.</div>';
      break; 
    }
  }
  
  $template = new TPL();
  $template->menuid = gnews_menuid;
  $template->id = 1;
  $template->sitename = "News - ".$titel;
  $template->text = $html;
  $template->show();  