<?php

if (isset($_POST['u']))
{
  echo "Bitte warten...<br><br>";   
  if (strpos($_FILES['zip_file']['type'],"zip") != false)
  {
    if (move_uploaded_file($_FILES['zip_file']['tmp_name'], root."/upload/".$_FILES['zip_file']['name']))
    {
      echo "ZIP Datei hochgeladen.<br>";
    } 
    else
    {
      die("Fehler beim Hochladen der ZIP Datei.");
    }
   
  }
  else
  {
    die ("<b>Fehler:</b> Ung&uuml;ltige Zip Datei - ".$_FILES['zip_file']['type']);
  }
  
  if (strpos($_FILES['xml_file']['type'],"xml") != false)
  {
    if(move_uploaded_file($_FILES['xml_file']['tmp_name'], root."/upload/".$_FILES['xml_file']['name']))
    {
      echo "XML Datei hochgeladen.<br>";
    } 
    else
    {
      die("Fehler beim Hochladen der XML Datei.");
    }
  }
  else
  {
    die ("<b>Fehler:</b> Ung&uuml;ltige XML Datei - ".$_FILES['zip_file']['type']);
  }
  echo "<br>Starte Installation...<br>";
  echo '<meta http-equiv="refresh" content="2; URL=index.php?action=download&file='.$_FILES['xml_file']['name'].'&srv=0&step=1">';

}
else
{
?>
W&auml;hlen Sie bitte die ZIP Datei und die XML Datei von Ihrem Rechner aus.<br><br>

<form action="index.php?action=install_upload" method="POST" enctype="multipart/form-data"> 
ZIP Datei: <input type="file" name="zip_file"><br>
XML Datei: <input type="file" name="xml_file"><br>
<input type="submit" value="Hochladen & Installation starten" name="u"> 
</form>
<?php } ?>
