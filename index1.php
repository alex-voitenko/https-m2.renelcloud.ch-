<?php 
 session_start(); 
 if(!isset($_SESSION["costumer"])){
  $_SESSION["costumer"]=array();
  $_SESSION["costumer"]["name"]=array();
  $_SESSION["costumer"]["bdd"]=array();
  $_SESSION["costumer"]["pass"]=array();
}


if(isset($_POST["submit"])){

        $society=htmlentities($_POST["society"]);
        $user=htmlentities($_POST["user"]);
        $mdp=htmlentities($_POST["password"]);
 

    if($user=="Franco" && $society=="Renelco" && $mdp=="franco#42"){
        $message="Bonjour ".$user;
        $database="RENELCO_BMA_DEV";
        $user_name  = "franco";
        $password   = "Fr4nc0_R3nE1c0";
        array_push($_SESSION["costumer"]["name"],$user_name);
        array_push($_SESSION["costumer"]["bdd"],$database);
        array_push($_SESSION["costumer"]["pass"],$password);
        include("config.php");
    }
    elseif($user=="James" && $society=="Renelco" && $mdp=="james#42"){
        $message="Bonjour ".$user;
         $database="RENELCO_BMA_DEV";
        $user_name  = "james";
        $password   = "james#42";
        array_push($_SESSION["costumer"]["name"],$user_name);
        array_push($_SESSION["costumer"]["bdd"],$database);
        array_push($_SESSION["costumer"]["pass"],$password);
        include("config.php");
    }
    elseif($user=="Lalaina" && $society=="Renelco" && $mdp=="lalaina#42"){
        $message="Bonjour ".$user;
         $database="RENELCO_BMA_DEV";
        $user_name  = "lalaina";
        $password   = "MA*ra8+Stuph";
        array_push($_SESSION["costumer"]["name"],$user_name);
        array_push($_SESSION["costumer"]["bdd"],$database);
        array_push($_SESSION["costumer"]["pass"],$password);
        include("config.php");
    }
    elseif($user=="alex" && $society=="Renelco" && $mdp=="cHet48ahAn*="){
        $message="Bonjour ".$user;
         $database="RENELCO_BMA_DEV";
        $user_name  = "alex";
        $password   = "cHet48ahAn*=";
        array_push($_SESSION["costumer"]["name"],$user_name);
        array_push($_SESSION["costumer"]["bdd"],$database);
        array_push($_SESSION["costumer"]["pass"],$password);
        include("config.php");
    }
    elseif($user=="marmillod" && $society=="Marmillod" && $mdp=="DInK40K7orF8JVR"){
        $database="RENELCO_BMA_MARMILLOD";
        $user_name  = "marmillod";
        $password   = "DInK40K7orF8JVR";
        array_push($_SESSION["costumer"]["name"],$user_name);
        array_push($_SESSION["costumer"]["bdd"],$database);
        array_push($_SESSION["costumer"]["pass"],$password);

        $message="Bonjour ".$user;
        include("config.php");
    }
    elseif($user=="milliquet" && $society=="Milliquet" && $mdp=="UAOurImrEnFOfW0"){
        $database="RENELCO_BMA_MILLIQUET";
        $user_name  = "milliquet";
        $password   = "UAOurImrEnFOfW0";
        array_push($_SESSION["costumer"]["name"],$user_name);
        array_push($_SESSION["costumer"]["bdd"],$database);
        array_push($_SESSION["costumer"]["pass"],$password);

        $message="Bonjour ".$user;
        include("config.php");
    }
	elseif($user=="vonauw" && $society=="VonAuw" && $mdp=="RfXR2P2IUNEuQyh"){
        $database="RENELCO_BMA_VONAUW";
        $user_name  = "vonauw";
        $password   = "RfXR2P2IUNEuQyh";
        array_push($_SESSION["costumer"]["name"],$user_name);
        array_push($_SESSION["costumer"]["bdd"],$database);
        array_push($_SESSION["costumer"]["pass"],$password);

        $message="Bonjour ".$user;
        include("config.php");
	}
    elseif($user=="gvalimo" && $society=="GVALimo" && $mdp=="cZ5qVLgcrZ33Bgy"){
        $database="RENELCO_BMA_GVALIMO";
        $user_name  = "gvalimo";
        $password   = "cZ5qVLgcrZ33Bgy";
        array_push($_SESSION["costumer"]["name"],$user_name);
        array_push($_SESSION["costumer"]["bdd"],$database);
        array_push($_SESSION["costumer"]["pass"],$password);

        $message="Bonjour ".$user;
        include("config.php");
    }
    else{
        header("location:index.php?connex=0");
        exit();
    }
}else{
        $message="Bonjour ".ucfirst($_SESSION["costumer"]["name"][0]); 
    }



