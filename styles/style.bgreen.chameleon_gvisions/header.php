
      
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$sitename?></title>
<link href="styles/style.bgreen.chameleon_gvisions/style.css" rel="stylesheet" type="text/css" />
<?=$header?>
<!--- Chameleon 1.0dev2; Copyright 2009-2012 bgreen Designs, Copyright 2012 bgreen Foundation --->
<!--- Content Copyright 2006-2008 Grüßung Software, Copyright 2008-2012 gVisions --->
</head>

<body>
<div class="header">
  <div class="header-logo"><a href="/"><img src="styles/style.bgreen.chameleon_gvisions/logo.png" alt="logo" width="242" height="70" border="0" align="top" /></a></div>
  <div class="header-banner"><?=$banner?>Werbung</div>
</div>

<ul class="menu">
  <?php
    $user = new UserManagement();
    $nav = new Nav();
    $nav->showHoricontal($menuid,"","");
    
    if ($user->ifLogin())
    {
      $nav->showHoricontal(menuLoginUser,"","");
    }
    else
    {
      $nav->showHoricontal(menuLogoutUser,"","");
    }
  ?>
</ul>