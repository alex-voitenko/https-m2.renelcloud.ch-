<?php 
	include("header.php");
	if(isset($_POST["address_insert_id"]) && !empty($_POST["address_insert_id"])){
		
	$id = $_POST['organization_id'];
	$address_id = $_POST['address_insert_id'];
    $numeroRue=$_POST["street_number"];
    $address=mysqli_real_escape_string($connect,$_POST["route"]);
    $cp=mysqli_real_escape_string($connect,$_POST["postal_code"]);
    $city=mysqli_real_escape_string($connect,$_POST["locality"]);
    $province=mysqli_real_escape_string($connect,$_POST["administrative_area_level_1"]);
    $country=mysqli_real_escape_string($connect,$_POST["country"]);
    $lng=$_POST["lng"];
    $lat=$_POST["lat"];
    $address_sql = "SELECT * FROM ORGANIZATION_UNIT WHERE ORGANIZATION_UNIT_ID='$id'";
    //print $address_sql;
    $aff=mysqli_query($connect,"SELECT * FROM ORGANIZATION_UNIT WHERE ORGANIZATION_UNIT_ID='$id'");
    $data=$aff->fetch_assoc();
   
    if(!empty($numeroRue)){

      if($address_id == 0){
      	$insert_address_sql = "INSERT INTO ADDRESS (ADDRESS_ID,STREET,STREETNR,ZIP,CITY,STATE,COUNTRY,LATITUDE,LONGITUDE)
        VALUES(NULL,'$address','$numeroRue','$cp','$city','$province','$country','$lat','$lng')";
        if($dem=mysqli_query($connect, $insert_address_sql)){
            $address_id2  = mysqli_insert_id($connect);
            $dem2=mysqli_query($connect,"UPDATE ORGANIZATION_UNIT_ID SET ADDRESS_ID='$address_id2' WHERE ORGANIZATION_UNIT_ID='$id'");
            $affAdd=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id2'");
         }
      }else{
       if($dem=mysqli_query($connect,"UPDATE ADDRESS SET STREET='$address', STREETNR='$numeroRue',ZIP='$cp', CITY='$city',STATE='$province',COUNTRY='$country',LATITUDE='$lat',LONGITUDE='$lng' WHERE ADDRESS_ID='$address_id'")){
        
            $affAdd=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id'");
        }
           
            $data=$affAdd->fetch_assoc();
            $numeroRue=$data["STREETNR"];
            $address=$data["STREET"];
            $province=$data["STATE"];
            $cp=$data["ZIP"];
            $city=$data["CITY"];
            $country=$data["COUNTRY"];
      }
       $message="Modification de l'adresse effectuée ! "; 
       $error = "";
       
       
       
    }else{
       $message="Les champs Numéro de voie, Voie, etc, sont obligatoires !";
       $error = "Error!";
    }
    
    $get_sql = "SELECT ORGANIZATION_UNIT.ORGANIZATION_UNIT_ID,ORGANIZATION_UNIT.PARENT_ORGANIZATION_UNIT_ID, ORGANIZATION_UNIT.NAME,ORGANIZATION_UNIT.DESCRIPTION,
		ORGANIZATION_UNIT_TYPE.NAME AS TYPE_NAME, 
			ORGANIZATION_UNIT.IS_LEGAL_ENTITY, ORGANIZATION_UNIT.ADDRESS_ID,
	ORGANIZATION_UNIT.ACTIVE_FROM,ORGANIZATION_UNIT.ACTIVE_TO, SCHEDULE.NAME AS SCHEDULE_NAME, concat(ADDRESS.STREET, ' ', ADDRESS.STREETNR, ' ', ADDRESS.CITY, ' ', 
	ADDRESS.STATE, ' ', ADDRESS.COUNTRY) AS ADDRESS
	 FROM ORGANIZATION_UNIT LEFT JOIN ORGANIZATION_UNIT_TYPE
	 ON  ORGANIZATION_UNIT.ORGANIZATION_UNIT_TYPE_ID =ORGANIZATION_UNIT_TYPE.ORGANIZATION_UNIT_TYPE_ID  
	 LEFT JOIN ADDRESS ON ORGANIZATION_UNIT.ADDRESS_ID = ADDRESS.ADDRESS_ID
	 LEFT JOIN SCHEDULE ON ORGANIZATION_UNIT.SCHEDULE_ID = SCHEDULE.SCHEDULE_ID WHERE ORGANIZATION_UNIT.ORGANIZATION_UNIT_ID = ".$id;
	   	$query = mysqli_query($connect, $get_sql);
		$data = $query->fetch_assoc();
		$address_id = $data['ADDRESS_ID'];
    	
    
	}
	if(isset($_POST["id"]) || isset($_GET["id"])){
	    if(isset($_POST["id"])){
	    	$id = $_POST["id"];
	    	$organization_unit_type_id = $_POST['organization_unit_type_id'];
	    	$organization_unit_name = $_POST['organization_unit_name'];
	    	$organization_description = $_POST['description'];
	    	$is_legal_entity = $_POST['legal_entity'];
	    	$parent_organization_unit_id = $_POST['partent_organization_unit_id'];
	    	$schedule_id = $_POST['schedule_id'];
	    	if($id == 0){
	    		$sql = "INSERT INTO `ORGANIZATION_UNIT` (`ORGANIZATION_UNIT_ID`, `ORGANIZATION_UNIT_TYPE_ID`, `NAME`, `DESCRIPTION`, `IS_LEGAL_ENTITY`, `PARENT_ORGANIZATION_UNIT_ID`, `SCHEDULE_ID`) 
	    		VALUES ( NULL, '".$organization_unit_type_id."', '".$organization_unit_name."', '".$organization_description."', '".$is_legal_entity."', '".$parent_organization_unit_id."', '".$schedule_id."');
	    		";
	    	}
	    	else if($id > 0){
	    		
	    		$sql = "UPDATE `ORGANIZATION_UNIT`  SET `ORGANIZATION_UNIT_TYPE_ID`='".$organization_unit_type_id."', `NAME`='".$organization_unit_name."', `DESCRIPTION`='".$organization_description."',
	    		 `IS_LEGAL_ENTITY`='".$is_legal_entity."', `PARENT_ORGANIZATION_UNIT_ID`='".$parent_organization_unit_id."', `SCHEDULE_ID`='".$schedule_id."' WHERE `ORGANIZATION_UNIT_ID`=".$id;
	    	}
	    	
	    	mysqli_query($connect, $sql);
	    	if($id == 0){
	    		$id=mysqli_insert_id($connect);
	    	}
	    	$error = "";	
	    }
	    else if(isset($_GET["id"])){
	    	$id = $_GET["id"];
	    	$address_id = 0;
	    	$error = "";
	    }
		$get_sql = "SELECT ORGANIZATION_UNIT.ORGANIZATION_UNIT_ID,ORGANIZATION_UNIT.PARENT_ORGANIZATION_UNIT_ID, ORGANIZATION_UNIT.NAME,ORGANIZATION_UNIT.DESCRIPTION,
		ORGANIZATION_UNIT_TYPE.NAME AS TYPE_NAME, 
			ORGANIZATION_UNIT.IS_LEGAL_ENTITY, ORGANIZATION_UNIT.ADDRESS_ID,
	ORGANIZATION_UNIT.ACTIVE_FROM,ORGANIZATION_UNIT.ACTIVE_TO, SCHEDULE.NAME AS SCHEDULE_NAME, concat(ADDRESS.STREET, ' ', ADDRESS.STREETNR) AS STREET_NAME, concat(ADDRESS.CITY, ' ', 
							ADDRESS.STATE) AS CITY_NAME, ADDRESS.ZIP AS ZIP_CODE, ADDRESS.COUNTRY AS COUNTRY
	 FROM ORGANIZATION_UNIT LEFT JOIN ORGANIZATION_UNIT_TYPE
	 ON  ORGANIZATION_UNIT.ORGANIZATION_UNIT_TYPE_ID =ORGANIZATION_UNIT_TYPE.ORGANIZATION_UNIT_TYPE_ID  
	 LEFT JOIN ADDRESS ON ORGANIZATION_UNIT.ADDRESS_ID = ADDRESS.ADDRESS_ID
	 LEFT JOIN SCHEDULE ON ORGANIZATION_UNIT.SCHEDULE_ID = SCHEDULE.SCHEDULE_ID WHERE ORGANIZATION_UNIT.ORGANIZATION_UNIT_ID = ".$id;
	   	$query = mysqli_query($connect, $get_sql);
		$data = $query->fetch_assoc();
		$address_id = $data['ADDRESS_ID'];
	}
	else if($error !=""){
		$error = "Error!";
	}
	?>
    <hr class="style_one"/>
      <section id='content'>
        <div class='container'>
         
          <div class='row'>
          
            <div class='col-sm-12'>
              <div class='box'>
                <div class='box-header red-background'>
                  <div class='title'><p> 
                    <?php echo "Organization : ".$data['NAME']; 
                    if($address_id==0){
                      echo " : Vous devez remplir le formulaire d'adresse avant de continuer !</p>";
                    }else{
                      echo "</p><a class=\"btn btn-danger btn-lg\" style=\"float:right;\" href=\"CustomerList.php\" title=\"Retour au tableau des sites\">Retour au tableau</a>";
                    }
                    ?>
                      
                      <hr class="style_two"/>
                  </div>
                 </div>
                    <div class='box-content'>
                       <?php
                          if($error!=""){
                          	
                          	
                          
                             echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                             echo "<p>".$error."</p>";

                             echo "<hr class=\"style_two\"/></div>";
                           }
                         ?>

                       <div class='col-sm-12' >

                        <hr class="style_one"/>
                    
                          <div class='col-sm-4' >
                                  <h2><?php echo $data["NAME"] ;?></h2>
                                  <p><?php echo $data["DESCRIPTION"] ;?></p>
                            </div>
                            <div class='col-sm-4'>
                                  <?php if($address_id!=0):?>
                                  <p><?php echo $data['STREET_NAME']; ?><br/> <?php echo $data['CITY_NAME']; ?><br/>
                                    <?php echo $data['ZIP_CODE']; ?><br/>
                                    <?php echo $data['COUNTRY'];?>
                                    </p>
                                    <?php 
                                  else:
                                     echo "<p>L'adresse n'est pas encore enregistrée !</p>";
                                  endif;
                                  ?>


                               </div><hr class="style_one" />
                             <?php 
                             	if($data['PARENT_ORGANIZATION_UNIT_ID'] > 0 ){
                             		$parent_sql = "SELECT * FROM ORGANIZATION_UNIT WHERE ORGANIZATION_UNIT_ID = ".$data['PARENT_ORGANIZATION_UNIT_ID'];
                             		$parent = mysqli_query($connect,$parent_sql );
                             		$parent_row = $parent->fetch_assoc();
                             		$parent_name = $parent_row['NAME'];
                             	}
                             	else $parent_name = "";
                             ?>
                            <div class='col-sm-4' >
                              <h3><?php echo $data['NAME'] ;?> </h3>
                            
                              <p>Parent : <?php echo $parent_row['NAME'] ;?></a></p>
                              <p>Type : <?php echo $data['TYPE_NAME'];?></a></p>
                              <p>Schedule : <?php echo $data['SCHEDULE_NAME'] ;?></p>
                            </div>
                            
                             

                            

                              </div>
                          

                          <hr class="style_two"/>
                     

                      <div class="col-sm-12">
                        <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6" >
                            <?php
                             if($address_id==0){
                                   echo "<a style=\"float:right;\" id=\"addAddress\" href=\"#displayAddress\" class=\"btn btn-danger btn-lg\">Ajouter une adresse</a>&nbsp;&nbsp";
                            }else{
                                   echo "<a style=\"float:left;\" id=\"addAddress\" href=\"#displayAddress\" class=\"btn btn-danger btn-lg\">Modifier cette adresse</a>&nbsp;&nbsp";
                                   echo "<a style=\"float:right;\" href=\"OrganizationUnitMod.php?id_mod=$id\" class=\"btn btn-danger btn-lg\">Modifier </a>";

                            }

                            ?>

                            </div>
                            <hr class="style_two"/>
                        </div>

                      </div>
                       <hr class="style_one"/>

  <!--ADRESSE-->
          <div class="col-sm-12" id="displayAddress">
             <form class="form" style="margin-bottom: 0;" method="post" action="#" enctype="multipart/form-data">   
             	<input type="hidden" name="address_insert_id" value="<?php echo $address_id;?>" />
             	<input type="hidden" name="organization_id" value="<?php echo $id;?>" />
                  <div class="col-sm-12">
                      <div class="form-group">
                        <label for="user_input_autocomplete_address">Tapez une adresse </label>
                          <input class="form-control" id="user_input_autocomplete_address" name="user_input_autocomplete_address" placeholder="Votre adresse...">
                       <hr class="style_two"/>
                     </div>
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
             
               <div class='col-sm-12'>
                  
                    <div class='form-group'>
                      <label for='locality'>Ville</label>
                      <input class="form-control" id="locality" name="locality" type="text" >
                    </div>

                    <div class='form-group'>
                       <label for='administrative_area_level_1'>Province</label>
                       <input class="form-control" id="administrative_area_level_1" name="administrative_area_level_1" readonly >
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
                      <label for='lng'>Latitude</label>
                      <input class="form-control" id="lng" name="lng" readonly>
                       </div>
                    <div class='form-group'>  
                      <label for='lat'>Longitude</label>
                      <input class="form-control" id="lat" name="lat" readonly>
                   </div>
              
       
                  <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                     <div class="col-sm-10"> </div>
                      <div class="col-sm-2">
                          <input style="float:right;" type="submit" id="confirmAddress" name="confirmAddress" value="Enregistrer" class="btn btn-danger btn-lg">
                      </div>
                    <hr class="style_two"/>
                  </div>  
                  </div>
                 </div> 
                 </form>
             <hr class="style_two"/>
                  </div>
                    </div>
                  </div>
            </div>
          </div>
         </div>
      </section>
    </div>
    <!-- / jquery [required] -->
   
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

    <script src="assets/javascripts/plugins/fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/select2/select2.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/input_mask/bootstrap-inputmask.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/charCount/charCount.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/autosize/jquery.autosize-min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_switch/bootstrapSwitch.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/mention/mention.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/typeahead/typeahead.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/common/wysihtml5.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/common/bootstrap-wysihtml5.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/pwstrength/pwstrength.js" type="text/javascript"></script>
   <script src="assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
   
  

<script type="text/javascript">

//DISPLAY CHOISIR UN RESPONSABLE 
 $(document).ready(function(){

   $("#type_col").change(function () {

        if($("#type_col option:selected").val()!=1) {
            $("#responsable").css("display","block");
        }else{
            $("#responsable").css("display","none");
        }
    });
 });
  $(document).ready(function(){
	  $("#addAddress").click(function () {

          if( $("#displayAddress").css("display","block")){
            var page = $(this).attr('href'); // Page cible
            var speed = 2000; // Durée de l'animation (en ms)
            $('html, body').animate( { scrollTop: $(page).offset().top }, speed );
            return false;
          }
          
       });
 });
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

	//AJOUTER UNE ADRESSE
	 $(document).ready(function(){
	       $("#addAddress").click(function () {

	           if( $("#displayAddress").css("display","block")){
	             var page = $(this).attr('href'); // Page cible
	             var speed = 2000; // Durée de l'animation (en ms)
	             $('html, body').animate( { scrollTop: $(page).offset().top }, speed );
	             return false;
	           }
	           
	        });
	     });


</script>
</body>
</html>
