<?php
  require_once (apppath."/php/stuff/bbcode.php");
  $db = new db();
  $user = new gUserManagement();
  
  $tpl = new gTPL();
  
  $page = 1;
  if (isset($_GET["page"]))
  {
    $page = $_GET["page"];
  }
  
  $topicID = mysql_real_escape_string($_GET["id"]);
  if (empty($topicID) || !is_numeric($topicID))
  {

    $tpl->fetchTemplate(apppath."/tpl/errorMessage.tpl");
    $tpl->replace("{message}", "TopicID nicht &uuml;bergeben.");
    $html .= $tpl->getTemplate();
  }
  else
  {
    $start = $page * postPerPage - postPerPage;
  
    $db->query("SELECT * FROM ".pfw."_bboard_post
                WHERE id = $topicID");
    $row_topic = $db->fetch();
    $db->query("SELECT * FROM ".pfw."_bboard_board WHERE id = $row_topic->boardid");
    $row_meta = $db->fetch();
    
    $html .= siesindhier($row_meta->catid,$row_topic->boardid ,$topicID , $page);
    
    $tpl->fetchTemplate(apppath."/tpl/seeTopic-thead.tpl");
    $tpl->replace("{topicID}", $topicID);
    $tpl->replace("{topicName}", $row_topic->name);
    
    $titel = $row_topic->name; // für Seitentitel
    
    $html .= $tpl->getTemplate();

    $db->query("SELECT id FROM ".pfw."_bboard_post
                WHERE id = $topicID OR topic = $topicID");
    $countAllPostings = $db->num_rows();

    $db->query("SELECT * FROM ".pfw."_bboard_post
                WHERE id = $topicID OR topic = $topicID 
                LIMIT $start,".postPerPage."");
    
    while ($row = $db->fetch())
    {
      $tpl->fetchTemplate(apppath."/tpl/seeTopic-trow.tpl");
      $tpl->replace("{autorName}", $user->getUserName($row->autor));
      $tpl->replace("{avatar}", "apps/com.gvisions.framework/avatar/".$user->getAvatar($row->autor));
      
      
      $date = date("d.m.Y H:i",$row->date);
      $tpl->replace("{postID}", $row->id);
      if ($user->userGroup($user->getCurrentUser()) == admin_group)
      {
      	$mod = new gTPL();
      	$mod->fetchTemplate(apppath."/tpl/seeTopic-mod.tpl");
      	$mod->replace("{postID}", $row->id);
      	$mod->replace("{topicID}", $topicID);
      	$tpl->replace("{moderation}", $mod->getTemplate());	
      }
      else
      {
      	$tpl->replace("{moderation}", "");
      }
      $tpl->replace("{countPostings}", getCountPostingsByAUser($row->autor));
      $tpl->replace("{date}", $date);
      $tpl->replace("{titel}", $row->name);
      $tpl->replace("{text}", BBCode(htmlentities($row->text)));

      
      
      $html .= $tpl->getTemplate();
    }


    $tpl->fetchTemplate(apppath."/tpl/seeTopic-tfoot.tpl");
    
    $wieviel_seiten = $countAllPostings / postPerPage;
    $sites = "";
    for($a=0; $a < $wieviel_seiten; $a++) 
    { 
      $b = $a + 1;  
      if($page == $b) 
      { 
        $sites .= "  <b>$b</b> "; 
      } 
      else 
      { 
        $sites .= "  <a href=\"index.php?app_comid=com.gvisions.bboard&action=seeTopic&id=$topicID&page=$b\">$b</a> "; 
      } 
    }
    $tpl->replace("{pages}", $sites);
    $tpl->replace("{topicID}", $topicID);
    $html .= $tpl->getTemplate();
  }