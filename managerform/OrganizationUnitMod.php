
   
      <?php  
      	include("header.php");
      	$organization_types = mysqli_query($connect, "SELECT * FROM ORGANIZATION_UNIT_TYPE");
      	$organizations = mysqli_query($connect, "SELECT * FROM ORGANIZATION_UNIT");
      	$schedules = mysqli_query($connect, "SELECT * FROM SCHEDULE");
      	if(isset($_GET["id_mod"])){
      		$id=$_GET["id_mod"];
      		if($id > 0){
      			$get_sql = "SELECT ORGANIZATION_UNIT.ORGANIZATION_UNIT_TYPE_ID, ORGANIZATION_UNIT.ORGANIZATION_UNIT_ID,ORGANIZATION_UNIT.PARENT_ORGANIZATION_UNIT_ID, ORGANIZATION_UNIT.NAME,ORGANIZATION_UNIT.DESCRIPTION,
					ORGANIZATION_UNIT_TYPE.NAME AS TYPE_NAME, 
						ORGANIZATION_UNIT.IS_LEGAL_ENTITY, ORGANIZATION_UNIT.ADDRESS_ID, ORGANIZATION_UNIT.SCHEDULE_ID,ORGANIZATION_UNIT.ADDRESS_ID,
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
      	}
		if(isset($_POST["address_insert_id"]) ){
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
			   if($id > 0){
      			$get_sql = "SELECT ORGANIZATION_UNIT.ORGANIZATION_UNIT_TYPE_ID, ORGANIZATION_UNIT.ORGANIZATION_UNIT_ID,ORGANIZATION_UNIT.PARENT_ORGANIZATION_UNIT_ID, ORGANIZATION_UNIT.NAME,ORGANIZATION_UNIT.DESCRIPTION,
					ORGANIZATION_UNIT_TYPE.NAME AS TYPE_NAME, 
						ORGANIZATION_UNIT.IS_LEGAL_ENTITY, ORGANIZATION_UNIT.ADDRESS_ID, ORGANIZATION_UNIT.SCHEDULE_ID,ORGANIZATION_UNIT.ADDRESS_ID,
				ORGANIZATION_UNIT.ACTIVE_FROM,ORGANIZATION_UNIT.ACTIVE_TO, SCHEDULE.NAME AS SCHEDULE_NAME, concat(ADDRESS.STREET, ' ', ADDRESS.STREETNR, ' ', ADDRESS.CITY, ' ', 
				ADDRESS.STATE, ' ', ADDRESS.COUNTRY) AS ADDRESS
				 FROM ORGANIZATION_UNIT LEFT JOIN ORGANIZATION_UNIT_TYPE
				 ON  ORGANIZATION_UNIT.ORGANIZATION_UNIT_TYPE_ID =ORGANIZATION_UNIT_TYPE.ORGANIZATION_UNIT_TYPE_ID  
				 LEFT JOIN ADDRESS ON ORGANIZATION_UNIT.ADDRESS_ID = ADDRESS.ADDRESS_ID
				 LEFT JOIN SCHEDULE ON ORGANIZATION_UNIT.SCHEDULE_ID = SCHEDULE.SCHEDULE_ID WHERE ORGANIZATION_UNIT.ORGANIZATION_UNIT_ID = ".$id;
				   	$query = mysqli_query($connect, $get_sql);
					$data = $query->fetch_assoc();
			   }
			    if(!empty($numeroRue)){
			
			      if($address_id == 0){
			      	$insert_address_sql = "INSERT INTO ADDRESS (ADDRESS_ID,STREET,STREETNR,ZIP,CITY,STATE,COUNTRY,LATITUDE,LONGITUDE)
			        VALUES(NULL,'$address','$numeroRue','$cp','$city','$province','$country','$lat','$lng')";
			        if($dem=mysqli_query($connect, $insert_address_sql)){
			            $address_id2  = mysqli_insert_id($connect);
			            $organization_update_sql = "UPDATE ORGANIZATION_UNIT SET ADDRESS_ID='$address_id2' WHERE ORGANIZATION_UNIT_ID='$id'";
			            $dem2=mysqli_query($connect,$organization_update_sql);
			            $affAdd=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id2'");
			         }
			      }else{
			      	$update_address_sql = "UPDATE ADDRESS SET STREET='$address', STREETNR='$numeroRue',ZIP='$cp', CITY='$city',STATE='$province',COUNTRY='$country',LATITUDE='$lat',LONGITUDE='$lng' WHERE ADDRESS_ID='$address_id'";
				       if($dem=mysqli_query($connect,$update_address_sql)){
				        
				            $affAdd=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id'");
				        }
			           /*
			            $data=$affAdd->fetch_assoc();
			            $numeroRue=$data["STREETNR"];
			            $address=$data["STREET"];
			            $province=$data["STATE"];
			            $cp=$data["ZIP"];
			            $city=$data["CITY"];
			            $country=$data["COUNTRY"];*/
			      }
			       $message="Modification de l'adresse effectuée ! "; 
			       $error = "";
			       
			       
			       
			    }else{
			       $message="Les champs Numéro de voie, Voie, etc, sont obligatoires !";
			       $error = "Error!";
			    }
		    	
    
		}
		if(isset($_POST["id"])){
	    	$id = $_POST["id"];
	    	$organization_unit_type_id = $_POST['organization_unit_type_id'];
	    	$organization_unit_name = $_POST['organization_unit_name'];
	    	$organization_description = $_POST['description'];
	    	$is_legal_entity = $_POST['legal_entity'];
	    	$parent_organization_unit_id = $_POST['partent_organization_unit_id'];
	    	$schedule_id = $_POST['schedule_id'];
	    	$address_insert_id = $_POST['address_insert_id1'];
	    	if($id == 0){
	    		if($address_insert_id > 0){
	    			$sql = "INSERT INTO `ORGANIZATION_UNIT` (`ORGANIZATION_UNIT_ID`, `ORGANIZATION_UNIT_TYPE_ID`, `NAME`, `DESCRIPTION`, `IS_LEGAL_ENTITY`, 
	    			`ADDRESS_ID`,`PARENT_ORGANIZATION_UNIT_ID`, `SCHEDULE_ID`) 
		    		VALUES ( NULL, '".$organization_unit_type_id."', '".$organization_unit_name."', '".$organization_description."', '".$is_legal_entity."', '".$address_insert_id."', '".$parent_organization_unit_id."', '".$schedule_id."');
		    		";
	    		}
	    		else{
		    		$sql = "INSERT INTO `ORGANIZATION_UNIT` (`ORGANIZATION_UNIT_ID`, `ORGANIZATION_UNIT_TYPE_ID`, `NAME`, `DESCRIPTION`, `IS_LEGAL_ENTITY`, `PARENT_ORGANIZATION_UNIT_ID`, `SCHEDULE_ID`) 
		    		VALUES ( NULL, '".$organization_unit_type_id."', '".$organization_unit_name."', '".$organization_description."', '".$is_legal_entity."', '".$parent_organization_unit_id."', '".$schedule_id."');
		    		";
	    		}
	    	}
	    	else if($id > 0){
	    		
	    		$sql = "UPDATE `ORGANIZATION_UNIT`  SET `ORGANIZATION_UNIT_TYPE_ID`='".$organization_unit_type_id."', `NAME`='".$organization_unit_name."', `DESCRIPTION`='".$organization_description."',
	    		 `IS_LEGAL_ENTITY`='".$is_legal_entity."', `PARENT_ORGANIZATION_UNIT_ID`='".$parent_organization_unit_id."', `SCHEDULE_ID`='".$schedule_id."' WHERE `ORGANIZATION_UNIT_ID`=".$id;
	    	}
	    	
	    	mysqli_query($connect, $sql);

	    	if($id > 0){
	    		?><script>
	    			window.location.href = "OrganizationUnitList.php";
	    		</script>
	    		<?php 
	    	}
	    	$error = "";	
	    }
      ?>
    
	<hr class="style_one"/>
	<section id='content'>
		<div class='container'>
			<div class="row">
				<div class='col-sm-12'>
				
					<div class='box'>
						<div class='box-header red-background'>
							<div class='title'><p>Organization : <?php echo $data['NAME'];?> </p>
								<a class="btn btn-danger btn-lg" style="float:right;" href="OrganizationUnitList.php" title="Retour au tableau">Retour au tableau</a>
							<hr class="style_two"/>
                      		</div>
						</div>
						<div class='box-content clearfix'>
	                       <?php
	                       if(!empty($message)){
	                         echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
	                         echo "<p>".$message;
	                         echo "</p></div>";
	                       }
	                        
	                         ?>
	                         <form class="form" style="margin-bottom: 0;" method="post" action="OrganizationUnitMod.php" enctype="multipart/form-data" >
	                        <div class="col-sm-12">
	                        	<hr class="style_one"/>
					<input type="hidden" name="address_insert_id1" value="<?php if($address_id > 0) echo $address_id; else echo "0";?>" />
             					<input type="hidden" name="id" value="<?php echo $id;?>" />
								<div class='form-group'>
									<label for='organizatin_unit_type_id'>Type</label>
									<select class="form-control" id="organization_unit_type_id" name="organization_unit_type_id">
			                        	<?php if($organization_types):while($row = $organization_types->fetch_assoc()):?>
			                        	<option value="<?php echo $row['ORGANIZATION_UNIT_TYPE_ID']; ?>" <?php if($row['ORGANIZATION_UNIT_TYPE_ID'] == $data['ORGANIZATION_UNIT_TYPE_ID']) echo "selected";?> > <?php echo $row['NAME']?></option>
			                        	<?php endwhile; endif;?>
		                        	</select>
		                    	</div>
		                    	<div class='form-group'>
		                        	<label for='organizatin_unit_name'>Nom</label>
		                        	<input class="form-control" id="organization_unit_name" name="organization_unit_name" placeholder="Organization Name" type="text" value="<?php echo $data['NAME'];?>" />
								</div>
								<div class='form-group'>
			                    	<label for="desc_cus">Description</label>
			                        <input type="text" class="form-control" id="description" name="description" placeholder="Organization Unit Description" value="<?php echo $data['DESCRIPTION'];?>" />
			                    </div>
								<div class='form-group'>
									<label for='legal_entity'>Legal Entity</label>
									<select id = "legal_entity" name="legal_entity" class="form-control">
										<option value="Y" <?php if($data['IS_LEGAL_ENTITY'] == "Y") echo "selected";?>>YES</option>
										<option value="N" <?php if($data['IS_LEGAL_ENTITY'] == "N") echo "selected";?>>NO</option>
									</select>
								</div>
								<div class='form-group'>
									<label for='partent_organization_unit_id'>Parent Organization Unit</label>
									<select id="partent_organization_unit_id" name="partent_organization_unit_id" class="form-control">
										<?php if($organizations):while($row = $organizations->fetch_assoc()):?>
			                        	<option value="<?php echo $row['ORGANIZATION_UNIT_ID']; ?>" <?php if($row['ORGANIZATION_UNIT_ID']== $data['PARENT_ORGANIZATION_UNIT_ID']) echo "selected";?>><?php echo $row['NAME']?></option>
			                        	<?php endwhile; endif;?>
									</select> 
								</div>
								<div class='form-group'>
									<label for='schedule_id'>Schedule</label>
									<select id="schedule_id" name="schedule_id" class="form-control">
										<?php if($schedules):while($row = $schedules->fetch_assoc()):?>
			                        	<option value="<?php echo $row['SCHEDULE_ID']; ?>" <?php if($row['SCHEDULE_ID'] == $data['SCHEDULE_ID']) echo "selected";	?> ><?php echo $row['NAME']?></option>
			                        	<?php endwhile; endif;?>
									</select> 
								</div>
							</div>
							<div class="col-sm-12">
								<div class='form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg' style='margin-bottom: 0;'>
									<div class='row' >
										<div class='col-sm-8'></div>
		
										<div class='col-sm-2' >
											<a style="float:left;" id="addAddress" href="#displayAddress" class="btn btn-danger btn-lg">Modifier cette adresse</a>&nbsp;&nbsp;
										</div>
										<div class="col-sm-2">
											<input type="submit" id="addCustomer" name="addCustomer" value="MODIFIER" class='btn btn-danger btn-lg'>
										</div>
									</div>
								</div>
								
								<hr class="style_two"/>
							</div>
							</form>
	              		<!--ADRESSE-->
	          				<div class="col-sm-12" id="displayAddress">
	          					<hr class="style_one"/>	
		             			<form class="form" style="margin-bottom: 0;" method="post" action="OrganizationUnitMod.php" enctype="multipart/form-data">   
								<input type="hidden" name="address_insert_id" value="<?php if($address_id > 0) echo $address_id; else echo "0";?>" />
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
								</form>
								<hr class="style_two"/>
							</div> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
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
