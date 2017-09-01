<?php 
include("header.php");
include("../fonctionTel.php");


if(isset($_POST["confirmAddress"])){
    $id=$_POST["collaborator_id"];
    $address_id=$_POST["address_id"];
    $numeroRue=$_POST["street_number"];
    $address=mysqli_real_escape_string($connect,$_POST["route"]);
    $cp=mysqli_real_escape_string($connect,$_POST["postal_code"]);
    $city=mysqli_real_escape_string($connect,$_POST["locality"]);
    $province=mysqli_real_escape_string($connect,$_POST["administrative_area_level_1"]);
    $country=mysqli_real_escape_string($connect,$_POST["country"]);
    $lng=$_POST["lng"];
    $lat=$_POST["lat"];
    $aff=mysqli_query($connect,"SELECT * FROM COLLABORATOR WHERE COLLABORATOR_ID='$id'");
    $data=$aff->fetch_assoc();
   
    $lname=$data["LASTNAME"];
    $fname=$data["FIRSTNAME"];
    $tel=$data["MOBILENR"];
    $cost=$data["COST"];
    $gender=$data["GENDER_ID"];
    $mail=$data["EMAIL"];
    $imei=$data["IMEI"];
    $type_col=$data["COLLABORATOR_TYPE_ID"];
    $resp_col=$data["MANAGER_ID"];
    if(!empty($numeroRue)){

      if(empty($address_id)){
      	$insert_address_sql = "INSERT INTO ADDRESS (ADDRESS_ID,STREET,STREETNR,ZIP,CITY,STATE,COUNTRY,LATITUDE,LONGITUDE)
        VALUES(NULL,'$address','$numeroRue','$cp','$city','$province','$country','$lat','$lng')";
        if($dem=mysqli_query($connect, $insert_address_sql)){
            $address_id2  = mysqli_insert_id($connect);
            $dem2=mysqli_query($connect,"UPDATE COLLABORATOR SET ADDRESS_ID='$address_id2' WHERE COLLABORATOR_ID='$id'");
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
    }else{
       $message="Les champs Numéro de voie, Voie, etc, sont obligatoires !";
    }
}
//MODIF

if(isset($_POST["modCollaborator"])){
   
    $id=$_POST["id"];
    $address_id=$_POST["address_id"];
    $lname=mysqli_real_escape_string($connect,$_POST["last_name_col"]);
    $fname=mysqli_real_escape_string($connect,$_POST["first_name_col"]);
    $organization_unit_col = mysqli_real_escape_string($connect,$_POST["organization_unit_col"]);
    $app_admin = mysqli_real_escape_string($connect,$_POST["app_admin"]);
    if($app_admin == true){
    	$admin = 1;
    }
    else{
    	$admin = 0;
    }
    $schedule_id = mysqli_real_escape_string($connect,$_POST["schedule_id"]);
    $mail=mysqli_real_escape_string($connect,$_POST["mail_col"]);
    $avatar=$_FILES["avatar_col"]["tmp_name"];
    $imei=mysqli_real_escape_string($connect,$_POST["imei_col"]);
    $cost=$_POST["cost_col"];
	
    if(!empty($_POST["type_col"])){   
       $type_col=$_POST["type_col"];
    }else{
        $rqte=mysqli_query($connect,"SELECT COLLABORATOR_TYPE.COLLABORATOR_TYPE_ID FROM COLLABORATOR_TYPE JOIN COLLABORATOR ON COLLABORATOR_TYPE.COLLABORATOR_TYPE_ID=COLLABORATOR.COLLABORATOR_TYPE_ID AND COLLABORATOR.COLLABORATOR_ID='$id'");
         $data=$rqte->fetch_assoc();
         $type_col=$data["COLLABORATOR_TYPE_ID"];
    }
     if($type_col==1) {
      $resp_col=0;
    }else{
      $resp_col=$_POST["resp_col"];    
    }

    
    $tel=mysqli_real_escape_string($connect,$_POST["tel_col"]);
    $gender=$_POST["gender_col"];
    /*
    if($type_col==1){
      $admin=1;
    }else{
      $admin=0;
    }*/
    if(!empty($address_id)){
       $r2=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id'");
        $data=$r2->fetch_assoc();
        $numeroRue=$data["STREETNR"];
        $address=$data["STREET"];
        $province=$data["STATE"];
        $cp=$data["ZIP"];
        $city=$data["CITY"];
        $country=$data["COUNTRY"];
    }
    if(!empty($lname)&&!empty($fname)&&!empty($mail)&&!empty($imei)){

        if(!preg_match("#^[a-z0-9._-]+@(msn).[a-z]{2,4}$#", $mail)){
           if(!empty($_POST["pass_col1"])){
           	
              $pwd=mysqli_real_escape_string($connect,$_POST["pass_col1"]);
              $req=mysqli_query($connect,"UPDATE COLLABORATOR SET GENDER_ID='$gender',MANAGER_ID='$resp_col',COLLABORATOR_TYPE_ID='$type_col',LASTNAME='$lname',FIRSTNAME='$fname',EMAIL='$mail',PASSWORD='$pwd',MOBILENR='$tel',IMEI='$imei',COST='$cost',APP_ADMIN=$admin,ORGANIZATION_UNIT_ID='$organization_unit_col', SCHEDULE_ID='$schedule_id' WHERE COLLABORATOR_ID='$id'");
            }else{
            	$update_sql = "UPDATE COLLABORATOR SET GENDER_ID='$gender',MANAGER_ID='$resp_col',COLLABORATOR_TYPE_ID='$type_col',LASTNAME='$lname',FIRSTNAME='$fname',EMAIL='$mail',MOBILENR='$tel',IMEI='$imei',COST='$cost',APP_ADMIN=$admin, ORGANIZATION_UNIT_ID='$organization_unit_col', SCHEDULE_ID = '$schedule_id' WHERE COLLABORATOR_ID='$id'";
            	$req=mysqli_query($connect,$update_sql);
              $r=mysqli_query($connect,"DELETE FROM COLLABORATOR_ACTIVITY WHERE COLLABORATOR_ID='$id'");
              if(!empty($_POST["activite_id"])){
              foreach($_POST["activite_id"] as $val){
                $val=mysqli_real_escape_string($connect,$val);
                $reqAct=mysqli_query($connect,"INSERT INTO COLLABORATOR_ACTIVITY (COLLABORATOR_ID,ACTIVITY_ID)VALUES ('$id','$val')");
              }
              }
            }

            if(!empty($avatar) && is_uploaded_file($avatar)){
              list($largeur,$hauteur,$type,$attr) = getimagesize($avatar);
              if($type==2) $format="jpg";
              if($type==3) $format="png";
              $chemin="../images/".$prefixe."_avatar".$id.".".$format;
              $chemin2="https://m2.renelcloud.ch/images/".$prefixe."_avatar".$id.".".$format;
              $new_largeur =200;
              if($type == 2 OR $type == 3){  
                  if($largeur>$new_largeur){
                      if(move_uploaded_file($avatar,$chemin)){
                         $req=mysqli_query($connect,"UPDATE COLLABORATOR SET PICTURE_URL='$chemin2' WHERE COLLABORATOR_ID='$id'");
                           // telecharge($avatar,$largeur,$hauteur,$chemin,$new_largeur);
                            $message="Modifications bdd ok ! Insertion photo ok"; 
                      }
                    
                }else{
                  header("Location:EmployeeMod.php?error=3&id=$id");
                }
            }else{
               header("Location:EmployeeMod.php?error=2&id=$id");
        
            }
          }else{
                 $message="Modifications insérées, pas de modif de photo ";
            }
        }else{
           header("Location:EmployeeMod.php?error=1&id=$id");
        
        }

      }else{
        header("Location:EmployeeMod.php?error=0&id=$id");
      }
}

//INSERTION NOUVEAU COLL

if(isset($_POST["addCollaborator"])){
    $lname=mysqli_real_escape_string($connect,$_POST["last_name_col"]);
    $fname=mysqli_real_escape_string($connect,$_POST["first_name_col"]);
    $mail=mysqli_real_escape_string($connect,$_POST["mail_col"]);
    $avatar=$_FILES["avatar_col"]["tmp_name"];
    $imei=mysqli_real_escape_string($connect,$_POST["imei_col"]);
    $cost=$_POST["cost_col"];
    $organization_unit_col = mysqli_real_escape_string($connect,$_POST["organization_unit_col"]);
    $pwd=mysqli_real_escape_string($connect,$_POST["pass_col1"]);
    $type_col=$_POST["type_col"];
    if($type_col==1) {
      $resp_col=0;
    }else{
      $resp_col=$_POST["resp_col"];    
    }
 	$app_admin = mysqli_real_escape_string($connect,$_POST["app_admin"]);
 	$schedule_id = mysqli_real_escape_string($connect,$_POST["schedule_id"]);
    if($app_admin == true){
    	$admin = 1;
    }
    else{
    	$admin = 0;
    }


    $tel=mysqli_real_escape_string($connect,$_POST["tel_col"]);
    $gender=$_POST["gender_col"];
    /*if($type_col==1){
      $admin=1;
    }else{
      $admin=0;
    }*/
   
	
    if(!empty($lname)&&!empty($fname)&&!empty($mail)&&!empty($imei)&&!empty($_POST["activite_id"]) &&!empty($organization_unit_col)){
        if(!preg_match("#^[a-z0-9._-]+@(msn).[a-z]{2,4}$#", $mail)){
        	
         	$insert_sql = "INSERT INTO COLLABORATOR(COLLABORATOR_ID,GENDER_ID,MANAGER_ID,ADDRESS_ID,COLLABORATOR_TYPE_ID,LASTNAME,FIRSTNAME,
            EMAIL,PASSWORD,MOBILENR,IMEI,COST,APP_ADMIN,ORGANIZATION_UNIT_ID, SCHEDULE_ID) VALUES(NULL,'$gender','$resp_col','$address_id','$type_col','$lname','$fname','$mail','$pwd','$tel','$imei','$cost',$admin,$organization_unit_col, $schedule_id)";
            if($req=mysqli_query($connect,$insert_sql)){
               $id=mysqli_insert_id($connect);
               foreach($_POST["activite_id"] as $val){
                  $val=mysqli_real_escape_string($connect,$val);
                  $reqAct=mysqli_query($connect,"INSERT INTO COLLABORATOR_ACTIVITY (COLLABORATOR_ID,ACTIVITY_ID)VALUES ('$id','$val')");
                }
            //joket for organization_unit
            	if($type_col == 1) return $is_Manager ='Y';
            	else $is_Manager = 'N';
			                
                
                
                $message="Insertion du collaborateur effectuée ! ";

                
        
                if(!empty($avatar)&& is_uploaded_file($avatar)){
                    list($largeur,$hauteur,$type,$attr) = getimagesize($avatar);
                    if($type==2) $format="jpg";
                    if($type==3) $format="png";
                     $chemin="../images/".$prefixe."_avatar".$id.".".$format;
                      $chemin2="https://m2.renelcloud.ch/images/".$prefixe."_avatar".$id.".".$format;
                    $new_largeur =200;
                    if($type == 2 OR $type==3){  
                        if($largeur>$new_largeur){
                            if(move_uploaded_file($avatar,$chemin)){
                              $req=mysqli_query($connect,"UPDATE COLLABORATOR SET PICTURE_URL='$chemin2' WHERE COLLABORATOR_ID='$id'");
                              $message="Insertion du collaborateur effectuée ! ";
                            }
                        }else{
                           header("Location:EmployeeMod.php?error=3&id=$id");
                        }
                    }else{
                       header("Location:EmployeeMod.php?error=2&id=$id");
                    }
                 }else{
                        $message="Insertion du collaborateur effectuée !
                        <br/> Vous n'avez pas téléchargé de photo.";
                      }
            
             
             }else{
                $message="Problème à l'insertion des données !";
              }
             
          
       }else{
           header("Location:EmployeeMod.php?error=1&id=$id");
        
        }

      }else{
        header("Location:EmployeeMod.php?error=0&id=$id");
      }

 }

if(isset($_GET["id"])){
$id=$_GET["id"];}
   if(!empty($id)){
   $sql = "SELECT COLLABORATOR.COLLABORATOR_ID,COLLABORATOR.COLLABORATOR_TYPE_ID, COLLABORATOR.GENDER_ID, COLLABORATOR.MANAGER_ID,
							COLLABORATOR.ADDRESS_ID,
                    		COLLABORATOR_TYPE.NAME AS TYPE_NAME, COLLABORATOR.LASTNAME,
							COLLABORATOR.FIRSTNAME, COLLABORATOR.EMAIL, COLLABORATOR.PASSWORD, COLLABORATOR.MOBILENR, COLLABORATOR.IMEI, COLLABORATOR.IMEI_S,
							COLLABORATOR.UUID,
							COLLABORATOR.COST, COLLABORATOR.PICTURE_URL,COLLABORATOR.APP_ADMIN, COLLABORATOR.SCHEDULE_ID,SCHEDULE.NAME AS SCHEDULE_NAME, ORGANIZATION_UNIT.NAME AS ORGANIZATION_NAME,
							COLLABORATOR.ORGANIZATION_UNIT_ID,concat(ADDRESS.STREET, ' ', ADDRESS.STREETNR) AS STREET_NAME, concat(ADDRESS.CITY, ' ', 
							ADDRESS.STATE) AS CITY_NAME, ADDRESS.ZIP AS ZIP_CODE, ADDRESS.COUNTRY AS COUNTRY
					         FROM COLLABORATOR 
					        LEFT JOIN COLLABORATOR_TYPE ON COLLABORATOR_TYPE.COLLABORATOR_TYPE_ID = COLLABORATOR.COLLABORATOR_TYPE_ID
					        LEFT JOIN ORGANIZATION_UNIT_COLLABORATOR ON COLLABORATOR.COLLABORATOR_ID = ORGANIZATION_UNIT_COLLABORATOR.COLLABORATOR_ID
					        LEFT JOIN ORGANIZATION_UNIT ON ORGANIZATION_UNIT.ORGANIZATION_UNIT_ID = ORGANIZATION_UNIT_COLLABORATOR.ORGANIZATION_UNIT_ID
					        LEFT JOIN SCHEDULE ON SCHEDULE.SCHEDULE_ID = COLLABORATOR.SCHEDULE_ID
					        LEFT JOIN ADDRESS ON ADDRESS.ADDRESS_ID = COLLABORATOR. ADDRESS_ID
					        WHERE COLLABORATOR.COLLABORATOR_ID = ".$id;
                    
	$dem=mysqli_query($connect,$sql); 
	$data=$dem->fetch_assoc();
    $fname=$data["FIRSTNAME"];
    $lname=$data["LASTNAME"];
    $gender=$data["GENDER_ID"];
    $type_col=$data["COLLABORATOR_TYPE_ID"];
    $resp_col=$data["MANAGER_ID"];
    $mail=$data["EMAIL"];
    $imei=$data["IMEI"];
    $address_id=$data["ADDRESS_ID"];
    $tel=$data["MOBILENR"];
    $schedule_name = $data['SCHEDULE_NAME'];
    $organization_name = $data['ORGANIZATION_NAME'];
    $app_admin = $data['APP_ADMIN'];
   // $id=$_POST["COLLABORATOR_ID"];
    if(!empty($address_id)){
       $r2=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id'");
        $data=$r2->fetch_assoc();
        $numeroRue=$data["STREETNR"];
        $address=$data["STREET"];
        $province=$data["STATE"];
        $cp=$data["ZIP"];
        $city=$data["CITY"];
        $country=$data["COUNTRY"];
    }
   


if($gender==1) $gender="Homme";
if($gender==2) $gender="Femme";
   }
?>

<hr class="style_one"/>
      <section id='content'>
        <div class='container'>
          
          <div class='row'> 
            <div class='col-sm-12'>
              <div class='box'>
                <div class='box-header red-background'>
                  <div class='title'><p>Collaborateur : <?php echo $lname." ".$fname; ?>
                    <?php
                    if(empty($address_id2) AND empty($address_id)){
                      echo " Vous devez remplir le formulaire d'adresse avant de continuer !</p>";
                    }else{
                      echo "</p><a class=\"btn btn-danger btn-lg\" style=\"float:right;\" href=\"EmployeeList.php\" title=\"Retour au tableau des collaborateurs\">Retour au tableau</a>";
                    }
                    ?>
                      <hr class="style_two"/>
                  </div>
                 </div>
                    <div class='box-content'>
                       <?php
                          if(isset($_POST["confirmAddress"])OR isset($_POST["addCollaborator"])OR isset($_POST["modCollaborator"])){
                          
                             echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                             echo "<p>".$message."</p>";

                             echo "<hr class=\"style_two\"/></div>";
                          
                           }
                         ?>

                       <div class='col-sm-12' >

                        <hr class="style_one"/>
                          <div class='col-sm-2' >
                             <?php 
                               if(is_file("../images/".$prefixe."_avatar".$id.".jpg")){
                                echo "<img class=\"img-responsive avatar\" src=\"../images/".$prefixe."_avatar".$id.".jpg\">";
                              }elseif(is_file("../images/".$prefixe."_avatar".$id.".png")){
                                 echo "<img class=\"img-responsive avatar\" src=\"../images/".$prefixe."_avatar".$id.".png\">";
                              }else{
                                echo "<img class=\"img-responsive avatar\" src=\"../images/".$prefixe."_user.png\">";
                              }
                        
                            ?>
                         
                          
                          </div>
                          <div class='col-sm-10' >
                            <div class='col-sm-3' >
                                <h3><?php echo $fname ;?>&nbsp;<?php echo $lname ;?></h3>
                                <p>Genre : <?php echo $gender ;?></p>
                                <p>Type :
                                <?php 
                                $demande=mysqli_query($connect,"SELECT * FROM COLLABORATOR_TYPE WHERE COLLABORATOR_TYPE_ID='$type_col'");
                                $data=$demande->fetch_assoc();
                                echo $data["NAME"];
                                ?>
                                </p>
                                <p>Activités : 
                                  <?php 
                                $demande=mysqli_query($connect,"SELECT * FROM COLLABORATOR_ACTIVITY WHERE COLLABORATOR_ID='$id'");
                                while($data=$demande->fetch_assoc()){
                                  $activiteBdd=$data["ACTIVITY_ID"];
                                  $demande2=mysqli_query($connect,"SELECT * FROM ACTIVITY WHERE ACTIVITY_ID='$activiteBdd'");
                                  $data=$demande2->fetch_assoc();
                                  echo "<p>".$data["NAME"]."</p>";

                                }
                              
                                if($resp_col!=0){
                                  echo "<p>Responsable : ";
                                   $demande=mysqli_query($connect,"SELECT FIRSTNAME,LASTNAME FROM COLLABORATOR WHERE COLLABORATOR_ID='$resp_col'");
                                  $data=$demande->fetch_assoc();
                                  echo $data["FIRSTNAME"]." ".$data["LASTNAME"];
                                  echo "</p>";
                                }
                                ?>
                               
                           </div>
                            <div class='col-sm-3' >
                                
                             
                               <?php
                        
                                  echo "<h3>Adresse : </h3><p>".$address.", ".$numeroRue."<br/>".$city.", ".$province."<br/>".$cp."<br/>".$country."</p>";
                              
                              
                              ?>
                             </div>
                             <div class='col-sm-3' >
                              <h3>Conctater : </h3>
                              <p>Tel : <a href="mailto:<?php echo $tel ;?>" title="Ecrire un mail à ce collaborateur"><?php echo $tel ;?></a></p>
                              <p>Email : <a href="mailto:<?php echo $mail ;?>" title="Ecrire un mail à ce collaborateur"><?php echo $mail ;?></a></p>
                              <p>IMEI : <?php echo $imei ;?></p>
                            </div>
                            <div class='col-sm-3' >
                              <h3>More Information :</h3>
                              <p>Schedule : <?php echo $schedule_name;?></p>
                              <p>APP Admin : <?php if($app_admin == 1) echo "YES"; else echo "NO"; ?></p>
                              <p>Organization : <?php echo $organization_name ;?></p>
                            </div>
                           <hr class="style_one"/>
                            
                              </div>
                              <hr class="style_one"/>
                        

                             
                              </div>
                          <hr class="style_two"/>
                      <div class="col-sm-12">
                        <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6" >
                            <?php
                            if(empty($address_id)){
                                   echo "<a style=\"float:right;\" id=\"addAddress\" href=\"#displayAddress\" class=\"btn btn-danger btn-lg\">Ajouter une adresse</a>&nbsp;&nbsp";
                            }else{
                                   echo "<a style=\"float:left;\" id=\"addAddress\" href=\"#displayAddress\" class=\"btn btn-danger btn-lg\">Modifier cette adresse</a>&nbsp;&nbsp";
                                   echo "<a style=\"float:right;\" href=\"EmployeeMod.php?id_mod=$id\" class=\"btn btn-danger btn-lg\">Modifier </a>";

                            }

                            ?>
                               
                            </div>
                            <hr class="style_two"/>
                        </div>

                 
                       <hr class="style_one"/>

  <!--ADRESSE-->
          <div class="col-sm-12" id="displayAddress">
             <form class="form" style="margin-bottom: 0;" method="post" action="#" enctype="multipart/form-data">   
                <?php
               if(!empty($address_id2)){
                  echo "<input id=\"address_id\" name=\"address_id\" value=\"".$address_id2."\" type=\"hidden\">";
               }else
               if(!empty($address_id)){
                  echo "<input id=\"address_id\" name=\"address_id\" value=\"".$address_id."\" type=\"hidden\">";
               }
                  echo "<input id=\"collaborator_id\" name=\"collaborator_id\" value=\"".$id."\" type=\"hidden\">";
        
                  ?>
             
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
                      <label for='lat'>Latitude</label>
                      <input class="form-control" id="lng" name="lng" readonly>
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
                    <hr class="style_two"/>
                  </div>
                    <hr class="style_two"/>
                 </div> 

                 </form>
                  </div>
                        <hr class="style_two"/>
                  </div>

                </div>
              </div>
            </div>
          </div>
         </div>
      </section>
    </div>
        <hr class="style_one"/>
             </div>
    <!-- / jquery [required] -->
   
   
  

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
