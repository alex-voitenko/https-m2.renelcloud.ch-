 <?php
session_start();
if(!isset($_SESSION["costumer"])){
  $_SESSION["costumer"]=array();
  $_SESSION["costumer"]["name"]=array();
  $_SESSION["costumer"]["bdd"]=array();
  $_SESSION["costumer"]["pass"]=array();
}
include("../config.php");
$bonjour="Bonjour ".ucfirst($_SESSION["costumer"]["name"][0]);


?>

<!DOCTYPE html>
<html>
  

<head>
    <meta charset="utf-8">
    <title>RenelCloud</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/dataTable.custom.css" rel="stylesheet" type="text/css" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/jquery.treetable.css" rel="stylesheet">
	<link href="../css/jquery.treetable.theme.default.css" rel="stylesheet">
    <link href='../assets/images/meta_icons/favicon.ico' rel='shortcut icon' type='image/x-icon'>
    <link href='../assets/images/meta_icons/apple-touch-icon.png' rel='apple-touch-icon-precomposed'>
    <link href='../assets/images/meta_icons/apple-touch-icon-57x57.png' rel='apple-touch-icon-precomposed' sizes='57x57'>
    <link href='../assets/images/meta_icons/apple-touch-icon-72x72.png' rel='apple-touch-icon-precomposed' sizes='72x72'>
    <link href='../assets/images/meta_icons/apple-touch-icon-114x114.png' rel='apple-touch-icon-precomposed' sizes='114x114'>
    <link href='../assets/images/meta_icons/apple-touch-icon-144x144.png' rel='apple-touch-icon-precomposed' sizes='144x144'>
    <link rel="stylesheet" href="../themes/renelco/core/css/styleYsa.css" media="screen">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/templatemo_misc.css">
    <link rel="stylesheet" href="../css/templatemo_style.css">
    <link rel="shortcut icon" href="../images/icon2.ico">
    <link rel="stylesheet" href="../themes/renelco/core/css/styleYsa.css" media="screen">
    <script src="../assets/javascripts/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="../js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAY5oOo1tORFveikHX3yLL9PSNnDYJesgc"></script>
  	 <link href="../assets/stylesheets/jquery/jquery_ui.css" media="all" rel="stylesheet" type="text/css" />

    <link href="../assets/stylesheets/plugins/datatables/bootstrap-datatable.css" media="all" rel="stylesheet" type="text/css" />
   	
    <!-- / END - page related stylesheets [optional] -->
    <!-- / bootstrap [required] -->
    <link href="../assets/stylesheets/bootstrap/bootstrap.css" media="all" rel="stylesheet" type="text/css" />
    <!-- / theme file [required] -->
    <link href="../assets/stylesheets/light-theme.css" media="all" id="color-settings-body-color" rel="stylesheet" type="text/css" />
    <!-- / coloring file [optional] (if you are going to use custom contrast color) -->
    <link href="../assets/stylesheets/theme-colors.css" media="all" rel="stylesheet" type="text/css" />
    <link href="../css/dataTable.custom.css" rel="stylesheet" type="text/css" />
    	<link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />

	<link href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.jqueryui.min.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 9]>
      <script src="assets/javascripts/ie/html5shiv.js" type="text/javascript"></script>
      <script src="assets/javascripts/ie/respond.min.js" type="text/javascript"></script>
    <![endif]-->
  </head>
  <body>

 <div class="site-main"  id="sTop">
            <div class="site-header">
               
                <div class="main-header clearfix" >
                   
                        <div id="menu-wrapper"   >
                            
                                <?php
                                       echo "<p style=\"z-index:3000;background:#747272;position:absolute;right:0;top:0;margin-right:6em;padding:0.2em 0.5em;font-family: 'Open Sans', Arial, sans-serif; color:white;font-size:0.9em;\">".$bonjour."&nbsp;|&nbsp; <a style=\"color:white;\" href=\"../index.php?logout=0\" title=\"Déconnection\">Déconnection</a></p>";
                                    ?>
                                <div class="navbar-header">
								      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
								        <span class="sr-only">Toggle navigation</span>
								        <span class="icon-bar"></span>
								        <span class="icon-bar"></span>
								        <span class="icon-bar"></span>
								      </button>
								      <a href="https://m2.renelcloud.ch/index1.php"><img src="../images/logo1.png"  /> </a>
								</div>
								    
	                                
							    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								      <ul class="nav navbar-nav navbar-right">
										<li><a href="../Accueil.php">Manager</a></li>
										<li><a href="../Rapports.php">Rapports</a></li>
										<li><a href="../Renelmaps.php">Renelmap</a></li>
										<li><a href="../Renelbox.php">Renelbox</a></li>
										<li><a href="../Renelfleet.php">RenelFleet</a></li>
										<li ><a href="../ServiceDesk.php">Service desk</a></li>
                                                              
                                    </ul>
                               </div>
                               
                     <!-- /#menu-wrapper -->                        
                    </div> <!-- /.container -->
                </div> <!-- /.main-header -->
            </div> <!-- /.site-header -->
        </div> <!-- /.site-main -->