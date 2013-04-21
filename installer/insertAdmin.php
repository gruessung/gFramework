<?php
	require_once("../core/config/mysql.php");
	mysql_connect($host, $user, $pass);
	mysql_select_db($db);

	foreach($_REQUEST as $k=>$v)
	{
		${$k} = $v;
	}
	
	$pass = md5($pass);
	
	 $sql = "INSERT INTO ".pfw."_user(`username`, `password`, `mail`, `group`) VALUES ('$user', '".$pass."', '$email','3');";
	 mysql_query($sql) or die ("ERRORADMIN#Fehler beim speichern des Benutzers.<br><br>$sql<br><br>".mysql_error());
?>