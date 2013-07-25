<!DOCTYPE html>
<?php
require_once("../init.php");
?>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <title><?=sitetitle?> - gCP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <?=$header?>
	<script src="../../styles/bootstrap/js/jquery.js"></script>
	<script type="text/javascript" src="../../styles/bootstrap/js/dropdown.js"></script>


    <!-- Le styles -->
    <link href="../../styles/style.gvisions.bootstrap_blue/css/bootstrap.css" rel="stylesheet">
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
    
    <link href="../../styles/style.gvisions.bootstrap_blue/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

  
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#"><img src="../../styles/style.gvisions.bootstrap_blue/img/logo.png" border="0" style="height:20px;" /></a>
          <div class="nav-collapse collapse">
		  <?php
			$user = new UserManagement();
			if ($user->ifLogin())
			{
		  ?>
            <p class="navbar-text pull-right">
              Hallo <a href="#" class="navbar-link"><?=$user->getUsername()?></a>!
            </p>   			
              <?php
			  }
			  ?>
			<ul class="nav">
				<li><a href="index.php">Start</a></li>
				<li><a href="index.php?action=installieren">Installieren</a></li>
				<li><a href="index.php?action=list">Erweiterungen und Styles</a></li>
				<?php
				$plugin = new plugin();
				if ($plugin->isRegist("com.gvisions.moonlight") == true)
				{
					echo '<li><a href="index.php?action=verwalten&comid=com.gvisions.moonlight">Seiten</a></li>';
				}  
				if ($plugin->isRegist("com.gvisions.news") == true)
				{
					echo '<li><a href="index.php?action=verwalten&comid=com.gvisions.news">News</a></li>';
				}  				
				?>
				
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Systemverwaltung<b class="caret"></b></a>

						<ul class="dropdown-menu" role="menu" aria-labelledby="drop">
							<li role="presentation"><a role="menuitem" tabindex="-1" href="index.php?action=verwalten&appid=1&ac=settings"><i class="icon-wrench"></i>Einstellungen</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="index.php?action=verwalten&appid=1&ac=user"><i class="icon-user"></i>Benutzer</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="index.php?action=verwalten&appid=1&ac=groups"><i class="icon-th-large"></i>Gruppen</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="index.php?action=verwalten&appid=1&ac=menus"><i class="icon-th-list"></i>Menus</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="index.php?action=verwalten&appid=1&ac=offlineMode"><i class="icon-wrench"></i>Wartungsmodus</a></li>
						</ul>
				</li>				

				<li><a target="_blank" href="kcfinder/browse.php?type=images&CKEditor=text&CKEditorFuncNum=2&langCode=de">Filemanager</a></li>
				<li><a href="index.php?action=logout">Logout</a></li>
			</ul>


          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">                                              
      <div class="row-fluid">
	  <?php //Schauen ob der aktuellen Seite eine Sidebar zugeordnet ist, diese dann in span3 anzeigen, sonst span1 ?>
	  <div class="span1">
				<!-- Platz für Sidebar mit 100px -->
	  </div>

        
        <!-- Content Span -->
        <div class="span9">
				<?php

				  if (site_online == "false") {
					 echo '<center><div class="alert alert-warning">Bitte beachte!<br>Deine Website ist gerade offline.</center>';
				  }

  
  
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
		</div></div>
      <!-- Content end -->
      <hr>

      <footer>
        <p>&copy; gVisions 2013</p>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../../styles/style.gvisions.bootstrap_blue/js/jquery.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-transition.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-alert.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-modal.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-dropdown.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-scrollspy.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-tab.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-tooltip.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-popover.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-button.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-collapse.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-carousel.js"></script>
    <script src="../../styles/style.gvisions.bootstrap_blue/js/bootstrap-typeahead.js"></script>

  </body>
</html>
