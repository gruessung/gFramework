<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <title><?=sitetitle?> - <?=$sitename?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <?=$header?>
	<script src="<?=web_root?>/styles/bootstrap/js/jquery.js"></script>
	<script type="text/javascript" src="<?=web_root?>/styles/bootstrap/js/dropdown.js"></script>


    <!-- Le styles -->
    <link href="<?=web_root?>/styles/style.gvisions.bootstrap_blue/css/bootstrap.css" rel="stylesheet">
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
    
    <link href="<?=web_root?>/styles/style.gvisions.bootstrap_blue/css/bootstrap-responsive.css" rel="stylesheet">

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
          <a class="brand" href="#"><img src="<?=web_root?>/styles/style.gvisions.bootstrap_blue/img/logo.png" border="0" style="height:20px;" /></a>
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
			  
                //http://code.google.com/p/phpwcms/source/browse/branches/dev-2.0/include/js/?r=481
				
                $nav = new Nav();
                $return = "";
                $return .= $nav->showHoricontal("nav", "", "", $menuid);
                
                if ($user->ifLogin())
                {
                  $return .= $nav->showHoricontal("nav", "", "", menuLoginUser);
                }
                else
                {
                  $return .= $nav->showHoricontal("nav", "", "", menuLogoutUser);
                }
              ?>

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
