<?php
	$id = mysql_real_escape_string($_GET["id"]);
	
	if (!is_numeric($id)) die("Fehler mit der ID");
	$user = new UserManagement();
	$db = new db();
	$db->query("SELECT * FROM ".pfw."_bboard_post WHERE id = $id");
	$row = $db->fetch();
	
	if (/*$row->autor != $user->getCurrentUser() ||*/ $user->userGroup($user->getCurrentUser()) != admin_group)
	{
		die ("Du bist nicht zu dieser Aktion berechtigt.");	
	}
	
	if (!isset($_GET["sure"]))
	{
		if ($row->topic == 0)
		{
			$html .= "Achtung: Dies ist der erste Beitrag des Themas. Beim Entfernen wird das ganze Thema entfernt.<br />";		
		}
		$html .= "Sind Sie sicher, dass Sie den Beitrag entfernen wollen?<br />";
		$html .= "<a href=index.php?app_comid=com.gvisions.bboard&action=deletePosting&id=$id&sure>Ja</a> &bull; <a href=\"javascript:history.back();\">Nein</a>";
	}
	else
	{
		$db->query("DELETE FROM ".pfw."_bboard_post WHERE id = $id");
		$db->query("DELETE FROM ".pfw."_bboard_post WHERE topic = $id");
		$html .= "Gel&ouml;scht.";
	}
		
?>