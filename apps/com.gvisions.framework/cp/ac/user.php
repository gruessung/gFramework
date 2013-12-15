<?php
  $db = new db();
  $ac = "index";
  if (isset($_GET['ac2'])) { $ac = $_GET['ac2']; }
  if (isset($_GET['id'])) { $id = mysql_real_escape_string($_GET['id']); }
  
  switch($ac)
  {
    case "index":
      $db->query("SELECT * FROM ".pfw."_user ORDER BY id");
      $MenusTd = "";
      while ($MenusArray = $db->fetch()) {
        $MenusTd .= '<tr style="background-color:white;"><td style="width:50%;">'.$MenusArray->username.' ('.$MenusArray->mail.')</td><td "width:35%;"><a href="index.php?action=verwalten&appid=1&ac=user&ac2=edit&id='.$MenusArray->id.'">Verwalten</a> | <a href="index.php?action=verwalten&ac2=delete&ac=user&appid=1&id='.$MenusArray->id.'"><small>L&ouml;schen</small></a></td></tr>';
      }
      echo 'Anzahl der Benutzer: '.$db->num_rows().' | <a href="index.php?action=verwalten&appid=1&ac=user&ac2=new">Benutzer erstellen</a><br><div class="cel" style="height:auto;">
      <table style="width:100%;"><tr style="border: 1px black solid; "><td>Name</td><td>Optionen</td></tr> '.$MenusTd.'</table></div><br /><br />';
      
      break;
      
    case "new":
      if (!isset($_POST['regist']))
      {
          echo '
          <form action="index.php?action=verwalten&appid=1&ac=user&ac2=new" method="POST">
          <table border="0" cellpadding="0" cellspacing="0">
          <tr><td width="100">Benutzername:</td><td><input style="margin-bottom:3px;" type="text" name="user"></tr>
          <tr><td width="100">Passwort:</td><td><input style="margin-bottom:3px;" type="password" name="pass"></tr>
          <tr><td width="100">E-Mail:</td><td><input style="margin-bottom:3px;" type="test" name="mail"></tr>
          <tr><td width="100">Gruppe:</td><td>
              <select name="groupid">
              ';
          $db->query("SELECT * FROM ".pfw."_groups ORDER BY id");
          while ($row = $db->fetch())
          {
            echo '<option value="'.$row->id.'">'.$row->name.'</option>'; 
          }
          echo '
              </select>
          </tr>
          <tr><td></td><td><input type="submit" name="regist" value="Registrieren"></tr>
          </table>
          </form>';
      }
      else
      {
            $user = new gUserManagement();
  
            if ($user->Registration(mysql_real_escape_string(@$_POST['user']),mysql_real_escape_string(@$_POST['pass']),mysql_real_escape_string(@$_POST['mail']),mysql_real_escape_string(@$_POST['groupid']) )==true) {
                $html = 'Das Konto wurde angelegt.<br />';
            } else {
                $html = 'Es trat ein Fehler auf! Eventuell ist das Nutzername schon belegt!';
            }
            echo $html;
      }
     break;
    case "delete":
      
                if (isset($_GET['sure']))
          {
            $db = new db();
            $db->query("DELETE FROM ".pfw."_user WHERE `id` = $id;");
            echo "Benutzer wurde gel&ouml;scht!";
          }
          else
          {
              echo "Sind sie sicher, dass Sie den Nutzer l&ouml;schen wollen? Dies kann nicht r&uuml;ckg&auml;ngig gemacht werden!<br>";
              echo '<a href="index.php?action=verwalten&appid=1&ac=user&ac2=delete&id='.$id.'&sure">Ja</a> | <a href="javascript:history.back()">Nein</a>';
          } 
        
    break;
      
    case "edit":
      if (!is_numeric($id)) { die ('Parameter fehlt.'); }
      if (!isset($_POST['save']))
      {
          $db->query("SELECT * FROM ".pfw."_user WHERE id = $id");
          $row = $db->fetch();
          echo '
          <form action="index.php?action=verwalten&appid=1&ac=user&ac2=edit&id='.$id.'" method="POST">
          <table border="0" cellpadding="0" cellspacing="0">
          <tr><td width="100">Benutzername:</td><td><input value="'.$row->username.'" style="margin-bottom:3px;" type="text" name="user"></tr>
            <tr><td width="100">Passwort:<br><small>(leer:keine Aktion)</small></td><td><input  style="margin-bottom:3px;" type="password" name="pass"></tr>
          <tr><td width="100">E-Mail:</td><td><input value="'.$row->mail.'" style="margin-bottom:3px;" type="test" name="mail"></tr>
          <tr><td width="100">Gruppe:</td><td>
              <select name="groupid">
              ';
          $db->query("SELECT * FROM ".pfw."_groups ORDER BY id");
          while ($row2 = $db->fetch())
          {
            $x = "";
            if ($row->group == $row2->id) { $x = "selected"; }
            echo '<option value="'.$row2->id.'" '.$x.'>'.$row2->name.'</option>';
          }
          echo '
              </select>
          </tr>
          <tr><td></td><td><input type="submit" name="save" value="Speichern"></tr>
          </table>
          </form>';
      }
      else
      {
        $db->query("SELECT * FROM ".pfw."_user WHERE id = $id");
        $row = $db->fetch();
        
        $user = mysql_real_escape_string($_POST['user']);
        $mail = mysql_real_escape_string($_POST['mail']);
        $group = mysql_real_escape_string($_POST['groupid']);
        
        if (empty($user) || empty($mail)) { die ("Fehler."); }
        if (empty($_POST['pass'])) { $pass = $row->password; } else { $pass = mysql_real_escape_string(md5($_POST['pass'])); }
        
        $sql = "UPDATE `".db."`.`".pfw."_user` SET `username` = '".$user."',
                `password` = '".$pass."' ,
                `mail` = '".$mail."',
                `group` = '".$group."' WHERE `".pfw."_user`.`id` =".$id.";
               ";
        $db->query($sql);
        echo "User gespeichert.";
      }
      
      break;
      
  }
      
