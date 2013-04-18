<?php
#date 30.12.2011
class TPL extends gFramework {


  public $menu = 0;
  public $files = array("header","pages","footer");
  public $style = style;
  public $content = "Hello World!";
  private $vars = array();
  private $template;

  function __set($var, $val) {
    $this->vars[$var] = $val;
  }

  function __get($var) {
    return $this->vars[$var];
  }
  
  /**
   * function setFiles
   *
   * setter für files[array] 
   * 
   * @param foo
   * @param bar
   */
   function setFiles($files = array())
   {
    $this->files = $files;
   }       
   
   //@return html
   function fetchTemplate($file)           
   {
      if (file_exists(root.'/'.$file)) {
        $this->template = file_get_contents(root.'/'.$file);
      } else {
        trigger_error('Die Templatedatei <b>'.root.'/'.$file . '.php</b> konnte nicht gefunden werden.',E_USER_NOTICE);
      }    
   }
   
   function getTemplate()
   {
    return $this->template;
   }            
   
   function replace($foo, $bar)
   {
    $this->template = preg_replace("%$foo%", $bar, $this->template);
   }
  
 /**
  * function show
  *
  * zeigt das template mit ersetzungen an  
  */ 
  function show() {
    extract($this->vars);
    $db = new db();
    for ($i=0;$i<=count($this->files)-1;$i++) {
    $db->query("SELECT * FROM ".pfw."_hooks ORDER BY id");
    while ($row=$db->fetch()) {
      $name=$row->name;
      $inhalt=$row->code;
      ${$name}=$inhalt;
    }
    if(empty($this->vars["sitename"])) { $sitename = "unknown"; }
    if(empty($this->vars["id"])) { $id = 0; }
    if (file_exists(root.'/styles/'.$this->style. "/".$this->files[$i].'.php')) {
      include root.'/styles/'.$this->style. "/".$this->files[$i] . '.php';
    } else {
      trigger_error('Die Templatedatei <b>'.root.'/styles/'.$this->style. "/".$this->files[$i] . '.php</b> konnte nicht gefunden werden.',E_USER_NOTICE);
    }
    }
    return true;
  }
  
}
?>