// header("location:index.php?err=0");
       // exit();

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
                                   echo "<p class='welcome-message' >".$message."&nbsp;|&nbsp; <a style=\"color:white;\" href=\"../index.php?logout=0\" title=\"Deconnexion\">Deconnexion</a></p>";
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
                                
                    </div> <!-- /.menu-wrapper -->
                </div> <!-- /.main-header -->
            </div> <!-- /.site-header -->
   <hr class="style_one"/>
        <div class="content-section" id="portfolio" style=" padding-top: 40px;">

            <div class="container" >
                <div class="row" id="menu" >
				
                    <div class="portfolio-item-first col-md-3 col-sm-6 col-xs-6" >
                        <div class="portfolio-thumb">
                           <a href="Accueil.php"  ><img src="images/manager_small.png"  frameborder="0"  alt=""></a>
                           
                        </div> <!-- /.portfolio-thumb -->
                    </div> <!-- /.portfolio-item -->
                    
                    <div class="portfolio-item-first col-md-3 col-sm-6 col-xs-6 ">
                        <div class="portfolio-thumb">
                             <a href="Rapports.php"  ><img src="images/rapports_small.png" alt="">
                       </div> <!-- /.portfolio-thumb -->
                    </div> <!-- /.portfolio-item -->
                    
                    
                    <div class="portfolio-item-first col-md-3 col-sm-6 col-xs-6">
                        <div class="portfolio-thumb">
                           <a href="Renelmaps.php"  >  <img src="images/renelmaps_small.png" alt="">
                       </div> <!-- /.portfolio-thumb -->
                    </div> <!-- /.portfolio-item -->
                    
                    
                    <div class="portfolio-item-first col-md-3 col-sm-6 col-xs-6 right">
                        <div class="portfolio-thumb ">
                           <a href="Renelbox.php"  >  <img src="images/renelbox_small.png" alt="">
                        </div> <!-- /.portfolio-thumb -->
                    </div> <!-- /.portfolio-item -->
                    
                     
                    <div class="portfolio-item-first col-md-3 col-sm-6 col-xs-6">
                        <div class="portfolio-thumb">
                            <a href="Renelfleet.php"  > <img src="images/renelfleet_small.png" alt="">
                        </div> <!-- /.portfolio-thumb -->
                    </div> <!-- /.portfolio-item -->
                    
                    <div class="portfolio-item-first col-md-3 col-sm-6 col-xs-6 ">
                        <div class="portfolio-thumb ">
                            <a href="ServiceDesk.php"  > <img src="images/servicedesk_small.png" alt="">
                       </div> <!-- /.portfolio-thumb -->
                    </div> <!-- /.portfolio-item -->
                    
                    
                    <div class="portfolio-item-first col-md-3 col-sm-6 col-xs-6 ">
                        <div class="portfolio-thumb">
                             <a href="SyncData.php"  ><img src="images/syncdata_small.png" alt="">
                           
                        </div> <!-- /.portfolio-thumb -->
                    </div> <!-- /.portfolio-item -->
                    
       
                    
                    <div class="portfolio-item-first col-md-3 col-sm-6 col-xs-6">
                        <div class="portfolio-thumb ">
                            <a href="ExtractToBI.php"  > <img src="images/extractBI_small.png" alt="">
                           
                        </div> <!-- /.portfolio-thumb -->
                    </div> <!-- /.portfolio-item -->
					
						
   </div> <!-- /.row -->

            </div> <!-- /.container -->
        </div> <!-- /#portfolio -->	 
        
        <script src="js/vendor/jquery-1.11.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="js/bootstrap.js"></script>
        <script src="js/plugins.js"></script>
      

        <!-- templatemo 406 flex -->
		 
   <script type="text/javascript">
       
$('iframe').css({
     'width': $(window).width(),
     'height': $(window).height()
});
 
$(window).resize(function(){
$('iframe').css({
     'width': $(window).width(),
     'height': $(window).height()
});
});
</script>
</body>
</html>