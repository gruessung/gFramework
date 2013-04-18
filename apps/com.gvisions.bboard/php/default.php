<?php
  //Datenbankzugriff starten
  $db_cat = new db();
  $db_boards = new db();
  
  //Templates in Variablen laden
  $tableTemplate = new TPL();
  

  
  //$sql = "SELECT b.id AS board_id, b.name AS board_name, b.reihe AS board_reihe, b.catid AS board_catid, c.id AS cat_id, c.name AS cat_name, c.reihe AS cat_reihe FROM ".prafix."_BBoard_Board b, gframework_BBoard_Cat c WHERE b.catid = c.id   ORDER BY c.reihe, b.reihe;";
  
  $db_cat->query("SELECT * FROM ".pfw."_bboard_cat ORDER BY reihe ASC;");

  $html .= siesindhier(false, false, false, 0);
  
  while ($row_cat = $db_cat->fetch())
  {
    $tableTemplate->fetchTemplate(apppath."/tpl/default-thead.tpl");
    $tableTemplate->replace("{catID}", $row_cat->id);
    $tableTemplate->replace("{catName}", $row_cat->name);
    $html .= $tableTemplate->getTemplate();
    
    $db_boards->query("SELECT * FROM ".pfw."_bboard_board WHERE catid = ".$row_cat->id." ORDER BY reihe ASC;");
    
    while ($row_boards = $db_boards->fetch())
    {
      $tableTemplate->fetchTemplate(apppath."/tpl/default-trow.tpl");
      $tableTemplate->replace("{appid}", "com.gvisions.bboard");
      
      $tableTemplate->replace("{board_id}", $row_boards->id);
      $tableTemplate->replace("{board_name}", $row_boards->name);
      
      $tableTemplate->replace("{countTopics}", getTopicCount($row_boards->id));
      $tableTemplate->replace("{countPostings}", getPostingCount($row_boards->id));
      
      $lastPosting = getLastPosting($row_boards->id); 
      $tableTemplate->replace("{lastPosting}", $lastPosting);
      
      $html .= $tableTemplate->getTemplate();
    }
    $tableTemplate->fetchTemplate(apppath."/tpl/default-tfoot.tpl");
    $html .= $tableTemplate->getTemplate();
  }

?>