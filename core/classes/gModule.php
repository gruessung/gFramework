<?php
error_reporting(0);
  class module extends gFramework {
    function search() {
      $sql = new db();
      $sql->query("SELECT * FROM ".prafix."_modules WHERE `activate` = 'true'");
      while ($row = $sql->fetch()) {
        $inc = @include index."application/modules/".$row->filename;
        
          if ($inc==false) {   error_log("Fatal Error: Can't find Modul ".$row->name."\n\r", 3, "log/module.log"); $err=true; }

        
      }

    }
  }