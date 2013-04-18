<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=sitetitle?> - <?=$sitename?></title>
<link href="styles/<?=style?>/style.css" rel="stylesheet" type="text/css" />
<?=$header?>
</head>

<body>
<script type="text/javascript" src="styles/javascripts/wz_tooltip/wz_tooltip.js">/* Dieses Script muss im Body-Tag eingebunden werden */</script>
<div class="menubarl"><img src="styles/<?=style?>/hbgl.png" width="9" height="103" /></div>
<div class="menubar"><a href="index.php"><img src="styles/<?=style?>/logo.png" alt="logo" width="275" height="68" border="0" align="top" /></a>
<ul class="submenu">
  
        <?php
      $nav = new Nav();
      $nav->showHoricontal($id,"menu","submenuformat");
      ?>
</ul></div>
<div class="menubarr"><img src="templates/glass/hbgr.png" width="9" height="103" /></div>
<div class="position"><p class="position-text"><?=$sitename?></p><p class="position-copyright">Design: &copy; 2009 <a href="http://www.bgreen.at/" target="_blank">bgreen</a> | <a href="http://gvisions.de">Moon!ight &copy; 2008-2009 gVisions</a></p></div>
