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
<b>Bitte loggen Sie sich ein:</b><br><br>
<form action="index.php" method="POST">

<table>
<tr class="tr"><td>Username</td><td><input type="text" name="username"></td></tr>
<tr class="tr"><td>Passwort</td><td><input type="password" name="password"></td></tr>
<tr class="tr"><td></td><td><input type="submit" class="btn btn-success" value="Login" name="login"></td></tr>

</table>

</form>
<?php
}
?>