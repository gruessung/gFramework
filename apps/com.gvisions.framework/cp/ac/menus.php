<?php
  $db = new db();
  $ac = "index";
  if (isset($_GET['ac2'])) { $ac = $_GET['ac2']; }
  if (isset($_GET['id'])) { $id = mysql_real_escape_string($_GET['id']); }
  if (isset($_GET['subid'])) { $subid2 = mysql_real_escape_string($_GET['subid']); }
  if (isset($_GET['entrie'])) { $subid = $_GET['entrie']; }
  
  switch($ac) {
  
    case "index":
      $MenusTd = "";
      $db->query("SELECT * FROM ".pfw."_menus ORDER BY id");
      while ($MenusArray = $db->fetch()) {
        $MenusTd .= '<tr style="background-color:white;"><td style="width:50%;">'.$MenusArray->name.'</td><td "width:35%;"><a href="index.php?action=verwalten&appid=1&ac=menus&ac2=edit&id='.$MenusArray->id.'">Eintr&auml;ge verwalten</a> | <a href="index.php?action=verwalten&ac2=delete&ac=menus&appid=1&id='.$MenusArray->id.'"><small>L&ouml;schen</small></a></td></tr>';
      }
      echo 'Anzahl der Menus: '.$db->num_rows().' | <a href="index.php?action=verwalten&appid=1&ac=menus&ac2=new">Menu erstellen</a><br><div class="cel" style="height:auto;">
      <table style="width:100%;"><tr style="border: 1px black solid; "><td>Name</td><td>Optionen</td></tr> '.$MenusTd.'</table></div><br /><br />';
    break;
    
    case "edit":
      if (!is_numeric($id)) { die ('MenuID fehlt.'); }
      if (isset($_GET['up'])) {
        $db->query("SELECT `reihe` FROM ".pfw."_menuentries WHERE id = $subid");
        $row = $db->fetch();
        $new = $row->reihe - 1;
        $db->query("UPDATE  `".db."`.`".pfw."_menuentries` SET  `reihe` =  '$new' WHERE  `".pfw."_menuentries`.`id` =$subid;");
      }
      if (isset($_GET['down'])) {
        $db->query("SELECT `reihe` FROM ".pfw."_menuentries WHERE id = $subid");
        $row = $db->fetch();
        $new = $row->reihe + 1;
        $db->query("UPDATE  `".db."`.`".pfw."_menuentries` SET  `reihe` =  '$new' WHERE  `".pfw."_menuentries`.`id` =$subid;");
      }
      $MenusTd = "";
      $db->query("SELECT * FROM ".pfw."_menuentries WHERE menu = $id AND parent = 0 ORDER by reihe ASC");
      while ($MenusArray = $db->fetch()) {
        $MenusTd .= '<tr style="background-color:white;"><td style="width:50%;">'.$MenusArray->name.'</td><td "width:35%;"><a href="index.php?action=verwalten&appid=1&ac=menus&ac2=edit&id='.$id.'&entrie='.$MenusArray->id.'&up">hoch</a> | <a href="index.php?action=verwalten&appid=1&ac=menus&ac2=edit&id='.$id.'&entrie='.$MenusArray->id.'&down">runter</a> | <a href="index.php?action=verwalten&appid=1&ac=menus&ac2=newEntrie&id='.$id.'&parent='.$MenusArray->id.'">Unterpunkt erstellen</a> | <a href="index.php?action=verwalten&ac2=delete&ac=menus&appid=1&subid='.$MenusArray->id.'"><small>L&ouml;schen</small></a></td></tr>';
        $db_sub = new db();
        $db_sub->query("SELECT * FROM ".pfw."_menuentries WHERE parent = ".$MenusArray->id." ORDER BY reihe ASC");
        while ($row = $db_sub->fetch()) {
          $MenusTd .= '<tr style="background-color:white;"><td style="width:50%;"> >>'.$row->name.'</td><td "width:35%;"><a href="index.php?action=verwalten&appid=1&ac=menus&ac2=edit&id='.$id.'&entrie='.$row->id.'&up">hoch</a> | <a href="index.php?action=verwalten&appid=1&ac=menus&ac2=edit&id='.$id.'&entrie='.$row->id.'&down">runter</a> | <a href="index.php?action=verwalten&ac2=delete&ac=menus&appid=1&subid='.$row->id.'"><small>L&ouml;schen</small></a></td></tr>';  
        }
      }
      echo '<a href="index.php?action=verwalten&appid=1&ac=menus&ac2=newEntrie&parent=0&id='.$id.'">Oberpunkt erstellen</a><br><div class="cel" style="height:auto;">
      <table style="width:100%;"><tr style="border: 1px black solid; "><td>Name</td><td>Optionen</td></tr> '.$MenusTd.'</table></div><br /><br />';
  
  
      break;
  
      case "newEntrie":
          $db = new db();
          $plugin = new plugin();
          if (isset($_GET['parent'])) { $parent = mysql_real_escape_string($_GET['parent']); }
          if (!is_numeric($parent)) { trigger_error("Der Parameter 'parent' muss numerisch sein!", E_USER_ERROR); }
          
      if (isset($_POST['intern']))
      {
          $name = mysql_real_escape_string($_POST['name']);
          $link = mysql_real_escape_string($_POST['intern']);
          $menu = $id;
          $sql = 'INSERT INTO `'.db.'`.`'.pfw.'_menuentries` (
                    `id` ,
                    `parent` ,
                    `name` ,
                    `link` ,
                    `menu` ,
                    `reihe` ,
                    `app`
                )
                VALUES (
                    NULL , \''.$parent.'\', \''.$name.'\', \''.$link.'\', \''.$menu.'\', \'0\', \''.$plugin->getID("com.gvisions.moonlight").'\'
                );'; 
          $db->query($sql);
         echo "Menupunkt angelegt!";
         break;
      }
      elseif (isset($_POST['app_sub']))
      {
          $name = mysql_real_escape_string($_POST['name']);
          $link = mysql_real_escape_string($_POST['app']);
          $link = explode("-",$link);
          $appid = $link[0];
          $link = $link[1];
          $menu = $id;
          $sql = 'INSERT INTO `'.db.'`.`'.pfw.'_menuentries` (
                    `id` ,
                    `parent` ,
                    `name` ,
                    `link` ,
                    `menu` ,
                    `reihe` ,
                    `app`
                )
                VALUES (
                    NULL , \''.$parent.'\', \''.$name.'\', \''.$link.'\', \''.$menu.'\', \'0\', \''.$appid.'\'
                );'; 
          $db->query($sql);
         echo "Menupunkt angelegt!";
         break;
      }
      elseif (isset($_POST['ext_sub']))
      {
          $name = mysql_real_escape_string($_POST['name']);
          $link = "url&to=".mysql_real_escape_string($_POST['extern']);
          $appid = 1;
          $menu = $id;
          $sql = 'INSERT INTO `'.db.'`.`'.pfw.'_menuentries` (
                    `id` ,
                    `parent` ,
                    `name` ,
                    `link` ,
                    `menu` ,
                    `reihe` ,
                    `app`
                )
                VALUES (
                    NULL , \''.$parent.'\', \''.$name.'\', \''.$link.'\', \''.$menu.'\', \'0\', \''.$appid.'\'
                );'; 
          $db->query($sql);
         echo "Menupunkt angelegt!";
         break;
      }
      
          echo 'W&auml;hlen Sie bitte aus einer der Optionen:';
          
          //intern
          echo "<table border=0><tr><td>";
          echo '<fieldset><legend>Auf eine interne Seite verlinken</legend>';
          if ($plugin->isRegist("com.gvisions.moonlight") == false)
          {
            echo "Sie haben kein <a href=\"http://site.gvisions.de/index.php?app_comid=com.gvisions.gallery&comid=com.gvisions.gmoonlight\"gMoon!ight</a> installiert/aktiviert!";
          }
         else
          {
               echo '<form action="index.php?action=verwalten&appid=1&ac=menus&ac2=newEntrie&id='.$id.'&parent='.$parent.'" method="POST">
                    <select name="intern">';
               $db->query("SELECT * FROM ".pfw."_gmoonpages ORDER BY id ASC");
               while ($row = $db->fetch())
               {
                 echo '<option value="pageid='.$row->id.'">'.$row->titel.'</option>';
               }
            echo '</select><input type="submit" name="int_sub" value="Speichern" /><br><input type="text" name="name" value="Linkname" /></form>';
          }
          echo '</fieldset>';
      echo "</td><td>";
      
           //Eextension
          echo '<fieldset><legend>Auf eine Erweiterung verlinken</legend>';
      $db->query("SELECT * FROM ".pfw."_plugin_links ORDER BY appid ASC"); //TODO: Tabelle pfw_plugin_links erstellen, um da Links zu speichern, welche die Apps mitbringen, zB gFramework->login, logout, regist
          echo '<form action="index.php?action=verwalten&appid=1&ac=menus&ac2=newEntrie&parent='.$parent.'&id='.$id.'&" method="POST">
                <select name="app">';
          while ($row = $db->fetch())
          {
            echo '<option value="'.$row->appid.'-'.$row->link.'">('.$row->appname.') '.$row->linkname.'</option>';
          }
          echo '</select><input type="submit" name="app_sub" value="Speichern" /><br><input type="text" name="name" value="Linkname" /></form>';
          echo '</fieldset>';  
          
          
          //URL    
          echo "</td></tr><tr><td>";     
          echo '<fieldset><legend>Auf externe Seite verlinken</legend>';
          echo '<form action="index.php?action=verwalten&appid=1&ac=menus&ac2=newEntrie&parent='.$parent.'&id='.$id.'&" method="POST">
            <input type="text" name="extern" value="http://" /><input type="submit" name="ext_sub" value="Speichern" /><br><input type="text" name="name" value="Linkname" /></form>';  
          echo '</fieldset>';
          echo "</td></tr></table>";
      break;
  
      case "delete":
      if (isset($_GET['subid']))
      {
        $d = $_GET['subid'];
        if ($d == "1" || $d == "2" || $d == "3")
        {
          echo "Die Standardmenus d&uuml;rfen nicht gel&ouml;scht werden.";
          break;
        }
          if (isset($_GET['sure']))
          {
            $db = new db();
            $db->query("DELETE FROM ".pfw."_menuentries WHERE `id` = $subid2;");
            echo "Eintrag wurde gel&ouml;scht!";
          }
          else
          {
              echo "Sind sie sicher, dass Sie den Menupunkt l&ouml;schen wollen? Alle Unterpunkte gehen verloren!<br>";
              echo '<a href="index.php?action=verwalten&appid=1&ac=menus&ac2=delete&subid='.$subid2.'&sure">Ja</a> | <a href="javascript:history.back()">Nein</a>';
          }
      }
      elseif(isset($_GET['id']))
      {
        $d = $_GET['id'];
        if ($d == "1" || $d == "2" || $d == "3")
        {
          echo "Die Standardmenus d&uuml;rfen nicht gel&ouml;scht werden.";
          break;
        }
          if (isset($_GET['sure']))
          {
            $db = new db();
            $db->query("DELETE FROM ".pfw."_menus WHERE `id` = $id;");
            $db->query("DELETE FROM ".pfw."_menuentries WHERE `parent` = $id;");
            echo "Eintrag wurde gel&ouml;scht!";
          }
          else
          {
              echo "Sind sie sicher, dass Sie das Menu l&ouml;schen wollen? Alle Unterpunkte gehen verloren!<br>";
              echo '<a href="index.php?action=verwalten&appid=1&ac=menus&ac2=delete&id='.$id.'&sure">Ja</a> | <a href="javascript:history.back()">Nein</a>';
          } 
      }
      break;
      
    case "new":
          $db = new db();
      if (!isset($_POST['new'])){
        echo '<form action="index.php?action=verwalten&appid=1&ac=menus&ac2=new" method="POST">Menuname:<input type="text" name="name" /><input type="submit" name="new" value="Speichern" /></form>'; 
      }
      else
      {
          $sql = 'INSERT INTO `d012562f`.`gframework_menus` (
                    `id` ,
                    `name`
                )
                VALUES (
                    NULL , \''.mysql_real_escape_string($_POST['name']).'\');';
          $db->query($sql);
        echo "Menu angelegt.";
      }
      break;
      
  }