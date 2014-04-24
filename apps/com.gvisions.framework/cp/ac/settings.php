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
        $imprint = mysql_real_escape_string($_POST["impressum"]);
        $db->query("UPDATE ".pfw."_hooks SET `code` = '$imprint' WHERE `name` = 'imprint'");
        echo '<div class="alert alert-success">Gespeichert.</div>';
	}
	else
	{
		$title = sitetitle;
        $seo_url = seo_url;
	}


?>

<form action="index.php?action=verwalten&appid=1&ac=settings" method="POST">

<table class="table">

	<tr>
		<td>Seitentitel</td><td><input type="text" name="newtitle" value="<?=$title?>" /></td>
    </tr>
    <tr>
        <td>SEO Url  <a class="label label-warning">Beta</a></td><td><!--<input type="checkbox" name="seo" <?php if ($seo_url =="true") echo "checked"; ?>  /> <small>Aktivieren</small>--><small>Funktion wurde vorr&uuml;bergehend aus gFramework entfernt.</small></td>

	</tr>



    <tr>
        <td>Impressum<br/><small><a href="http://www.e-recht24.de/impressum-generator.html" target="_blank">Generator</a></small></td>
        <td>
            <?php
                $db->query("SELECT code FROM ".pfw."_hooks WHERE `name`= 'imprint'");
                $row = $db->fetch();

                require_once("../../apps/com.gvisions.framework/ckeditor/ckeditor_php5.php");
                $editor = new CKEditor();
                $editor->editor("impressum", $row->code);
            ?>
        </td>
    </tr>

    <tr>
        <td><input class="btn btn-primary" name="save" type="submit" value="Speichern" /></td><td></td>
    </tr>


</table>

</form>