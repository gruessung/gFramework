<?php
 /*
 gFramework Frontend
 */

 /*
 So, dann starten wir mal die TPL Engine..*brum* xP
 */
 $template = new TPL();
 $user = new UserManagement();
 if (isset($_GET['login'])) {       
    if ($user->ifLogin()) {
      $user->UserLogout();
      $app = 1;
      if (!isset($_GET['app'])) { $app = $_GET['app']; }
      $html='Sie wurden erfolgreich abgemeldet!<br />
      <a href="index.php?app='.$app.'">Zur Startseite</a>.';
    }
    elseif (isset($_POST['login'])) {    
      $user = new UserManagement();
       
      if (!isset($_GET['from']) OR @$_GET['from']=="") {
        if ($_GET['app'] == "1")
        {
          $from = "index.php";
        }
        else
        {
          $from = "index.php?app=".$_GET['app'];
        }
        
      } else {
        $from = "index.php?app=".$_GET['app']."&".base64_decode($_GET['from']);
      }
    
      if ($user->UserLogin(mysql_real_escape_string($_POST['user']),mysql_real_escape_string($_POST['pass']))==true) {
        $html = 'Sie wurden erfolgreich angemeldet.<br />
        <a href="'.$from.'">Zur vorherigen Seite</a>.';
      } else {
        $html = 'Fehler beim Anmelden!<br />
        <a href="'.$from.'">Zur vorherigen Seite</a>.';
      } 
 } elseif (isset($_POST['regist'])) {
  if ($_POST['sicherheitscode']!=$_POST['c']) { $html = 'Sicherheitscode falsch!<br />
  <a href="index.php?p=Login">Zur&uuml;ck</a>.'; 
  } else { 
    $user = new UserManagement();   
  
    if ($user->Registration(mysql_real_escape_string(@$_POST['user']),mysql_real_escape_string(@$_POST['pass']),mysql_real_escape_string(@$_POST['mail']))==true) {
        $html = 'Ihr Konto wurde angelegt.<br />
        <a href="index.php">Zur Startseite</a>.';
    } else {
      $html = 'Es trat ein Fehler auf! Eventuell ist das Nutzername schon belegt!<br />
    <a href="index.php?p=Login">Zur&uuml;ck</a>.';
    }
  }
  }  else {
  if (!isset($_GET['from']) OR @$_GET['from']=="") {
        $from = "";
      } else {
        $from = $_GET['from'];
      }
	$c = rand(1000,9999);
  $html = 'Sollten Sie schon registriert sein, loggen Sie sich einfach mit folgenden Daten ein:<br />
  <table border="0" cellpadding="0" cellspacing="0">
  <form action="index.php?app=1&login&from='.$from.'" method="POST">
  <tr><td width="100">Benutzername:</td><td><input style="margin-bottom:3px;margin-top: 3px;" type="text" name="user" /></tr>
  <tr><td width="100">Passwort:</td><td><input style="margin-bottom:3px;" type="password" name="pass" /></tr>
  <tr><td width="100"></td><td><input style="margin-bottom:3px;" type="submit" name="login" value="Login"></tr>
  </form>
  </table> <br /><br />
  <b>Haben Sie sich noch nicht registriert?</b><br /><br />
  Dann jetzt (kostenlos) registrieren und folgende Privilegien genie&szlig;en:
  <ul>
  <li>nutzen Sie Funktionen der Website, welche nur registrieren Nutzern zur Verf&uuml;gung stehen</li>
  <li>treten Sie der Community bei</li>
  <li>tauschen Sie sich mit anderen Nutzern aus</li>
  <li>uvm.</li>
  </ul>
  <form action="index.php?app=1&login&from='.$from.'" method="POST">
  <table border="0" cellpadding="0" cellspacing="0">
  <tr><td width="100">Benutzername:</td><td><input style="margin-bottom:3px;" type="text" name="user"></tr>
  <tr><td width="100">Passwort:</td><td><input style="margin-bottom:3px;" type="password" name="pass"></tr>
  <tr><td width="100">E-Mail:</td><td><input style="margin-bottom:3px;" type="test" name="mail"></tr>
  <tr>
  <td>Bitte eingeben: '.$c.'</td>
  <td><input type="text" name="sicherheitscode" size="5"></td>
  </tr>
  <tr><td width="100"><input type="hidden" name="c" value="'.$c.'"></td><td><input type="submit" name="regist" value="Registrieren"></tr>
  </table>
  </form>
  ';    
  } 
  $template->text = $html; 
  $template->id = 1;
  $template->menuid = 1;
  $template->sitename = "Login";
  $template->show();
 
 }
 elseif (isset($_GET["imprint"])) {
   $hook = new gTPLHooks();
   $template->id = 1;
   $template->menuid = 1;
   $template->sitename = "Impressum";
   $template->text = $hook->get("imprint");
   $template->show();
 }
 elseif(isset($_GET['url']))
 {
   $template->id = 1;
   $template->menuid = 1;
   $template->sitename = "Weiterleitung...";
   $to = $_GET['to'];
   $template->text = "
   <meta http-equiv=\"refresh\" content=\"2; URL=$to\">
   Du wirst gleich auf <b>$to</b> weitergeleitet...";
   $template->show();
 }
 else
 {
  $template->text =  'Du wirst weitergeleitet...<meta http-equiv="refresh" content="0; URL=index.php">';
  $template->show();
 }

