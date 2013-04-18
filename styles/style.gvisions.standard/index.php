<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>gVisions - <?=$sitename?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- Diese Seite wird mit dem gVisions Moon!ight CMS betrieben. www.gvisions.de Loeschen Sie diesen Vermerk bitte nicht! -->
  <script type="text/javascript" src="templates/jscripts/wz_tooltip/wz_tooltip.js">/* Dieses Script muss im Body-Tag eingebunden werden */</script>
<div class="menubarl"><img src="hbgl.png" width="9" height="103" /></div>
<div class="menubar"><a href="/"><a href="/"><img src="logo.png" alt="logo" width="275" height="68" border="0" align="top" /></a>
<!-- BANNERFRAME -->
<div class="bannerframe">
<!--BEGINN Bannertausch by VIPbanner.de (Premium Bannertausch)-Code[1]-->

<SCRIPT LANGUAGE="JavaScript" SRC="http://www.vipbanner.de/cgi-bin/exchange.cgi?USER=gvisions&l=1&p=0">
</SCRIPT>
<!--ENDE Bannertausch by VIPbanner.de (Premium Bannertausch)-Code[1]-->

<br />Werbung</div>
<!-- BANNERFRAME -->
<ul class="submenu">
  <li><a class="menu" href="menu1.html" title="Visit Menu Item 1">Menu Item 1</a>
  <ul>
    <li><a class="submenuformat" href="menu4.html">Submenu 2</a></li>
  </ul></li>
  <li><a class="menu" href="menu2.html">Menu Item 2</a>
  <ul>
    <li><a class="submenuformat" href="menu3.html">Submenu1</a></li>
    <li><a class="submenuformat" href="menu4.html">Submenu - LONGFORMAT - 1</a></li>
  </ul></li>
  
        <?php
      $nav = new Nav();
      $nav->showHoricontal($id,"menu","submenuformat");
      ?>
</ul></div>
<div class="menubarr"><img src="hbgr.png" width="9" height="103" /></div>
<div class="position"><p class="position-text"><?=$sitename?></p></div>
<div class="content"><p>Hier ensteht irgendwann einmal Text...</p></div>
</body>
</html>