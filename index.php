 <?php 
session_start();
if(!isset($_SESSION["costumer"])){
  $_SESSION["costumer"]=array();
  $_SESSION["costumer"]["name"]=array();
  $_SESSION["costumer"]["bdd"]=array();
  $_SESSION["costumer"]["pass"]=array();
}
?>
<!DOCTYPE html>
<!--[if lte IE 8]><html class="ng-csp ie ie8 lte9 lte8" data-placeholder-focus="false" lang="en" ><![endif]-->
<!--[if IE 9]><html class="ng-csp ie ie9 lte9" data-placeholder-focus="false" lang="en" ><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="ng-csp" data-placeholder-focus="false" lang="en" ><!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<title>
		Renelcloud		</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="referrer" content="never">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-itunes-app" content="app-id=543672169">
		<meta name="theme-color" content="#f1642f">
		<link rel="shortcut icon" type="image/png" href="themes/renelco/core/img/favicon.png">
		<link rel="apple-touch-icon-precomposed" href="themes/renelco/core/img/favicon-touch.png">
					<link rel="stylesheet" href="core/css/Wcc03341e06d23.css" media="screen">
					<link rel="stylesheet" href="core/css/Wcfdb7e7f33403.css" media="screen">
					<link rel="stylesheet" href="core/css/Wc7a7b3a984c02.css" media="screen">
					<link rel="stylesheet" href="core/css/Wc5b81eec3aa55.css" media="screen">
					<link rel="stylesheet" href="core/css/Wc68f6fdf7a165.css" media="screen">
					<link rel="stylesheet" href="core/css/Wcf6abb6d17e56.css" media="screen">
					<link rel="stylesheet" href="core/css/Wc73ea6549460f.css" media="screen">
					<link rel="stylesheet" href="core/css/Wc7336c232191c.css" media="screen">
					<link rel="stylesheet" href="core/vendor/jquery-ui/themes/base/Wc74a82d63806.css" media="screen">
					<link rel="stylesheet" href="core/css/Wc81b9bbae03e2.css" media="screen">
					<link rel="stylesheet" href="core/css/Wcd458cef8489.css" media="screen">
					<link rel="stylesheet" href="core/css/Wc7c60dacc9f98.css" media="screen">
					<link rel="stylesheet" href="apps/files_versions/css/Wc947f36c9cc94.css" media="screen">
					<link rel="stylesheet" href="apps/files_pdfviewer/css/Wc75d31d19a190.css" media="screen">
					<link rel="stylesheet" href="apps/files_videoviewer/css/Wc4e7699744e01.css" media="screen">
					<link rel="stylesheet" href="apps/files_videoviewer/css/Wc9aa45a8196c1.css" media="screen">
					<link rel="stylesheet" href="core/css/Wc7cb1ed199743.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/styleYsa.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wc98f0c4a5cca9.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wcf8d162b69589.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wcc500bfdded88.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wc8b89ce52f807.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wc7750dd66f337.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wc59c848069f23.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wca1de45d8145d.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wc799fc16ec6a.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wc437a767cb194.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wc4b05107ab16.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wc91b1fa5dcdca.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/Wcd02b20cb2535.css" media="screen">
					<link rel="stylesheet" href="themes/renelco/core/css/styleYsa.css" media="screen">

							<script src="index.php/core/js/Wc57e34d5f71a.htm"></script>
					<script src="core/vendor/jquery/Wc1bb8bab91276.htm"></script>
					<script src="core/vendor/jquery-migrate/Wc5c093f4f286a.htm"></script>
					<script src="core/vendor/jquery-ui/ui/Wc3191321b4202.htm"></script>
					<script src="core/vendor/underscore/Wccc6139df91c8.htm"></script>
					<script src="core/vendor/moment/min/Wcd8b79e7a15ed.htm"></script>
					<script src="core/vendor/handlebars/Wcd7a5c9f1668e.htm"></script>
					<script src="core/vendor/blueimp-md5/js/Wcc1fe9902a1fb.htm"></script>
					<script src="core/vendor/bootstrap/js/Wc5215c375c233.htm"></script>
					<script src="core/vendor/backbone/Wc657a86088a88.htm"></script>
					<script src="core/js/Wcb8e4812995b7.htm"></script>
					<script src="core/js/Wc11325e824d27.htm"></script>
					<script src="core/js/Wcb626ab1d19fa.htm"></script>
					<script src="core/js/Wcc2e98d7afcc5.htm"></script>
					<script src="core/js/Wcce3e8ce3898f.htm"></script>
					<script src="core/js/Wc1a803249b08a.htm"></script>
					<script src="core/js/Wcb49144a90ebc.htm"></script>
					<script src="core/js/Wc7b1a47460cd4.htm"></script>
					<script src="core/js/Wc1acec32e12e.htm"></script>
					<script src="core/search/js/Wcd7ea40f5281a.htm"></script>
					<script src="core/js/Wc7c10e02a05dd.htm"></script>
					<script src="core/js/Wc8c6dcbf3b783.htm"></script>
					<script src="core/js/Wcea62c1a407ba.htm"></script>
					<script src="core/js/Wce10d45c4a57d.htm"></script>
					<script src="core/vendor/snapjs/dist/latest/Wc85239cf926ab.htm"></script>
					<script src="core/vendor/backbone/Wc657a86088a88.htm"></script>
					<script src="core/js/Wc9bccaffc4ca7.htm"></script>
					<script src="core/js/Wca3454412c11b.htm"></script>
					<script src="core/js/Wc2f9d22b6eedf.htm"></script>
					<script src="core/js/Wc90c56f07143d.htm"></script>
					<script src="core/js/Wcbf454220a1d5.htm"></script>
					<script src="apps/encryption/js/Wc6beb6104ab5c.htm"></script>
					<script src="core/js/Wceeecee424959.htm"></script>
					<script src="core/js/Wce9533dff9604.htm"></script>
					<script src="core/js/Wc72d3e6bea0.htm"></script>
					<script src="core/js/Wc4a7c3dcb2e6c.htm"></script>
					<script src="core/js/Wc9ef0866d2baa.htm"></script>
					<script src="core/js/Wcd45729d9085c.htm"></script>
					<script src="core/js/Wcf2cd393c962d.htm"></script>
					<script src="core/js/Wc713913b20ff1.htm"></script>
					<script src="apps/files_pdfviewer/js/Wc1179d3423d00.htm"></script>
					<script src="apps/files_videoviewer/js/Wc893ed3e92db4.htm"></script>
					<script src="core/vendor/jsTimezoneDetect/Wcaa08b8b0b0da.htm"></script>
					<script src="core/js/Wceea884a27cdf.htm"></script>
					<script src="core/js/Wcf28ff5be21ee.htm"></script>
					<script src="core/js/Wc817940698c88.htm"></script>


					</head>
	<body id="body-login">
		<noscript>
	<div id="nojavascript">
		<div>
			This application requires JavaScript for correct operation. Please <a href="http://enable-javascript.com/" target="_blank" rel="noreferrer">enable JavaScript</a> and reload the page.		</div>
	</div>
