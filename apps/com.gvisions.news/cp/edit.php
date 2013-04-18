

<?php

/*
Kommen wir zum eingemachten...^.^

Prüfen wir ob pageid da ist und numeric ist
*/

if (!isset($_GET['id']) OR !is_numeric($_GET['id'])){
  trigger_error("Fehler bei der Verarbeitung / Übergabe von 'id'",E_USER_ERROR);
}

/*

Lade Seiten Daten

*/

$db  = new db();
$db->query("SELECT * FROM ".pfw."_gvisions_news WHERE id = ".mysql_real_escape_string($_GET['id']));
$row = $db->fetch();

/*

Gebe Formular aus

*/

?>

<?php
  if (isset($_POST['edit'])) {
  $sql= new db();
  $id = $_POST["id"];
  $titel = strip_tags($_POST['titel']);
  $tags=$_POST['tags'];
  $text=$_POST['text'];

  $q =$sql->query('UPDATE `'.db.'`.`'.pfw.'_gvisions_news` SET `titel` = \''.$titel.'\', `text` = \''.$text.'\', `tags` = \''.$tags.'\' WHERE `'.pfw.'_gvisions_news`.`id` = '.$id.' LIMIT 1;');
  if ($q == true) {
    echo 'Die &Auml;nderungen wurden gespeichert!';
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
  <tr class="tr"><td>Titel:</td><td><input type="text" name="titel" value="<?=$row->titel?>"></td></tr>
  <tr class="tr"><td>Tags:</td><td><input type="text" name="tags" value="<?=$row->tags?>"></td></tr>
  <tr class="tr"><td valign="top">Inhalt:</td><td>
  <?php
if ( !function_exists('version_compare') || version_compare( phpversion(), '5', '<' ) )
	include_once( root.'apps/com.gvisions.framework/ckeditor/ckeditor_php4.php' ) ;
else
	include_once( root.'apps/com.gvisions.framework/ckeditor/ckeditor_php4.php' ) ;
  
$CKEditor = new CKEditor();
echo $CKEditor->editor("text",$row->text);  
?>
  </td></tr>
  
  <tr class="tr"><td>Optionen:</td><td><input type="hidden" name="id" value="<?=$row->id?>" /><input type="submit" name="edit" value="Speichern"> | <input type="reset" name="reset" value="&Auml;nderungen verwerfen"></td></tr>

  </form>
 

