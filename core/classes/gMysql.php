<?php
  
  /*
    Class Mysql
    By gVisions (c) 2009
    gMysql
    www.gvisions.de
    This file is a part of the gFramework
  */
  
  class db extends gFramework implements IgDatabase {
    
    var $query;
    private static $instance = null;

      public function __clone() {}


      /**
       * Gibt die Instanz des Datenbankobjektes zurück
       * In Zukunft nurnoch getInstance() verwenden!
       *
       * @return db|null
       */
      public static function getInstance()
      {
          if (null === self::$instance)
          {
              self::$instance = new self;
          }
          return self::$instance;
      }

      /**
       * @param $table string
       * @param $cols array of cols
       * @param $values array with values, array in array for rows!
       */
      public function insertNew($table,/* array */ $cols, /* array */$values)
      {
          //Cols zusammensetzen
          $sCols = "";
          for ($i = 0; $i < count($cols); $i++)
          {
              $sCols .= "`$cols[$i]`";
              if ($i != count($cols) -1 )
              {
                  $sCols .= ",";
              }
          }

          //VALUES setzen
          $sValues = "";
          for ($i = 0; $i < count($values); $i++)
          {
              $e = $values[$i];
              $sValues .= "(";
              for ($a = 0; $a < count($e); $a++)
              {
                  $sValues .= "'$e[$a]'";
                  if ($a != count($e) -1 )
                  {
                      $sValues .= ",";
                  }
              }
              $sValues .= ")";
              if ($i != count($values) -1 )
              {
                  $sValues .= ",";
              }
          }


          $sql = "INSERT INTO `".db."`.`".pfw."_".$table."` ($sCols) VALUES $sValues;";

          die($sql);
      }



      /**
       * @see IgDatabase/connect
       */
      function connect($h,$u,$p,$d) {
        try
        {
            $con = @mysql_connect($h,$u,$p);
            $dbs =  @mysql_select_db($d);
            if (!$con || !$dbs) {
                throw new gError_Database(mysql_error());
            }
        }
        catch (gError_Database $e)
        {
            echo $e->getMessage();
            die();
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
      
    function insert($table,$colls,$values,$prafix=pfw){
     $sql = "INSERT INTO `".db."`.`".$prafix."_".$table."` ($colls) VALUES ($values);";
     $d = new db();
     $d->query($sql);
    }



      
         
 }