<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <title><?=$sitename?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <?=$header?>

    <!-- Le styles -->
    <link href="styles/style.gvisions.bootstrap_blue/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <script>
      $('.dropdown-toggle').dropdown();
    </script>
    
    <link href="styles/style.gvisions.bootstrap_blue/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

  
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#"><img src="styles/style.gvisions.bootstrap_blue/img/logo.png" border="0" style="height:20px;" /></a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link">Username</a>
            </p>
            <!-- //TODO DROPDOWN -->
            
              <?php
                $user = new UserManagement();
                $nav = new Nav();
                $return = "";
                $return .= $nav->showHoricontal($menuid,"","");
                
                if ($user->ifLogin())
                {
                  $return .= $nav->showHoricontal(menuLoginUser,"","");
                }
                else
                {
                  $return .= $nav->showHoricontal(menuLogoutUser,"","");
                }
              ?>

          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">                                              
      <div class="row-fluid">
        <div class="span3">

            
            <div class="well" style="width:300px; padding: 8px 0;">
		      <!--<ul class="nav nav-list"> 
		      <li class="nav-header">Menu</li>        
		      <li><a href="index.php"><i class="icon-home"></i> Startseite</a></li>
          <li><a href="#"><i class="icon-th-list"></i> Plugins</a></li>
          <li><a href="#"><i class="icon-comment"></i> Comments</a></li>
		      <li class="active"><a href="#"><i class="icon-user"></i> Benutzer</a></li>
          <li class="divider"></li>
		      <li><a href="#"><i class="icon-comment"></i> Einstellungen</a></li>
		      <li><a href="#"><i class="icon-share"></i> Logout</a></li>
		</ul>-->
    
    
    

<ul class="nav nav-list">

</ul>
	</div>
            
    <!--/.well -->
        </div><!--/span-->
        
        <!-- Content Span -->
        <div class="span9">
