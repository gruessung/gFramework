<?php
/*
Class Styles
to manage styles by gFramework
*/

class Style extends gFramework
{

   public function Registration($name,$desc,$comid,$path,$version,$server,$pluginActive="true") {
    if (!$this->ifRegist($comid)) {
      $sql = "INSERT INTO `".datenbank."`.`".pfw."_styles`(`id`,`name`,`com_id`,`desc`,`path`,`version`) VALUE (NULL,'$name','$comid','$desc','$path','$version');";
      $db = new db();
      $db->query($sql);
      return true;
    }
    return false;
   } 
  
    public function getVersion($comid=false) {
  if($comid!=false) { $plugin = $comid; } else { $plugin = $this->comid; }
  $sql = new db();
  $sql->query("SELECT `version` FROM `".pfw."_styles` WHERE `com_id` = '".$plugin."'");  
  $version = $sql->fetch();

  return $version->version;
  }
  
    public function getID($comid=false) {
  if($comid!=false) { $plugin = $comid; } else { $plugin = $this->comid; }
  $sql = new db();
  $sql->query("SELECT `id` FROM `".pfw."_styles` WHERE `com_id` = '".$plugin."'");  
  $version = $sql->fetch();

  return $version->id;
  }
  
  function ifRegist($comid) {
    $db = new db();
    $db->query("SELECT * FROM ".pfw."_styles WHERE `com_id`   = '$comid'");
    $num = $db->num_rows();

    if ($num==0) { return false; } else { return true; }
  }
  
  
    public function Update($spalte,$neuerWert,$comid) {
    $sql = new db();
    $sql->query("UPDATE  `".datenbank."`.`".pfw."_styles` SET  `$spalte` =  '$neuerWert' WHERE  `".pfw."_styles`.`com_id` ='$comid';");
    return true;
  }
  
  
  function Delete($path) {
  $db = new db();
  $sql = 'DELETE FROM `'.pfw.'_styles` WHERE `'.pfw.'_styles`.`path` = '.$path.' LIMIT 1;'; 
  $db->query($sql);
  return true;
  }

}

?>