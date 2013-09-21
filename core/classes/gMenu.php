<?php
error_reporting(E_ALL);
//data-toggle="dropdown"
  class nav extends gFramework {
  
    function showHoricontal2($id,$class="",$submenu="") {
    echo '<ul class="nav">';
    $output = "";
    $s = new db();
    $s->query("SELECT * FROM ".pfw."_".menu." WHERE `parent` = '0' AND `menu` = '".$id."' ORDER BY reihe");   
    while ($row=$s->fetch()) {
      $link = "index.php?app=".$row->app."&".$row->link;
	  if (seo_url=="true") $link = web_root."/app/$row->app/".preg_replace("%=%", "/", $row->link);
	  echo $link;
    
      $g=new db();
      $g->query("SELECT * FROM ".pfw."_".menu." WHERE parent = ".$row->id." ORDER BY reihe");
      if ($g->num_rows() != 0)
      {
        echo '<li class="dropdown">
              <a href="#" class="'.$class.' dropdown-toggle" data-toggle="dropdown">'.$row->name.' <b class="caret"></b></a>';
        $output .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
        while ($h=$g->fetch()) {
        	$lin2k = "index.php?app=".$h->app."&".$h->link;
        	if (seo_url=="true") $lin2k = web_root."/app/$h>app/".preg_replace("%=%", "/", $h->link);
          	$output .= '<li><a href="'.$lin2k.'" class="'.$submenu.'">'.$h->name.'</a></li>';
        }
        $output .= "</ul></li>";
      }
      else
      {
        echo '<li><a href="'.$link.'" class="'.$class.'">'.$row->name.'</a>';
        echo "</li>";
      }
      
    }
    echo "</ul>";
    echo $output;
    }
	
	function showHoricontal($ulClass, $liClass, $dpClass, $mID)
	{
		$menu = "";
		$menu .= '<ul class="'.$ulClass.'">
		';
		$db = new db();
		$db->query("SELECT * FROM ".pfw."_".menu." WHERE `parent` = '0' AND `menu` = '".$mID."' ORDER BY reihe");
		
		while ($row=$db->fetch())
		{
			$subDB = new db();
			$subDB->query("SELECT * FROM ".pfw."_".menu." WHERE parent = ".$row->id." ORDER BY reihe");
			//Submenu gefunden
			if ($subDB->num_rows() != 0)
			{
				//Oberpunkt darstellen
				$menu .= "<li class=\"dropdown\">
					<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">$row->name<b class=\"caret\"></b></a>
						<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"drop\">
					";
				while ($subRow = $subDB->fetch())
				{
					$link = "index.php?app=$subRow->app&$subRow->link";
					if (seo_url=="true") $link = web_root."/app/$row->app/".preg_replace("%=%", "/", $row->link);
					$menu .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="'.$link.'"><i class="'.@$subRow->icon.'"></i>&nbsp;'.$subRow->name.'</a></li>
					';
				}
				$menu .= "	</ul>
					</li>";
			}
			else
			{
				$link = "index.php?app=$row->app&$row->link";
				if (seo_url=="true") $link = web_root."/app/$row->app/".preg_replace("%=%", "/", $row->link);
				$menu .= '<li><a href="'.$link.'">'.$row->name.'</a></li>';
			}
		}
		
		$menu .= "</ul>";
		
		echo $menu;
	}
	

    
  
   function showAll($id) {
    $sql = new db();
    $auswahl="";
    $sql->query('SELECT * FROM '.pfw.'_menus');
      while ($row=$sql->fetch()) {
        if ($id == $row->id) {
        $extra = "selected";
        } else {
        $extra ="";
        }
        $auswahl .='<option value="'.$row->id.'" '.$extra.'>'.$row->name.'</option>';
      }
   return $auswahl;
   }
      function showAllEntries($id) {
    $sql = new db();
    $auswahl="";
    $sql->query('SELECT * FROM '.pfw.'_'.menu.' WHERE menu  = '.$id);
      while ($row=$sql->fetch()) {
        $auswahl .='<option value="'.$row->id.'">'.$row->name.'</option>';
      }
   echo $auswahl;
   }
   
   function insertMenuEntry($menuid,$parent,$name,$link,$appid)  {
    $dbc = new db();
    $dbc->query('INSERT INTO `'.datenbank.'`.`'.pfw.'_'.menu.'` (`id`, `parent`, `name`, `link`, `menu` , `app`) VALUES (NULL, \''.$parent.'\', \''.$name.'\', \''.$link.'\', \''.$menuid.'\', \''.$appid.'\');');
    $msg = "Der Menueintrag wurde gespeichert.";
    return $msg;
  }
}