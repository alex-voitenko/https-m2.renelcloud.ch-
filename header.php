 <?php

 session_start(); 
 if(!isset($_SESSION["costumer"])){
  $_SESSION["costumer"]=array();
  $_SESSION["costumer"]["name"]=array();
  $_SESSION["costumer"]["bdd"]=array();
  $_SESSION["costumer"]["pass"]=array();
}
 include("config.php");
 $bonjour="Bonjour ".ucfirst($_SESSION["costumer"]["name"][0]);

 ?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Renelcloud</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/font-awesome.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/templatemo_misc.css">
<link rel="stylesheet" href="css/templatemo_style.css">
<link rel="shortcut icon" href="images/icon2.ico">
<link rel="stylesheet" href="themes/renelco/core/css/styleYsa.css" media="screen">
<script src="js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>

</head>
<body>

<!--[if lt IE 7]>
<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
<![endif]-->

 <div class="site-main"  id="sTop">
            <div class="site-header">
               
                <div class="main-header">
                   
                        <div id="menu-wrapper">
               
                               <?php
                                   echo "<p style=\"z-index:3000;background:#747272;position:absolute;right:0;top:0;margin-right:6em;padding:0.2em 0.5em;font-family: 'Open Sans', Arial, sans-serif; color:white;font-size:0.9em;\">".$bonjour."&nbsp;|&nbsp; <a style=\"color:white;\" href=\"../index.php?logout=0\" title=\"Déconnexion\">Déconnexion</a></p>";
                                ?>
                                <div class="navbar-header">
								      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
								        <span class="sr-only">Toggle navigation</span>
								        <span class="icon-bar"></span>
								        <span class="icon-bar"></span>
								        <span class="icon-bar"></span>
								      </button>
								      <a href="https://m2.renelcloud.ch/index1.php"><img src="images/logo1.png"  /> </a>
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