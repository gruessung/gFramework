<?php
/*
gHooks.php
(c) 2009 Alexander Gruessung
Diese Datei ist Part des gFrameworks!
*/
class gHooks extends gFramework {

  /*
  function search
  none var
  */
  function search(){ return true;
  # $sql = mysql_query("SELECT * FROM ".prafix."_hooks ORDER BY id") or die(mysql_error());
   while ($row=mysql_fetch_object($sql)) {
       $name=$row->name;
       $inhalt=$row->code;
       $h->$name=$inhalt;
   }
  
  }
  
  /*
  function new
  var str name req
  var str core req
  */
  function newHook($name,$code) {
     $db = new db();
     #$db->insert("hooks","")
  }
  
  function get($name) {
    $db = new db();
    $db->query("SELECT * FROM ".pfw."_hooks WHERE `name` = '".$name."';");
    $row = $db->fetch();
    if (empty($row->code)) {
      return "Hook $name not found.";
    }
    return $row->code;
  }

}