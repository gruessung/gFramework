<?php session_start(); 
if (!isset($_SESSION['login'])) { $_SESSION['login'] = false; }

?>
<script type="text/javascript" src="feedback.js"></script>
<style>



/*Credits: Dynamic Drive CSS Library */
/*URL: http://www.dynamicdrive.com/style/ */

.solidblockmenu{
margin: 0;
padding: 0;
float: left;
font: bold 13px Arial;
width: 100%;
overflow: hidden;
margin-bottom: 1em;
border: 1px solid #625e00;
border-width: 1px 0;
background: black url(images/blockdefault.gif) center center repeat-x;
}

.solidblockmenu li{
display: inline;
}

.solidblockmenu li a{
float: left;
color: white;
padding: 9px 11px;
text-decoration: none;
border-right: 1px solid white;
}

.solidblockmenu li a:visited{
color: white;
}

.solidblockmenu li a:hover, .solidblockmenu li .current{
color: white;
background: transparent url(images/blockactive.gif) center center repeat-x;
}

body {
overflow:auto;
}

div.header {
height: 70px;
width:100%;
background-image:url('images/header_bg.jpg');
background-repeat: repeat-x;
left: 0px;
top: 0px;
position:absolute;
}
div.toolbar {
position:absolute;
left:0px;
top: 106px;
width: 300px;
height:100%;
background-color:grey;
}
div.menu{
position:absolute;
width:100%;
left:0px;
top:70px;
height:60px;
border: white 1px solid;

}
div.content {
position:absolute;
/*left:310px; */
left: 70px;
top:130px;
height:100%;
width:100%;
font-family:Arial;


}
.cel {
  font-family:Arial;
  background-color:#008fc2;  
  height: 20px;
  width:50%;
  border-bottom: 1px black solid;
}
 .runde-ecken

{

border:1px solid #aaaaaa;

left:200px;top:50px;



height:100px;

}

</style>

<div class = "header">
  <p style="left: 30px; top: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/logo.png" alt="gVisions Logo"  /></p>
</div> 
<div class = "menu">
<ul class="solidblockmenu">
<li><a href="index.php">Start</a></li>
<li><a href="index.php?action=installieren">Installieren</a></li>
<li><a href="index.php?action=list">Erweiterungen und Styles</a></li>
<?php
require_once("../init.php");
$plugin = new plugin();
if ($plugin->isRegist("com.gvisions.moonlight") == true)
{
    echo '<li><a href="index.php?action=verwalten&comid=com.gvisions.moonlight">Seitenverwaltung</a></li>';
}   
?>
<li><a href="index.php?action=verwalten&appid=1">Systemverwaltung</a></li>
<li><a target="_blank" href="kcfinder/browse.php?type=images&CKEditor=text&CKEditorFuncNum=2&langCode=de">Filemanager</a></li>
<li><a href="index.php?action=logout">Logout</a></li>
<?php

  if (site_online == "false") {
     echo '<li><a href="index.php?action=verwalten&appid=1&ac=offlineMode" class="current">Die Website ist aktuell offline.</a></li>';
  }
?>
</ul>
<br style="clear: left" />

<p class="iepara"></p>



</div>          
<div class="content">
  <?php

  
  
  /* Hier werden die gCP Seiten den Rechten zugeordnet */
  $rechte = array("checkUpdates" => "install",
                  "download" => "install",
                  "installieren" => "install",
                  "unistall" => "install",
                  "installUpdates" => "install",
                  "install_upload" => "install",
                  "list" => "acp",
                  "login" => "none",
                  "main" => "acp",
                  "nopermission" => "none",
                  "verwalten" => "system",
                  "activate" => "system",
                  "logout" => "acp",
                  "filemanager" => "system");
  
  $user = new UserManagement();
  if (!$user->ifLogin()) {
    error_log("try to login\n", 3, root."/corecp.log");
    require_once("action/login.php"); 
    die();
  }

  if (!isset($_GET['action'])){
    $action = "main";
  }
  else
  {
    $action = $_GET['action'];
  }
  @$flag = $rechte[$action];
  if ($user->isAllowed($_SESSION['userid'],$flag)==true && $user->isAllowed($_SESSION['userid'],"acp")==true) {
    error_log($user->getUserName($_SESSION['userid'])." - $action\n", 3, root."/corecp.log");
    require_once("action/".$action.".php");
  }
  else
  {
    error_log($user->getUserName($_SESSION['userid'])." - NO PERMISSION! - $action\n", 3, root."/corecp.log");
    require_once("action/nopermission.php"); 
  }
  ?>


</div>


