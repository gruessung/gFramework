<html>
  <head>
  <link rel="stylesheet" type="text/css" href="styles/style.gvisions.gvisions/jqueryslidemenu.css" />

<!--[if lte IE 7]>
<style type="text/css">
html .jqueryslidemenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<script type="text/javascript" src="styles/style.gvisions.gvisions/jqueryslidemenu.js"></script>

    <style>
    body {
      background-color:#F2F2F2;
      font-family: Arial, Verdana;
    }
    
    div.header {
      width: 1100px;
      margin-left:10%;
      height: 100px;
      background-image:url('styles/style.gvisions.gvisions/images/header_bg.jpg');
      border: 1px solid black;
    }
    
    div.rotator {
      width:50%;
      background-color:white;
      height: 100%;
    }
    
    div.menu {
      width:1100px;
      background-color:white;
      margin-left: 10%;
      position: absolute;
      height:auto;
      border: 1px solid black;
      border-top:none;
      background: #414141;
    }
    
    div.content  {
      width: 1100px;
      margin-left: 10%;
      height: 800px;
      background-color:white;
      border: 1px solid black;
      border-top: none;
      overflow:auto; 
    }
    
    div.footer {
      width: 1100px;
      margin-left: 10%;
      height: 50px;
      background-color:white; 
      border: 1px solid black;
      border-top: none;
    }
    
    
/* Banner */
.bannerframe {
	position:absolute;
	top:10px;
	margin-left: 700px;
	font-size:9px;
}
    
    </style>
  </head>
  
  
  <body>
    <div class="header">
           <br>
           <img src="styles/style.gvisions.gvisions/images/logo.png" border="0" />
    </div>

      <div class="menu">
      <div id="myslidemenu" class="jqueryslidemenu">
      <ul>
        
                <?php
      $nav = new Nav();
      $nav->showHoricontal($id,"","");
      ?>
      </ul>
      </div>
      </div> 
 