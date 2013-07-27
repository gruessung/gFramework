

<div class="gframework-c" style="left: 150px;width: 90%;">
<?php
$ac = "";
if (isset($_GET['ac'])) {
  $ac = $_GET['ac'];
}


switch ($ac) {

  default:
    echo("Seite nicht gefunden.");
  break;
  
  case "editStyle":
    require_once("ac/editStyle.php");                                                                                        
  break;
  
  case "offlineMode":
    require_once("ac/offlineMode.php");
  break;
  
  case "user":
    require_once("ac/user.php");
  break;
  
  case "groups":
    require_once("ac/groups.php");
  break;

  case "menus":
    require_once("ac/menus.php");
  break;
  
  case "settings":
	require_once("ac/settings.php");
  break;


}
?>

</div>