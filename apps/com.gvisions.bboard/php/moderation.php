<?php
	if (isset($_GET["pinn"]))
	{
		$id = mysql_real_escape_string($_GET["id"]);
		if (!is_numeric($id)) die("Fehler bei ID");
		$db = new db();
		$user = new gUserManagement();
		if (/*$row->autor != $user->getCurrentUser() ||*/ $user->userGroup($user->getCurrentUser()) != admin_group)
		{
			die ("Du bist nicht zu dieser Aktion berechtigt.");	
		}
		
		$db->query("SELECT * FROM ".pfw."_bboard_post WHERE id = $id");
		$row = $db->fetch();
		$sql = "UPDATE ".pfw."_bboard_post SET `pinned` = '0' WHERE id = $id";	
		if ($row->pinned == "0")
		{
			$sql = "UPDATE ".pfw."_bboard_post SET `pinned` = '1' WHERE id = $id";	
		}
		$db->query($sql);
		$html .= "Der Beitrag wurde moderiert.<br /><a href=\"javascript:history.back();\">zur&uuml;ck</a>";
	}

		
?>