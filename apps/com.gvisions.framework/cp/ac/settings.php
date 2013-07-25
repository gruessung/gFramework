<h3>Allgemeine Einstellungen</h3>

<br />

<?php
  if (isset($_POST["save"]))
	{
		$title = mysql_real_escape_string($_POST["newtitle"]);
		$db->query("UPDATE ".pfw."_config SET `value` = '$title' WHERE `name` = 'sitetitle'");
		echo '<div class="alert alert-success">Gespeichert.</div>';
	}
	else
	{
		$db->query("SELECT value FROM ".pfw."_config WHERE `name` = 'sitetitle'");
		$title = $db->fetch();
	}
?>

<form action="index.php?action=verwalten&appid=1&ac=settings" method="POST">

<table border="0">

	<tr>
		<td><legend>Seitentitel</legend><input type="text" name="newtitle" value="<?=$title?>" /></td>

	</tr>
	<tr>
	</tr>
	<tr>
		<td><input class="btn btn-primary" name="save" type="submit" value="Speichern" /></td>
	</tr>

</table>

</form>
