<?php
error_reporting(E_ALL);
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
		$text = $this->vars["text"];
		$db->query("SELECT * FROM ".pfw."_hooks ORDER BY id");
		
		
		while ($row=$db->fetch()) 
		{
		  if ($row->regex==1)
		  {
			$code = $row->code;
			$pattern = $row->pattern;
			if ($c=preg_match_all ($pattern, $text, $matches))
			{
				$text = preg_replace($pattern, $code, $text);
			}
		  }
		  else
		  {
			  $name=$row->name;
			  $inhalt=$row->code;
			  ${$name}=$inhalt;
		  }

		}
			/** ALT!
		  if(preg_match('/\[plugin\](.*?)\[\/plugin\]/', $text)) {
			preg_match_all('/\[plugin\](.*?)\[\/plugin\]/', $text,$plugins);

			$plugins = $plugins[1];

			$i = 0;
			do {
			  require_once (core."/classes/gPlugin.php");
			  $plugin = new plugin($plugins[$i], true);
			  $content = $plugin->getContent();
			  $text = preg_replace("/\[plugin\]$plugins[$i]\[\/plugin\]/", $content, $text); 
			   $i++; 
			} while($i < count($plugins)); 
		  }*/ 
		 
		/* if ($this->files[$i] == "pages")
		 {
			
			 $text = $this->vars["text"];
			
			 $re1='(\\[hero\\])';	# Square Braces 1
			 $re2='(.+?)';	# Non-greedy match on filler
			 $re3='(\\[\\/hero\\])';	# Square Braces 2
			 if ($c=preg_match_all ("/".$re1.$re2.$re3."/is", $text, $matches))
			 {
				 $sbraces1=$matches[1][0];
				 $sbraces2=$matches[2][0];
				 $sbraces3=$matches[3][0];

				 $text = preg_replace("/(\\[hero\\])(.+?)(\\[\\/hero\\])/is", "<div class=\"hero-unit\">$2</div>", $text);
				 //$text = preg_replace("/$re3/is", "</b>", $text);
			 }
			
		 }*/
		
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

