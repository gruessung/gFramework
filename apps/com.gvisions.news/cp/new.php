<?php

/*
Kommen wir zum eingemachten...^.^



/*

Gebe Formular aus

*/

?>

<?php
  if (isset($_POST['edit'])) {
  $sql= new db();

  $titel = strip_tags($_POST['titel']);
  $tags=$_POST['tags'];
  $text=$_POST['text'];
  $date = date("d.m.Y - H:i", time()); 
  $q = $sql->query("INSERT INTO ".pfw."_gvisions_news (`titel`,`tags`,`text`,`date`, `author`) VALUES ('$titel','$tags','$text','$date','".$_SESSION["userid"]."');");
  
  

  if ($q == true) {
    echo 'Der Artikel wurden gespeichert!<br><a href="index.php?action=verwalten&comid=com.gvisions.news&ac=list_all">Zur&uuml;ck zur &Uuml;bersicht</a>';
    die();
  }
  else
  {
    echo  'Es trat ein Fehler auf!';
    die();
  }
}
?>




	  <form action="index.php?action=verwalten&comid=<?=$_GET['comid']?>&appid=<?php echo $_GET['appid']; ?>&ac=new" method="POST">
  <table style='border: 1px black solid; background-color:grey; color:black; width:90%;'>
  <tr class="tr"><td>Titel:</td><td><input type="text" name="titel" value=""></td></tr>
  <tr class="tr"><td>Tags:</td><td><input type="text" name="tags" value=""></td></tr>
  <tr class="tr"><td valign="top">Inhalt:</td><td>
  <?php
if ( !function_exists('version_compare') || version_compare( phpversion(), '5', '<' ) )
	include_once( root.'apps/com.gvisions.framework/ckeditor/ckeditor_php4.php' ) ;
else
	include_once( root.'apps/com.gvisions.framework/ckeditor/ckeditor_php4.php' ) ;
  
$CKEditor = new CKEditor();
echo $CKEditor->editor("text","");  
?>
  </td></tr>
  <tr class="tr"><td>Optionen:</td><td><input type="submit" name="edit" value="Speichern"> | <input type="reset" name="reset" value="&Auml;nderungen verwerfen"></td></tr>

  </form>

 

