<?php
  
  /*
    Class Mysql
    By gVisions (c) 2009
    gMysql
    www.gvisions.de
    This file is a part of the gFramework
  */
  
  class db extends gFramework {
    
    var $query;
    
    function connect($h,$u,$p,$d) {
      $con = @mysql_connect($h,$u,$p);
     $dbs =  @mysql_select_db($d);
      if (!$con) {
        trigger_error(mysql_error(),E_USER_ERROR);
      }
     
      if (!$dbs) {
        trigger_error(mysql_error(),E_USER_ERROR);
      }  
     }    
    
    function query($query) {
      $g = mysql_query($query);
      if (!$g) {
          trigger_error($query . " => ".mysql_error(),E_USER_ERROR);
          return false;
       }
      $this->query = $g;
      return $g;
      }
      
    
    
    function fetch($q=0) {
      if ($q==0) { $q = $this->query; }
      $row = mysql_fetch_object($q);  
      return $row;
      }
      
      function num_rows($q=0){
        if ($q==0) { $q = $this->query; }
        $row = mysql_num_rows($q);
        return $row;
      }
      
    function insert($table,$collums,$values,$prafix=pfw){
     $sql = "INSERT INTO `".db."`.`".$prafix."_".$table."` ($collums) VALUES ($values);";
     $d = new db();
     $d->query($sql);
    }
      
         
 }