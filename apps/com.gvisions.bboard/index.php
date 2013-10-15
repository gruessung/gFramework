<?php
   
error_reporting(E_ALL);

  define("apppath","apps/com.gvisions.bboard/");
  define("postPerPage", 5);

	$user = new gUserManagement();
	$db = new db();  
  
  function showEditor($value)
  {
     if ( !function_exists('version_compare') || version_compare( phpversion(), '5', '<' ) )
    	include_once( root.'apps/com.gvisions.framework/ckeditor/ckeditor_php4.php' ) ;
    else
    	include_once( root.'apps/com.gvisions.framework/ckeditor/ckeditor_php5.php' ) ;
                      
    $CKEditor = new CKEditor();
    $CKEditor->returnOutput = true;
	$CKEditor->basePath = './apps/com.gvisions.framework/ckeditor/';
    $config = array();
    $config['toolbar'] = array(
    	 array('Bold', 'Italic', 'Underline', 'Blockquote' ),
    	 array('Image', 'Link', 'Unlink'),
       array('NumberedList', 'BulletedList'),
       array('Smiley', 'Source')
    );
    $config["extraPlugins"] = "bbcode";
    return $CKEditor->editor("text", $value, $config); 
  }
  
  function siesindhier($cat,$board,$topic,$seite = 1)
  { 
  
	 $return ='<ul class="breadcrumb">
    <li><a href="index.php?app_comid=com.gvisions.bboard">Forenindex</a> <span class="divider">/</span></li>';
	
    $db = new db(); 

    if ($cat)
    {
      $db->query("SELECT * FROM ".pfw."_bboard_cat WHERE id = $cat");
      $row = $db->fetch();
      $return .= ' <li><a href="index.php?app_comid=com.gvisions.bboard&action=seeCat&id='.$row->id.'">'.$row->name.'</a><span class="divider">/</span></li>';
    }
    if ($board)
    {
      $db->query("SELECT * FROM ".pfw."_bboard_board WHERE id = $board");
      $row = $db->fetch();
      $return .= ' <li><a href="index.php?app_comid=com.gvisions.bboard&action=seeBoard&id='.$row->id.'">'.$row->name.'</a><span class="divider">/</span></li>';
    }  
    if ($topic)
    {
      $db->query("SELECT * FROM ".pfw."_bboard_post WHERE id = $topic");
      $row = $db->fetch();
      $return .= ' <li> <a href="index.php?app_comid=com.gvisions.bboard&action=seeTopic&id='.$row->id.'">'.$row->name.'</a><span class="divider">/</span></li>';
    }  
    if ($seite <> 0)
    {
      if ($topic)
      {
        $return .= ' <li> <a href="index.php?app_comid=com.gvisions.bboard&action=seeTopic&id='.$topic.'&page='.$seite.'">Seite '.$seite.'</a><span class="divider">/</span></li>';
      }
      elseif ($board)
      {
        $return .= '<li> <a href="index.php?app_comid=com.gvisions.bboard&action=seeBoard&id='.$board.'&page='.$seite.'">Seite '.$seite.'</a><span class="divider">/</span></li>';
      }
      elseif ($cat)
      {
        $return .= '<li> <a href="index.php?app_comid=com.gvisions.bboard&action=seeCat&id='.$cat.'&page='.$seite.'">Seite '.$seite.'</a><span class="divider">/</span></li>';
      }
      else
      {
        $return .= ' <li> Seite '.$seite.'</li>';
      }
    } 
    $return .= "</ul>";
    return $return;
  }
  
  function getTopicCount($boardid)
  {
    $db = new db();
    $db->query("SELECT id FROM ".pfw."_bboard_post WHERE topic = 0 AND boardid = $boardid");
    return $db->num_rows();
  }
  
  function getPostingCount($boardid)
  {
    $db = new db();
    $db->query("SELECT id FROM ".pfw."_bboard_post WHERE boardid = $boardid");
    return $db->num_rows();
  }
  
  function getLastPosting($boardid)
  {
    $db = new db();
    $db->query("SELECT * FROM ".pfw."_bboard_post WHERE boardid = $boardid ORDER BY id DESC LIMIT 1");
    if ($db->num_rows() <= 0)
    {
      return "Kein Beitrag vorhanden";
    }
    else
    {
      $row = $db->fetch();
      $db->query("SELECT id FROM ".pfw."_bboard_post WHERE topic = $row->topic ORDER BY id DESC");
      $count = $db->num_rows();
      $wievielseiten = round($count / postPerPage);


      $user = new gUserManagement();
      $autor = $user->getUserName($row->autor);
      $topic = $row->id;
      if ($row->topic != 0)
      {
        $topic = $row->topic;
      }

      $titel = $row->name;

      return "<a href=\"index.php?app_comid=com.gvisions.bboard&action=seeTopic&id=$topic&page=1\">$titel</a> von $autor";
    }
  }
  
  function getLastReply($topicid)
  {
    $db = new db();
    $db->query("SELECT * FROM ".pfw."_bboard_post WHERE topic = $topicid ORDER BY id DESC LIMIT 1");
    if ($db->num_rows() <= 0)
    {
      return "Kein Beitrag vorhanden";
    }
    else
    {
      $row = $db->fetch();
      $db->query("SELECT id FROM ".pfw."_bboard_post WHERE topic = $topicid ORDER BY id DESC");
      $count = $db->num_rows() + 1;
      $seite = $count / postPerPage;
      if ($seite < 1) $seite = 1;
      $user = new gUserManagement();
      $autor = $user->getUserName($row->autor);
      $topic = $row->id;
      if ($row->topic != 0)
      {
        $topic = $row->topic;
      }
      $titel = $row->name;
      $date = $row->date;
      $datum = date("d.m.Y H:i",$date);
      return "<a href=\"index.php?app_comid=com.gvisions.bboard&action=seeTopic&id=$topic&page=1\">$titel</a> von $autor<br><small>$datum</small>";
    }
  }  
  
  function getCountPostingsByAUser($userid)
  {
    $db = new db();
    $db->query("SELECT id FROM ".pfw."_bboard_post WHERE autor = $userid");
    return $db->num_rows();
  }
  
  
  
  	$smilie = array (
				':)' => '<img src="apps/com.gvisions.bboard/images/normal.gif" border="0">',
				':(' => '<img src="apps/com.gvisions.bboard/images/sad.gif" border="0">',
				':P' => '<img src="apps/com.gvisions.bboard/images/zunge.gif" border="0">',
				';)' => '<img src="apps/com.gvisions.bboard/images/wink.gif" border="0">',	
				':D' => '<img src="apps/com.gvisions.bboard/images/w00t.gif" border="0">', 
				'\&quot;' =>'"'										
				);	
		

		$html = file_get_contents('apps/com.gvisions.bboard/tpl/style.css');
	
		
		//$html .= @file_get_contents('apps/com.gvisions.bboard/tpl/informationMessage.tpl');
		if (@isset($_GET['action'])) { $action = $_GET['action']; } else { $action = "index"; }
    
		switch ($action) {
		case "index":
            $titel = "Forenindex";
			include 'apps/com.gvisions.bboard/php/default.php';
		break;
		case "seeCat":
			include 'apps/com.gvisions.bboard/php/seeCat.php';
		break;
		case "seeBoard":
			include 'apps/com.gvisions.bboard/php/seeBoard.php';
		break;
		case "seeTopic":
			include 'apps/com.gvisions.bboard/php/seeTopic.php';
		break;
		case "newText":
			include 'apps/com.gvisions.bboard/php/newText.php';
					
		break;
		case "saveText":
			include 'apps/com.gvisions.bboard/php/saveText.php';
		break;
		case "deletePosting":
            $titel ="Moderation";
			include 'apps/com.gvisions.bboard/php/deletePosting.php';
		break;
		case "moderation":
			include 'apps/com.gvisions.bboard/php/moderation.php';
            $titel = "Moderation";
		break;
		case "getrss":
			include 'apps/com.gvisions.bboard/php/getrss.php';
		break;


		}

		// Useronline-Counter
		//require_once plugins.'BBoard/php/online.php';

    $menuID = bboard_menuid;


    $template = new gTPL();
    $template->menuid = $menuID;
    $template->id = 1;
    $template->sitename = "Forum - ".$titel;
    $template->text = $html;
    $template->show();

