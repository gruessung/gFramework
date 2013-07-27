<?php
error_reporting(E_ALL);
class gInstall extends gFramework {
  
  function download($file) {
    if(!fwrite(fopen('downloads/'.basename($file),'w+'),file_get_contents($file))) { return false; } else { return true; }
  }
  
  function extract($file,$path) {
    $zip = new ZipArchive;
    if ($zip->open('downloads/'.$file) === TRUE) {
      $zip->extractTo($path);
      $zip->close();
      return true;
    } else {
      return false;
    }
  }
  
  function downloadFile($file,$destination){}
  
  function Unistall($id) {
    $dbc = new db();
    $dbc->query("SELECT * FROM ".prafix."_plugins WHERE `id` = ".$id);
    $row=$dbc->fetch();
    require_once('application/unistall/unistall_'.$row->filename.'.php');
    echo "<!-- ".$unistall."-->";
    if ($unistall==true) {
      return true;
    } else {
      return false;
    }
   }

}
?>