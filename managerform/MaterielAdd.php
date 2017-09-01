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
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<meta content='text/html;charset=utf-8' http-equiv='content-type'>
<link href='assets/images/meta_icons/favicon.ico' rel='shortcut icon' type='image/x-icon'>
<link href='assets/images/meta_icons/apple-touch-icon.png' rel='apple-touch-icon-precomposed'>
<link href='assets/images/meta_icons/apple-touch-icon-57x57.png' rel='apple-touch-icon-precomposed' sizes='57x57'>
<link href='assets/images/meta_icons/apple-touch-icon-72x72.png' rel='apple-touch-icon-precomposed' sizes='72x72'>
<link href='assets/images/meta_icons/apple-touch-icon-114x114.png' rel='apple-touch-icon-precomposed' sizes='114x114'>
<link href='assets/images/meta_icons/apple-touch-icon-144x144.png' rel='apple-touch-icon-precomposed' sizes='144x144'>
<link rel="stylesheet" href="../themes/renelco/core/css/styleYsa.css" media="screen">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/font-awesome.css">
<link rel="stylesheet" href="../css/animate.css">
<link rel="stylesheet" href="../css/templatemo_misc.css">
<link rel="stylesheet" href="../css/templatemo_style.css">
<link rel="shortcut icon" href="../images/icon2.ico">
<script src="../js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
<link href="assets/stylesheets/plugins/datatables/bootstrap-datatable.css" media="all" rel="stylesheet" type="text/css" />
<link href="assets/stylesheets/bootstrap/bootstrap.css" media="all" rel="stylesheet" type="text/css" />
<link href="assets/stylesheets/light-theme.css" media="all" id="color-settings-body-color" rel="stylesheet" type="text/css" />
<link href="assets/stylesheets/theme-colors.css" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../js/autocomplete-0.3.0.min.css" media="screen">
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAY5oOo1tORFveikHX3yLL9PSNnDYJesgc"></script>
<script type="text/javascript" src="../js/autocomplete-0.3.0.min.js"></script>

    <!--[if lt IE 9]>
      <script src="assets/javascripts/ie/html5shiv.js" type="text/javascript"></script>
      <script src="assets/javascripts/ie/respond.min.js" type="text/javascript"></script>
    <![endif]-->
</head>
  <body >
  <?php include("header.php");
        if(isset($_GET["error"])){
  if($_GET["error"]==0){
      $message="Vous n'avez pas rempli les champs Nom, Description ou/et Prix unitaire. ";
  }
     if($_GET["error"]==1){
      $message="Problème à l'insertion des données, veuillez recommencer !";
     }
  $id=$_GET["id"];
  }
?>
    <hr class="style_one"/>
      <section id='content'>
        <div class='container'>
              <div class='row'>
                <div class='col-sm-12'>
                  <div class='box'>
                    <div class='box-header red-background'>
                      <div class='title'><p>Matériel : Ajouter</p>
                         <a class="btn btn-danger btn-lg" style="float:right;" href="MaterielList.php" title="Retour au tableau des matériels">Retour au tableau</a>
                          <hr class="style_two"/>
                      </div>
                     
                    </div>
                  <div class='box-content'>
                  <form class="form" style="margin-bottom: 0;" method="post" action="MaterielEdit.php" enctype="multipart/form-data" accept-charset="UTF-8"> <!--accept-charset="UTF-8"-->
          
                  <?php
                  if(isset($_GET["error"])){
                       echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                         echo "<p>".$message;
                         echo "<a class=\"btn btn-danger btn-lg\" style=\"float:right;\" href=\"MaterielList.php\" title=\"Retour au tableau des matériels\">Retour au tableau des matériels</a><hr class=\"style_two\"/></p>";
                         echo "</div>";

                            
                  }
            
                 ?>
                   <div class='col-sm-2' style="margin:1em auto;">

                    <img class="img-responsive avatar" src="../images/tools.png">
                       
                      <div class='form-group'>
                        <label>Télécharger une photo  </label>
                        <input class='form-control' id='photo' name='photo' type='file'>
                      </div>
                    </div>
                     
                    <div class='col-sm-10' >     
                      <div class='form-group'>
                        <label for='mat_name'>Nom </label>
                        <input class='form-control' id='mat_name' name='mat_name' type='text' placeholder="Nom">
                      </div>

                      <div class='form-group'>
                        <label for='mat_desc'>Description </label>
                        <input class='form-control' id='mat_desc'  name='mat_desc' type='text' placeholder="Description">
                      </div>                     
                      
                       <div class='form-group'>
                        <label for='mat_prix'>Prix unitaire </label>
                        <input class='form-control' id='mat_prix'  name='mat_prix' type='text' placeholder="Prix unitaire">
                      </div>     
              </div>
        <hr class="style_two"/>
                  <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                      <div class="col-sm-10"></div>
                      <div class="col-sm-2">
                          <input style="float:right;" type="submit" id="addMat" name="addMat" value="Ajouter" class="btn btn-danger btn-lg">
                      </div>
                    <hr class="style_two"/>
                    </div>  
                  </div>
                 </div> 
                  <hr class="style_one"/>
                 </form>
              
                    <hr class="style_one"/>
                     </div>
                  </div>
                    <hr class="style_one"/>
                </div>
              </div>
            </div>
          </div>
        
        </div>
      </section>
    </div>
  
  





     <script src="assets/javascripts/jquery/jquery.min.js" type="text/javascript"></script>
    <!-- / jquery mobile (for touch events) -->
    <script src="assets/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
    <!-- / jquery migrate (for compatibility with new jquery) [required] -->
    <script src="assets/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
    <!-- / jquery ui -->
    <script src="assets/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
    <!-- / jQuery UI Touch Punch -->
    <script src="assets/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
    <!-- / bootstrap [required] -->
    <script src="assets/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
    <!-- / modernizr -->
    <script src="assets/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
    <!-- / retina -->
    <script src="assets/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
    <!-- / theme file [required] -->
    <script src="assets/javascripts/theme.js" type="text/javascript"></script>
    <!-- / START - page related files and scripts [optional] -->
    <script src="assets/javascripts/plugins/fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/select2/select2.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/input_mask/bootstrap-inputmask.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/charCount/charCount.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/autosize/jquery.autosize-min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_switch/bootstrapSwitch.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/naked_password/naked_password-0.2.4.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/mention/mention.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/typeahead/typeahead.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/common/wysihtml5.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/common/bootstrap-wysihtml5.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/pwstrength/pwstrength.js" type="text/javascript"></script>
  
    </body>
</html>
