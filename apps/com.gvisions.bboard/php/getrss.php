<?='<?xml version="1.0" encoding="utf-8"?>'?>
 
<rss version="2.0">
 
  <channel>
    <title>BBoard - letzte Themen</title>
    <link>http://gvisions.de</link>
    <description>letzte Themen</description>
    <language>de-de</language>
<?php
	include '../../../core/gFramework.php';
	$db = new db(); 
	$db->query("SELECT * FROM ".pfw."_bboard_post WHERE topic = 0 ORDER BY id DESC LIMIT 7");
	
	while ($row = $db->fetch())
	{
	
	$datum = date("d.m.Y H:i",$row->date);
	
	$url = $_SERVER['SERVER_NAME'];
	
	
	echo '<item>
      <title>'.$row->name.'</title>
      <link>http://'.$url.'/';
      
      echo htmlentities('index.php?app_comid=com.gvisions.bboard&action=seeTopic&id='.$row->id);
      echo '</link>
      <guid>'.$row->id.'</guid>
      <pubDate>'.$datum.'</pubDate>
    	</item>';
	
	}
	
?>
  </channel>
 
</rss>