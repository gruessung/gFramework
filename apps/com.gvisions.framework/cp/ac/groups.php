<?php
  $db = new db();
  function checkbox($group,$flag) {
    $db = new db();
    $db->query("SELECT * FROM ".pfw."_group_right WHERE `group` = '$group' AND `right` = '$flag'");
    $t = $db->fetch();
    if ($db->num_rows() == "1" OR $db->num_rows() == 1) {
      $d = '<a href="#" onClick="document.location.href=\'index.php?action=verwalten&appid=1&ac=groups&ac2=rights&id='.$group.'&delete='.$t->id.'\'">
            <input type="checkbox"  checked></a>';
       
  
    } else {
      $d = '<a href="#" onClick="document.location.href=\'index.php?action=verwalten&appid=1&ac=groups&ac2=rights&id='.$group.'&new='.$flag.'\'">
            <input type="checkbox"></a>';
    }
    return $d;
  }
  $ac = "index";
  if (isset($_GET['ac2'])) { $ac = $_GET['ac2']; }
  if (isset($_GET['id'])) { $id = $_GET['id']; }
  
  switch($ac) {
  
    case "index":
      $GroupsTd = "";
      $db->query("SELECT * FROM ".pfw."_groups ORDER BY id");
      while ($GroupsArray = $db->fetch()) {
        $GroupsTd .= '<tr style="background-color:white;"><td style="width:50%;">'.$GroupsArray->name.'</td><td "width:35%;"><a href="index.php?action=verwalten&appid=1&ac=groups&ac2=rights&id='.$GroupsArray->id.'">Rechte verwalten</a> | <a href="index.php?action=verwalten&ac2=delete&ac=groups&appid=1&groupid='.$GroupsArray->id.'"><small>L&ouml;schen</small></a></td></tr>';
      }
      echo 'Anzahl der Gruppen: '.$db->num_rows().' | <a href="index.php?action=verwalten&appid=1&ac=groups&ac2=new">Neue Gruppe</a><br><div class="cel" style="height:auto;">
      <table style="width:100%;"><tr style="border: 1px black solid; "><td>Name</td><td>Optionen</td></tr> '.$GroupsTd.'</table></div><br /><br />';
    break;
    
    case "rights":
          $db = new db();
          if (isset($_GET['delete'])) {
            $d = mysql_real_escape_string($_GET['delete']);
            $db->query("DELETE FROM `".db."`.`".pfw."_group_right` WHERE `".pfw."_group_right`.`id` = $d;");
            echo'<div class="alert alert-success"><b>Gespeichert</b></div>';
          }
          if (isset($_GET['new'])) {
            $d = mysql_real_escape_string($_GET['new']);
            $db->query("INSERT INTO  `".db."`.`".pfw."_group_right` (
                      `id` ,
                      `group` ,
                      `right`
                      )
                      VALUES (
                      NULL ,  '$id',  '$d'
                      );");
              echo'<div class="alert alert-success"><b>Gespeichert</b></div>';
          }
              
          $db = new db();
          $db->query("SELECT * FROM ".pfw."_groups WHERE id = $id;");
          $Group = $db->fetch();
          
          $ArrayRightGroups = array();
          $db->query("SELECT `group` FROM ".pfw."_rights");
          while ($Rights = $db->fetch()) {
            if (!in_array($Rights->group,$ArrayRightGroups)) {
              array_push($ArrayRightGroups,$Rights->group);
            }
          }
          $count = count($ArrayRightGroups);
          
          for ($i = 0;$i <= $count - 1;$i++) {
          $warnung = "";
          if ($id == $_SESSION['group']) { $warnung = " &bull; <b>Achtung! Sie bearbeiten Ihre eigene Usergruppe!</b>"; }
          echo 'Sektion: <a name="'.$ArrayRightGroups[$i].'">'.$ArrayRightGroups[$i].'</a><br>
                <div class="runde-ecken" style="height:auto;">
                <div class="cel" style="height:auto;width:100%;">
                <table style="width:100%;">
                
                  <tr style="border: 1px black solid;">
                    <td style="width:95%;">Recht <font color="red">'.$warnung.'</font></td>
                    <td style="width:5%;">Option</td>
                  </tr>
                </table>
                </div>
                <table style="width:100%;">';
            $db->query("SELECT * FROM ".pfw."_rights WHERE `group` = '".$ArrayRightGroups[$i]."'");
            while ($rights = $db->fetch()) {
              echo '<tr style="border: 1px black solid;">
                      <td style="width:95%;"><b>'.$rights->name.'</b><br><small><i>'.$rights->desc.'</i></small></td>
                      <td style="width:5%;">'.checkbox($id,$rights->id).'</td>
                    </tr>';
            }
              echo "</table></div><br>";
          
          }
          
    break;
    
    
    case "delete":
          $id = $_GET['groupid'];
          if ($id == "1" OR $id == "2" OR $id == "3" OR $id == "4") {
            echo "Die Standardgruppen k&ouml;nnen nicht gel&ouml;scht werden.";
            break;
          }
          $d = mysql_real_escape_string($id);
          $db->query("DELETE FROM `".db."`.`".pfw."_groups` WHERE `".pfw."_groups`.`id` = $d;");
          $db->query("UPDATE  `".db."`.`".pfw."_user` SET  `group` =  '".user_group."' WHERE  `gframework_user`.`group` =$id;");
          echo "Die Gruppe wurde erfolgreich gel&uuml;scht. Alle Nutzer der Gruppe wurden der Standardgruppe \"Benutzer\" zugeordnet.";
    break;
    
    case "new":
    if (isset($_POST['new'])) {
      $db = new db();
      $name = mysql_real_escape_string($_POST['name']);
      $desc = mysql_real_escape_string($_POST['desc']);
      $db->query("INSERT INTO  `".db."`.`".pfw."_groups` (
                  `id` ,
                  `name` ,
                  `desc`
                  )
                  VALUES (
                  NULL ,  '$name',  '$desc'
                  );");
      echo "Die Gruppe <b>$name</b> wurde erstellt.";
      break;
    }
    echo '<form action="index.php?action=verwalten&appid=1&ac=groups&ac2=new" method="POST">
          Neuer Gruppenname: <input type="text" name="name" /><br>
          Kurze Beschreibung: <input type="text" name="desc" /><br>
          <input type="submit" name="new" value="Speichern" />
          </form>';
  
  }