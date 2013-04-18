<?php

class gConfig extends gFramework {

  function update($name,$value) {
    $db = new db();
    $db->query("UPDATE  `".db."`.`".pfw."_config` SET  `value` =  '$value' WHERE  `".pfw."_config`.`name` =  '$name' LIMIT 1 ;");
    return true;
  }

}