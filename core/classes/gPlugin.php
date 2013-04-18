

<?php

/**
 * plugin class
 * 
 * @extends gFramework
 * 
 */
class plugin extends gFramework { 
  public  $pluginName = '';
  public  $pluginClass = '';
  public  $sql = '';
  public  $content = '';
  public  $comid = '';
  function __construct($pluginName = false) {
    if(!$pluginName) return false; 
    $this->pluginName = $pluginName;  
    if ($this->isRegist()==false OR $this->isActive()==false) {
      $this->pluginName = 'PluginNotFound';
    }
    require_once('application/plugins/'.$this->pluginName.'/'.$this->pluginName.'.php');
    $this->pluginClass = new $this->pluginName();       
  }

  /*
  * public function getContent
  * @name getContent
  * @version 1.0
  * @author Alexander Gruessung
  * @description get content of plugin
  * @parameters pluginname      
  */    
  public function getContent() {
    $plugin = new $this->pluginName();
    $this->content = $plugin->run();
    return $this->content;  
 
  }
  
  /*
  * public function getTitel
  * @name getTitel
  * @version 1.0
  * @author Alexander Gruessung
  * @description Return titel of plugin
  * @parameters      
  */ 
  public function getTitel() {
    return $this->pluginClass->getTitel();
  }
  
  /*
  * public function isRegist
  * @name getRegist
  * @version 1.0
  * @author Alexander Gruessung
  * @description Return if Plugin already regist
  * @parameters      
  */ 
  public function isRegist($comid=false) {
  if($comid) { $plugin = $comid; } else { $plugin = $this->comid; }

  $sql = new db();
  $sql->query("SELECT `id` FROM `".pfw.'_'.plugins."` WHERE `com_id` = '".$plugin."'");
  $num = $sql->num_rows();

    if ($num!=0 || $num!="" || $num!="0") {
     return true;
    } else {
     return false;
    }
  }
  
  /*
  * public function getRegist
  * @name getRegist
  * @version 1.0
  * @author Alexander Gruessung
  * @parameters    
  * @description Return true if plugin active, false if not  
  */ 
  public function isActive() {
  $sql = new db();
  $plugin = mysql_real_escape_string($this->pluginName);
  $sql->query("SELECT * FROM `".pfw.'_'.plugins."` WHERE `com_id` = '".$plugin."' AND `activate` = 'true'");
  $row = $sql->fetch();
  $num = $sql->num_rows();
    if ($num=="" OR $row->activate=="false") {
     return false;
    } else {
      return true;
    }
  }

  public function Update($spalte,$neuerWert,$comid) {
    $sql = new db();
    $sql->query("UPDATE  `".datenbank."`.`".pfw.'_'.plugins."` SET  `$spalte` =  '$neuerWert' WHERE  `".pfw.'_'.plugins."`.`com_id` ='$comid';");
    return true;
  }

  public function getVersion($comid=false) {
  if($comid!=false) { $plugin = $comid; } else { $plugin = $this->comid; }
  $sql = new db();
  $sql->query("SELECT `version` FROM `".pfw.'_'.plugins."` WHERE `com_id` = '".$plugin."'");  
  $version = $sql->fetch();

  return $version->version;
  }


  
  /*
   * public function registNew
   * @var str name
   * @var str filename
   * @var str activate
   * @name registNew
   * @version 0.1
   * @author Alexander Gruessung
   * @desdcription Regist a new plugin into the database. do not copy the files!
   */
   
   public function Registration($name,$desc,$comid,$path,$version,$server,$pluginActive="true") {
    if (!$this->isRegist($comid)) {
      $sql = "INSERT INTO `".datenbank."`.`".pfw.'_'.plugins."`(`id`,`name`,`com_id`,`desc`,`activate`,`path`,`version`,`updateServer`) VALUE (NULL,'$name','$comid','$desc','$pluginActive','$path','$version','$server');";
      $db = new db();
      $db->query($sql);
      return true;
    }
    return false;
   }                 

   
  public function returnFunction($func,$par=false) {
  if ($par==false) {
    return $this->pluginClass->$func();
  }
    else
  {
    return $this->pluginClass->$func($par);
  }
  }                
  
  public function getID($comID)
    {
      $db = new db();
      $db->query("SELECT * FROM ".pfw."_plugins WHERE `com_id` = '$comID';");
      $row = $db->fetch();
      return $row->id;
    }
  

  
    function delete($plugin) {
    $sql = 'DELETE FROM `'.pfw.'_'.plugins.'` WHERE `'.pfw.'_'.plugins.'`.`com_id` = '.$plugin.' LIMIT 1;'; 
    $d = new db();
    $d->query($sql);
    return true;
  }
  

}
