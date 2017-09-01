<?php include("header.php");
    if(isset($_GET["error"])){
          if($_GET["error"]==0){
              $message="Vous n'avez pas rempli les champs Nom, Prénom, Email ou/et IMEI. ";
          }
           if($_GET["error"]==1){
            $message="L'adresse mail n'est pas correctement formatée !";
           }
            $id=$_GET["id"];
    }
    if(isset($_GET["id_mod"])){
      $site_id=$_GET["id_mod"];
      $dem=mysqli_query($connect,"SELECT * FROM SITE WHERE SITE_ID='$site_id'");
      $data=$dem->fetch_array();
      $customer_id=$data["CUSTOMER_ID"];
      $address_id=$data["ADDRESS_ID"];
      $site_name=$data["NAME"];
      $desc_site=$data["DESCRIPTION"];
     
    }


  ?>
    <hr class="style_one"/>
      <section id='content'>
        <div class='container'>
              <div class='row'>
                <div class='col-sm-12'>
                  <div class='box'>
                    <div class='box-header red-background'>
                      <div class='title'><p>Modifier un site</p>
                         <a class="btn btn-danger btn-lg" style="float:right;" href="SiteList.php" title="Retour au tableau des sites">Retour au tableau</a>
                          <hr class="style_two"/>
                      </div>
                     
                    </div>
                  <div class='box-content'>
                  <form class="form" style="margin-bottom: 0;" method="post" action="SiteEdit.php" enctype="multipart/form-data" accept-charset="UTF-8"> <!--accept-charset="UTF-8"-->
          
                  <?php
                  if(isset($_GET["error"])){
                       echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                         echo "<p>".$message;
                         echo "<a class=\"btn btn-danger btn-lg\" style=\"float:right;\" href=\"SiteList.php\" title=\"Retour au tableau des sites\">Retour au tableau des sites</a><hr class=\"style_two\"/></p>";
                         echo "</div>";

                            
                  }
                    $req1=mysqli_query($connect,"SELECT * FROM CUSTOMER WHERE CUSTOMER_ID='$customer_id'");
                      $data1=$req1->fetch_assoc();
                      $contact=$data1["CONTACTNAME"];
                      $mail=$data1["EMAIL"];
                      $mobile=$data1["MOBILENR"];
                      $phone=$data1["PHONENR"];
                      $name=$data1["NAME"];
                       
                     $req2=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id'");
                      $data=$req2->fetch_assoc();
                      $numeroRue=$data["STREETNR"];
                      $address=$data["STREET"];
                      $cp=$data["ZIP"];
                      $city=$data["CITY"];
                      $province=$data["STATE"];
                      $country=$data["COUNTRY"];
                  
                    echo "<input name=\"site_id\" id=\"site_id\" type=\"hidden\" value=\"".$site_id."\" />"; 
                    echo "<input name=\"address_id\" id=\"address_id\" type=\"hidden\" value=\"".$address_id."\" />";
                 ?>
                   <div class='form-group'>
                       <label for='client'>Client </label> 
                       <input class='form-control' id='customer_id' name='customer_id' type='hidden' value="<?php echo $customer_id;?>">
                       <input class='form-control' id='customer_name' name='customer_name' value="<?php echo $name;?>" readonly>
                  </div>
                     
                       
                      <div class='form-group'>
                        <label for='site_name'>Nom du site  </label>
                        <input class='form-control' id='site_name' name='site_name' type='text' value="<?php echo $site_name ;?>">
                      </div>

                      <div class='form-group'>
                        <label for='desc_site'>Description  </label>
                        <input class='form-control' id='desc_site'  name='desc_site' type='text' value="<?php echo $desc_site;?>">
                      </div>                     
                      
                        
              
                      <div class="form-group">
                        <p class="form-actions" style="padding:1em;">L'adresse enregistrée est : <?php echo $numeroRue." ".$address." ".$cp." ".$city;?></p>
                        <label for="user_input_autocomplete_address">Tapez une adresse </label>
                          <input class="form-control" id="user_input_autocomplete_address" name="user_input_autocomplete_address" placeholder="Votre adresse...">
                       <hr class="style_two"/>
                     </div>
                

             
                <div class='col-sm-2'>
                  <div class='form-group'>
                      <label for='street_number'>Numéro de voie</label>
                      <input class="form-control" id="street_number" name="street_number" type="text" >
                    </div>
                  </div>
                <div class='col-sm-10'>
                  <div class='form-group'>
                      <label for='route'>Voie</label>
                      <input class="form-control" id="route" name="route" type="text" >
                  </div>
                </div>
                <hr class="style_one">
            
                  
                    <div class='form-group'>
                      <label for='locality'>Ville</label>
                      <input class="form-control" id="locality" name="locality" type="text" >
                    </div>

                    <div class='form-group'>
                       <label for='administrative_area_level_1'>Province</label>
                       <input class="form-control" id="administrative_area_level_1" name="administrative_area_level_1" readonly>
                    </div>
                 
                    <div class='form-group'>
                       <label for='postal_code'>Code postal</label>
                       <input class="form-control" id="postal_code" name="postal_code" type="text" >
                    </div>
                 
                    <div class='form-group'>
                       <label for='country'>Pays</label>
                       <input class="form-control" id="country" name="country" type="text" >
                    </div>
                     <div class='form-group'>
                      <label for='lat'>Latitude</label>
                      <input class="form-control" id="lng" name="lng" readonly>
                      <label for='lat'>Longitude</label>
                      <input class="form-control" id="lat" name="lat" readonly>
                   </div>
              
       
                  <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                      <div class="col-sm-10"></div>
                      <div class="col-sm-2">
                          <input style="float:right;" type="submit" id="modSite" name="modSite" value="Modifier" class="btn btn-danger btn-lg">
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
  
  
  
<div id="page1" style="display:none;" > 
<div class="iframe-responsive-wrapper1">
     <img class="iframe-ratio1" src="data:image/gif;base64,R0lGODlhEAAJAIAAAP///wAAACH5BAEAAAAALAAAAAAQAAkAAAIKhI+py+0Po5yUFQA7"/>
<center><iframe src="Manager.php" width="1400" height="1500" align="middle"></iframe>  </center>
</div>
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
   <script type="text/javascript">
    function initializeAutocomplete(id) {
      var element = document.getElementById(id);
      if (element) {
        var autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
        google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
      }
    }
    function onPlaceChanged() {
      var place = this.getPlace();
      document.getElementById('lat').value = place.geometry.location.lat();
      document.getElementById('lng').value  = place.geometry.location.lng();

      // console.log(place);  // Uncomment this line to view the full object returned by Google API.
       
      for (var i in place.address_components) {
        var component = place.address_components[i];
        
        for (var j in component.types) {  // Some types are ["country", "political"]
           var type_element = document.getElementById(component.types[j]);

          if (type_element) {
            if(type_element==administrative_area_level_1){
              type_element.value = component.short_name;
            }else{
              type_element.value = component.long_name;

            }

          }
        }
      }
    }

    google.maps.event.addDomListener(window, 'load', function() {
      initializeAutocomplete('user_input_autocomplete_address');
     
    });
    function afficher_div(image) 
    { 
    switch(image){ 
    case 'url1': 
    document.getElementById("menu").style.display="none"; 
    document.getElementById("page1").style.display="block";

    break; 


    } 
    } 

    </script> 
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
