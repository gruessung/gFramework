 <?php
  error_reporting(E_ALL);
  class page extends gFramework {
  function init() {
  
    if (isset($_GET['pageid']) AND is_numeric($_GET['pageid'])) {
      $pid = $_GET['pageid'];
    }
    else
    {
      $pid = "1";
    }
    if (is_numeric($pid)==false) {
    trigger_error("Falscher Parametertyp!",E_USER_ERROR);
    }
    return $pid;
    echo "<!--PAGEID: ".$pid."-->";
    
   
  }
  

  function sql($pageid,$a) {
    $sql=new db();
    $sql->query('SELECT * FROM '.pfw.'_gmoonpages WHERE id = '.$pageid);
      $row = $sql->fetch();
      if (!$row) { return false; }
      $pages[$a] = $row->$a;
      return $pages[$a];

  }       
  function showAllPages() {
  $dbc = new db();
  $dbc->query("SELECT * FROM ".pfw."_gmoonpages ORDER BY ID ASC");
  echo '<option value="">.: Seiten :.</option>';
  while ($row = $dbc->fetch()) {
    echo '<option value="pageid='.$row->id.'">'.$row->titel.' (ID: '.$row->id.')</option>';
  }
  }
  
  function newPage($titel,$content,$menu,$save){
    $db = new db();
    if (!is_numeric($menu)) { trigger_error("Parametertyp <menu> falsch.",E_USER_ERROR);}
    $db->query("INSERT INTO `".db."`.`".pfw."_gmoonpages` (`id`, `titel`, `delete`, `text`, `menu`) VALUES (NULL, \'$titel\', \'$save\', \'$content\', \'$menu\');");
  }     
  
  
  
  
  }     