<h3>Allgemeine Einstellungen</h3>

<br />

<?php
	if (isset($_POST["save"]))
	{
		$title = mysql_real_escape_string($_POST["newtitle"]);
		$db->query("UPDATE ".pfw."_config SET `value` = '$title' WHERE `name` = 'sitetitle'");
        if ($_POST["seo"])
        {
            $db->query("UPDATE ".pfw."_config SET `value` = 'true' WHERE `name` = 'seo_url'");
            $seo_url = true;
        }
        else
        {
            $db->query("UPDATE ".pfw."_config SET `value` = 'false' WHERE `name` = 'seo_url'");
            $seo_url = false;
        }
		echo '<div class="alert alert-success">Gespeichert.</div>';
	}
	else
	{
		$title = sitetitle;
        $seo_url = seo_url;
	}


?>

<form action="index.php?action=verwalten&appid=1&ac=settings" method="POST">

<table border="0">

	<tr>
		<td><legend>Seitentitel</legend><input type="text" name="newtitle" value="<?=$title?>" /></td>
    </tr>
    <tr>
        <td><legend>SEO Url  <a class="label label-warning">Beta</a></legend><input type="checkbox" name="seo" <?php if ($seo_url) echo "checked"; ?>  /> <small>Aktivieren</small></td>

	</tr>

	<tr>
		<td><br /><br /><input class="btn btn-primary" name="save" type="submit" value="Speichern" /></td>
	</tr>

</table>

</form>
