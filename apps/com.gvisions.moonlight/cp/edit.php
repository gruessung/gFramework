

<?php

/*
Kommen wir zum eingemachten...^.^

Pr�fen wir ob pageid da ist und numeric ist
*/

if (!isset($_GET['pageid']) OR !is_numeric($_GET['pageid'])){
  trigger_error("Fehler bei der Verarbeitung / �bergabe von 'pageid'",E_USER_ERROR);
}

/*

Lade Seiten Daten

*/

$db  = new db();
$db->query("SELECT * FROM ".pfw."_gmoonpages WHERE id = ".$_GET['pageid']);
$row = $db->fetch();

/*

Gebe Formular aus

*/

?>

<?php
  if (isset($_POST['edit'])) {
  $sql= new db();
  $page = new page();
  $id=$page->init();
  $titel = strip_tags($_POST['titel']);
  $del=$_POST['del'];
  $text=$_POST['text'];
  if (is_numeric($_POST['menu'])) {
    $menu = $_POST['menu'];
  } else {
      trigger_error("Keine Menu ID �bergeben. Benutze Standard 1.",E_USER_NOTICE);
      $menu="1";
  }
  $q =$sql->query('UPDATE `'.db.'`.`'.pfw.'_gmoonpages` SET `titel` = \''.$titel.'\', `menu` = \''.$menu.'\', `delete` = \''.$del.'\', `text` = \''.$text.'\' WHERE `'.pfw.'_gmoonpages`.`id` = '.$id.' LIMIT 1;');
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




	  <form action="index.php?action=verwalten&comid=<?=$_GET['comid']?>&appid=<?php echo $_GET['appid']; ?>&ac=edit&pageid=<?php echo $_GET['pageid']; ?>" method="POST">
  <table style='border: 1px black solid; background-color:grey; color:black; width:90%;'>
  <tr class="tr"><td>Titel der Seite:</td><td><input type="text" name="titel" value="<?php echo $row->titel; ?>"></td></tr>
  <tr class="tr"><td>Menuzuordnung:</td>
  <td>

  <select name="menu"><br />

    <?php
      $nav = new nav();
      echo $nav->showAll($row->menu);
      ?>

  </select>  
</td></tr>
  <tr class="tr"><td valign="top">Inhalt:</td><td>  
  
<?php
if ( !function_exists('version_compare') || version_compare( phpversion(), '5', '<' ) )
	include_once( root.'apps/com.gvisions.framework/ckeditor/ckeditor_php4.php' ) ;
else
	include_once( root.'apps/com.gvisions.framework/ckeditor/ckeditor_php4.php' ) ;
  
$CKEditor = new CKEditor();

echo $CKEditor->editor("text", $row->text);  
?>
  </td></tr>

  <tr class="tr"><td>Seite vor l&ouml;schen sch&uuml;tzen ?</td><td><select name="del"><option value="true" selected>Nein</option><option value="false">Ja</option></select></td></tr>
  <tr class="tr"><td>Optionen:</td><td><input type="submit" name="edit" value="Speichern"> | <input type="reset" name="reset" value="&Auml;nderungen verwerfen"></td></tr>

  </form>
</table>

 

