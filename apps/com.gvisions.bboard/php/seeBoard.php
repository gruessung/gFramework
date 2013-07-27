<?php
  $db = new db();
  $user = new gUserManagement();
  
  $tableTemplate = new gTPL();
  
  $boardID = mysql_real_escape_string($_GET["id"]);
  if (empty($boardID) || !is_numeric($boardID))
  {

    $tableTemplate->fetchTemplate(apppath."/tpl/errorMessage.tpl");
    $tableTemplate->replace("{message}", "BoardID nicht &uuml;bergeben.");
    $html .= $tableTemplate->getTemplate();
  }
  else
  {
  
    $db->query("SELECT * FROM ".pfw."_bboard_board WHERE id = $boardID");
    $row_board = $db->fetch();
    
    $html .= siesindhier($row_board->catid, $boardID, false, 0);
    
    $tableTemplate->fetchTemplate(apppath."/tpl/seeBoard-thead.tpl");
    $tableTemplate->replace("{boardID}", $row_board->id);
    $tableTemplate->replace("{boardName}", $row_board->name);
    
    $titel = $row_board->name; // f�r Seitentitel
    
    $html .= $tableTemplate->getTemplate();
    
    $db->query("SELECT * FROM ".pfw."_bboard_post WHERE boardid = $boardID AND topic = 0 ORDER BY pinned DESC, id DESC");
    while ($row = $db->fetch())
    {
      $tableTemplate->fetchTemplate(apppath."/tpl/seeBoard-trow.tpl");
      $tableTemplate->replace("{appid}", "com.gvisions.bboard");
      
      $tableTemplate->replace("{topic_id}", $row->id);
      $tableTemplate->replace("{topic_name}", $row->name);
      
      if ($row->pinned == "1")
      {
        $tableTemplate->replace("{icon}", '<i class="icon-bullhorn"></i>');
      }
      else
      {
        $tableTemplate->replace("{icon}", ""); 
      }
      
      $datum = date("d.m.Y H:i",$row->date);
      
      $tableTemplate->replace("{autor}", $user->getUserName($row->autor). "<br><small>$datum</small>");
      
      $db2 = new db();
      $db2->query("SELECT id FROM ".pfw."_bboard_post WHERE topic = ".$row->id."");
      $countReplies = $db2->num_rows();
      
      $tableTemplate->replace("{countReplies}",$countReplies);
      
      $lastPosting = getLastReply($row->id); 
      $tableTemplate->replace("{lastPosting}", $lastPosting);
      
      $html .= $tableTemplate->getTemplate();
    }
                              
  }
    $tableTemplate->fetchTemplate(apppath."/tpl/seeBoard-tfoot.tpl");
	$tableTemplate->replace("{boardID}", $row_board->id);
    $tableTemplate->replace("{boardName}", $row_board->name);
    $html .= $tableTemplate->getTemplate();