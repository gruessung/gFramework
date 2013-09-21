<?php

$html = "<center><a href=\"index.php?action=verwalten&comid=com.gvisions.bboard&see=Cat\">Kategorien</a> &bull; <a href=\"index.php?action=verwalten&comid=com.gvisions.bboard&see=Board\">Boards</a> &bull; <a href=\"index.php?action=verwalten&comid=com.gvisions.framework&ac=groups\">Gruppenrechte</a></center><br><br>";


$see = "";
if (isset($_GET["see"])) $see = $_GET['see'];
$db = new db();
switch ($see) {

case 'Cat':
	$db->query("SELECT * FROM ".pfw."_bboard_cat ORDER BY reihe ASC");
	$html .= "Gefundene Datens&auml;tze: ".$db->num_rows()." | <a href=\"index.php?action=verwalten&comid=com.gvisions.bboard&size=small&see=newCat\" class=\"thickbox\">Neue Kategorie</a><br><table style='border: 1px black solid; background-color:grey; color:black; width:80%;'>
  			<tr style='border: 1px black solid;'>
    						<td style='width:10%;'>ID</td>
    						<td style='width:50%;'>Name</td>
    						<td style='width:30%;'>Optionen</td>
 			 </tr>";
	while ($row=$db->fetch()) {
		$html .="<tr class=\"tr\"><td>".$row->id."</td><td>".$row->name."</td><td><a href=\"index.php?action=verwalten&comid=com.gvisions.bboard&see=editCat&catid=".$row->id."\" class=\"thickbox\">Bearbeiten</a></td></tr>";
	}
	$html .="</table>";
break;


case 'Board':
	$db->query("SELECT * FROM ".pfw."_bboard_board ORDER BY catid, reihe");
	$html .= "Gefundene Datens&auml;tze: ".$db->num_rows()." | <a href=\"index.php?action=verwalten&comid=com.gvisions.bboard&see=newBoard\">Forum anlegen</a><br><table class='table table-bordered'>
  			<tr>
    						<th>ID</td>
    						<th>Name</td>
						<th>Kategorie</td>
    						<th>Optionen</td>
 			 </tr>";
	while ($row=$db->fetch()) {
		$db2 = new db();
		$db2->query("SELECT `name` FROM ".pfw."_bboard_cat WHERE id = $row->catid");
		$cat = $db2->fetch();
		$cat = $cat->name;
		$html .="<tr class=\"tr\"><td>".$row->id."</td><td>".$row->name."</td><td>".$cat."</td><td><a href=\"index.php?action=verwalten&comid=com.gvisions.bboard&see=editBoard&boardid=".$row->id."\">Bearbeiten</a></td></tr>";
	}
	$html .="</table>";
break;

case 'newCat':
	if (!isset($_POST['go'])) {
	$html .='<form method="POST" action="index.php?action=verwalten&comid=com.gvisions.bboard&see=newCat">
	<table border="0">
	    <tr><td>Name:</td><td><input type="text" name="name" /></td></tr>
	    <tr><td>Reihenfolge:</td><td><input type="text" name="reihe" /></td></tr>
	    <tr><td></td><td><input type="submit" name="go" value="Speichern" /></td></tr>
	    </table></form>';
} else {
$db->query('INSERT INTO `'.pfw.'_bboard_cat` (`id`, `name`, `group`, `reihe`) VALUES (NULL, \''.$_POST['name'].'\', \'0\', \''.$_POST['reihe'].'\');');
$html .="Kategorie wurde angelegt.";
}

break;

case 'editCat':
	if (!isset($_POST['go'])) {
	$db->query("SELECT * FROM ".pfw."_bboard_cat WHERE id = ".$_GET['catid']."");
	$row = $db->fetch();
	$html .='<form method="POST" action="index.php?action=verwalten&comid=com.gvisions.bboard&see=editCat">
		<table>
			<tr><td>Name</td><td><input type="text" name="name" value="'.$row->name.'"></td></tr>
			<tr><td>Reihenfolge</td><td><input type="text" name="reihe" value="'.$row->reihe.'"></td></tr>
			<tr><td>L&ouml;schen?</td><td><select name="delete"><option value="false" selected>Nein</option><option value="true">Ja!</option></select></td></tr>
			<tr><td></td><input type="hidden" name="id" value="'.$_GET['catid'].'"><td><input type="submit" name="go" value="Speichern"></td></tr>
		</table>
		</form>';
	} else {
		if ($_POST['delete']=="true") {
			$sql ="DELETE FROM `".pfw."_bboard_cat` WHERE `id` = ".$_POST['id']." LIMIT 1;";
		} else {
			$sql = 'UPDATE `'.pfw.'_bboard_cat` SET `name` = \''.$_POST['name'].'\', `reihe` = \''.$_POST['reihe'].'\' WHERE `id` = '.$_POST['id'].' LIMIT 1;';
		}
	$db->query($sql);	
	$html .= "Die &Auml;nderungen wurden gespeichert.";
	}
break;


case 'editBoard':
	if (!isset($_POST['go'])) {
	$db->query("SELECT * FROM ".pfw."_bboard_board WHERE id = ".$_GET['boardid']."");
	$row = $db->fetch();
	$html .='<form method="POST" action="index.php?action=verwalten&comid=com.gvisions.bboard&see=editBoard">
		<table>
			<tr><td>Name</td><td><input type="text" name="name" value="'.$row->name.'"></td></tr>
			<tr><td>Kategorie</td><td><select name="cat">';
	$db2 = new db();
	$db2->query("SELECT * FROM ".pfw."_bboard_cat ORDER BY id ASC");
	while ($row2 = $db2->fetch()) {
		if ($row->catid==$row2->id) { $extra ="selected"; } else { $extra=""; }
		$html .='<option value="'.$row2->id.'" '.$extra.'>'.$row2->name.'</option>';	
	}
	$html .='	</select></td></tr>       
			<tr><td>Reihenfolge</td><td><input type="text" name="reihe" value="'.$row->reihe.'"></td></tr>
			<tr><td>L&ouml;schen?</td><td><select name="delete"><option value="false" selected>Nein</option><option value="true">Ja!</option></select></td></tr>
			<tr><td></td><input type="hidden" name="id" value="'.$_GET['boardid'].'"><td><input type="submit" name="go" value="Speichern"></td></tr>
		</table>
		</form>';
	} else {
		if ($_POST['delete']=="true") {
			$sql ="DELETE FROM `".pfw."_bboard_board` WHERE `id` = ".$_POST['id']." LIMIT 1;";
		} else {
			$sql = 'UPDATE `'.pfw.'_bboard_board` SET `name` = \''.$_POST['name'].'\', `reihe` = \''.$_POST['reihe'].'\', `catid` = \''.$_POST['cat'].'\' WHERE `id` = '.$_POST['id'].' LIMIT 1;';
		}
	$db->query($sql);	
	$html .= "Die &Auml;nderungen wurden gespeichert.";
	}
break;

case 'newBoard':
if (!isset($_POST['go'])) {
	$html .='<form method="POST" action="index.php?action=verwalten&comid=com.gvisions.bboard&see=newBoard">
		<table>
			<tr><td>Name</td><td><input type="text" name="name" ></td></tr>
			<tr><td>Kategorie</td><td><select name="cat">';
	$db2 = new db();
	$db2->query("SELECT * FROM ".pfw."_bboard_cat ORDER BY id ASC");
	while ($row2 = $db2->fetch()) {

		$html .='<option value="'.$row2->id.'">'.$row2->name.'</option>';	
	}
	$html .='	</select></td></tr>       
			<tr><td>Reihenfolge</td><td><input type="text" name="reihe" ></td></tr>
			<tr><td></td><td><input type="submit" name="go" value="Speichern"></td></tr>
		</table>
		</form>';

} else {
$db->query('INSERT INTO `'.pfw.'_bboard_board` (`id`, `name`, `catid`, `reihe`) VALUES (NULL, \''.$_POST['name'].'\', \''.$_POST['cat'].'\', \''.$_POST['reihe'].'\');');
$html .="Forum wurde angelegt.";
}

break;


}



echo $html;
