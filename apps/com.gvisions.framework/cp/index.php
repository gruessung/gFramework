

<u>Menu:</u>     
<a href="index.php?action=verwalten&appid=1&ac=user">Benutzer</a> &bull;
<a href="index.php?action=verwalten&appid=1&ac=groups">Gruppen</a> &bull;
<a href="index.php?action=verwalten&appid=1&ac=menus">Menus</a> &bull;
<a href="index.php?action=verwalten&appid=1&ac=offlineMode">On/Offline</a>
  <br>  <br>
<div class="gframework-c" style="left: 150px;width: 90%;">
<?php
$ac = "";
if (isset($_GET['ac'])) {
  $ac = $_GET['ac'];
}


switch ($ac) {

  default:
    echo("Willkommen im gCP Teil des gFrameworks");
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


}
?>

</div>