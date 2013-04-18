<?php
if (isset($_POST['login'])) {
  $username = mysql_real_escape_string($_POST['username']);
  $password = mysql_real_escape_string($_POST['password']);
  $password = md5($password);
  if ($user->UserLogin($username,$password,false)==true) {
      echo 'Sie wurden erfolgreich eingeloggt.<br><a href="index.php">Zum ControlPanel</a>';
  }

}
if (!$user->IfLogin()) {
?>
<b>Bitte loggen Sie sich ein:</b>
<form action="index.php" method="POST">

<table>
<tr class="tr"><td>Username</td><td><input type="text" name="username"></td></tr>
<tr class="tr"><td>Passwort</td><td><input type="password" name="password"></td></tr>
<tr class="tr"><td></td><td><input type="submit" value="Login" name="login" style="background-color:darkgrey;width:145px;"></td></tr>

</table>

</form>
<?php
}
?>