</noscript>
		<div class="wrapper">
			<div class="v-align">
									<header role="banner">
						<div id="header">
							<div class="logo svg">
								<h1 class="hidden-visually">
									Renelcloud								</h1>
							</div>
							<div id="logo-claim" style="display:none;"></div>
						</div>
					</header>
<?php
if(isset($_GET["connex"])){
	echo "<p style=\"color:red;font-size:14px;\">Les login et mot de passe ne correspondent pas.<br/>Veuillez recommencer !<br/></p>";
}
if(isset($_GET["logout"])){
	session_unset();
 	echo "<p style=\"color:red;font-size:14px;\">Vous êtes déconnecté(e), à bientôt !</p>";

 }
 if(isset($_GET["err"])){
 	echo "<p style=\"color:red;font-size:14px;\">Vous devez vous connecter !</p>";

 }

 ?>
<!--[if IE 8]><style>input[type="checkbox"]{padding:0;}</style><![endif]-->
<form method="post" name="login" action="index1.php" enctype="multipart/form-data">
	<fieldset>
		<div id="message" class="hidden">
			<img class="float-spinner" alt=""
				src="themes/renelco/core/img/loading-dark.gif">
			<span id="messageText"></span>
			<!-- the following div ensures that the spinner is always inside the #message div -->
			<div style="clear: both;"></div>
		</div>
		<p class="grouptop">
			<input type="text" name="society" id="society"
				placeholder="Company"
				value=""
				autofocus autocapitalize="off" autocorrect="off" required>
			<label for="society" class="infield">Company</label>
			</p>
			<p class="groupmiddle">
			<input style="border-top:0;border-radius:0;" type="text" name="user" id="user"
				placeholder="Username"
				value=""
			 	autocapitalize="off" autocorrect="off" required>
			<label for="user" class="infield">Username</label>
		</p>

		<p class="groupbottom">
			<input type="password" name="password" id="password" value=""
				placeholder="Password"
				autocomplete="on" autocapitalize="off" autocorrect="off" required>
			<label for="password" class="infield">Password</label>
			<input type="submit" id="submit" name="submit" class="login primary icon-confirm svg" title="Log in" value="" disabled="disabled"/>
		</p>
	</fieldset>
</form>
				<div class="push"></div><!-- for sticky footer -->
			</div>
		</div>
		<footer role="contentinfo">
			<p class="info">
				© 2015-2017 <a href="http://www.renelco.com" target="_blank\">Renelco SA.</a><br/>Renelcloud</p>
		</footer>



</body>
</html>
