
    <?php include("header.php");
 if(isset($_GET["id"])){
    $customer_id=$_GET["id"];
    $req=mysqli_query($connect,"SELECT * FROM CUSTOMER WHERE CUSTOMER_ID='$customer_id'");
      $data=$req->fetch_assoc();
      $customer_id=$data["CUSTOMER_ID"];
      $name=$data["NAME"];
      $desc=$data["DESCRIPTION"];
      $phone=$data["PHONENR"];
      $mobile=$data["MOBILENR"];
      $contact=$data["CONTACTNAME"];
      $mail=$data["EMAIL"];
      $url=$data["WEBSITE"];
      $address_id=$data["ADDRESS_ID"];
   if(!empty($address_id)){
     $req2=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id'");
      $data=$req2->fetch_assoc();
      $numeroRue=$data["STREETNR"];
      $address=$data["STREET"];
      $cp=$data["ZIP"];
      $city=$data["CITY"];
      $province=$data["STATE"];
      $country=$data["COUNTRY"];
   }
 }



 
if(isset($_POST["confirmAddress"])){
    $customer_id=$_POST["customer_id"];
    $address_id=$_POST["address_id"];
    $numeroRue=$_POST["street_number"];
    $address=mysqli_real_escape_string($connect,$_POST["route"]);
    $cp=mysqli_real_escape_string($connect,$_POST["postal_code"]);
    $city=mysqli_real_escape_string($connect,$_POST["locality"]);
    $province=mysqli_real_escape_string($connect,$_POST["administrative_area_level_1"]);
    $country=mysqli_real_escape_string($connect,$_POST["country"]);
    $lng=$_POST["lng"];
    $lat=$_POST["lat"];
    $reqCus=mysqli_query($connect,"SELECT * FROM CUSTOMER WHERE CUSTOMER_ID='$customer_id'");
    $data=$reqCus->fetch_assoc();
    $name=$data["NAME"];
    $desc=$data["DESCRIPTION"];
    $phone=$data["PHONENR"];
    $mobile=$data["MOBILENR"];
    $contact=$data["CONTACTNAME"];
    $mail=$data["EMAIL"];
    $url=$data["WEBSITE"];

    if(!empty($numeroRue)){
       if(!preg_match("#^[a-z0-9._-]+@(msn).[a-z]{2,4}$#", $mail)){
        if(empty($address_id)){
          if($dem=mysqli_query($connect,"INSERT INTO ADDRESS (ADDRESS_ID,STREET,STREETNR,ZIP,CITY,STATE,COUNTRY,LATITUDE,LONGITUDE)VALUES(NULL,'$address','$numeroRue','$cp','$city','$province','$country','$lat','$lng')")){
              $message="Enregistrement de l'adresse effectuée !";// address id".$address_id.",id : ".$id
              $address_id = mysqli_insert_id($connect);
              $dem2=mysqli_query($connect,"UPDATE CUSTOMER SET ADDRESS_ID='$address_id' WHERE CUSTOMER_ID='$customer_id'");
             
           }
        }else{
         if($dem=mysqli_query($connect,"UPDATE ADDRESS SET STREET='$address', STREETNR='$numeroRue',ZIP='$cp', CITY='$city',STATE='$province',COUNTRY='$country',LATITUDE='$lat',LONGITUDE='$lng' WHERE ADDRESS_ID='$address_id'")){
              $message="Modification de l'adresse effectuée ! "; 
              
            }
        }
      }else{
         $message="L'adresse mail doit contenir un @";
      }
    }else{
       $message="Les champs Numéro de voie, Voie, etc, sont obligatoires !";
    }
   
}


if(isset($_POST["addCustomer"])){
    $activiteId=array();
    $name=mysqli_real_escape_string($connect,$_POST["name_cus"]);
    $mail=mysqli_real_escape_string($connect,$_POST["mail_cus"]);
    $phone=mysqli_real_escape_string($connect,$_POST["tel_cus"]);
    $mobile=mysqli_real_escape_string($connect,$_POST["mob_cus"]);
    $desc=mysqli_real_escape_string($connect,$_POST["desc_cus"]);
    $url=mysqli_real_escape_string($connect,$_POST["url_cus"]);
    $contact=mysqli_real_escape_string($connect,$_POST["contact_cus"]);
    if(strstr($url,"http://")){
      if(!empty($name)&&!empty($mail)&&!empty($contact)){
        if(!preg_match("#^[a-z0-9._-]+@(msn).[a-z]{2,4}$#", $mail)){
          if($req=mysqli_query($connect,"INSERT INTO CUSTOMER (CUSTOMER_ID,NAME,DESCRIPTION,CONTACTNAME,PHONENR,MOBILENR,EMAIL,WEBSITE)VALUES(NULL,'$name','$desc','$contact','$phone','$mobile','$mail','$url')")){
            $customer_id_insert=mysqli_insert_id($connect);
            for($i=0;$i<50;$i++){
              if(!empty($_POST["activite_id".$i])){
                $activite=mysqli_real_escape_string($connect,$_POST["activite_id".$i]);
                $description=mysqli_real_escape_string($connect,$_POST["desc_id".$i]);
                $demAct=mysqli_query($connect,"INSERT INTO ACTIVITY (ACTIVITY_ID,NAME,DESCRIPTION) VALUES(NULL,'$activite','$description')");
                $id_act=mysqli_insert_id($connect);
                array_push($activiteId,$id_act);
              }
            }
            $message="Insertion du client effectuée !";
          }else{
            $message="Problème lors de l'insertion : veuillez recommencer !";
          }


        }else{
          header("Location:CustomerAdd.php?error=2");
        }
      }else{
          header("Location:CustomerAdd.php?error=1");
        }
    }else{
          header("Location:CustomerAdd.php?error=0");
       
      }
    
  }

 if(isset($_POST["modCustomer"])){
    $customer_id=$_POST["customer_id"];
    $address_id=$_POST["address_id"];
    $name=mysqli_real_escape_string($connect,$_POST["name_cus"]);
    $mail=mysqli_real_escape_string($connect,$_POST["mail_cus"]);
    $phone=mysqli_real_escape_string($connect,$_POST["tel_cus"]);
    $mobile=mysqli_real_escape_string($connect,$_POST["mob_cus"]);
    $desc=mysqli_real_escape_string($connect,$_POST["desc_cus"]);
    $url=mysqli_real_escape_string($connect,$_POST["url_cus"]);
    $contact=mysqli_real_escape_string($connect,$_POST["contact_cus"]);
    $req2=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id'");
    $data=$req2->fetch_assoc();
    $numeroRue=$data["STREETNR"];
    $address=$data["STREET"];
    $cp=$data["ZIP"];
    $city=$data["CITY"];
    $province=$data["STATE"];
    $country=$data["COUNTRY"];
    if(strstr($url,"http://")){

      if(!preg_match("#^[a-z0-9._-]+@(msn).[a-z]{2,4}$#", $mail)){
        if($req=mysqli_query($connect,"UPDATE CUSTOMER SET ADDRESS_ID='$address_id',NAME='$name',DESCRIPTION='$desc',CONTACTNAME='$contact',PHONENR='$phone',MOBILENR='$mobile',EMAIL='$mail',WEBSITE='$url' WHERE CUSTOMER_ID='$customer_id'")){
              $message="Modifications effectuées ! "; 
        }else{
             header("Location:CustomerMod.php?error=2");
        }
                    
      }else{
        header("Location:CustomerMod.php?error=1");
      }
    }else{
        header("Location:CustomerMod.php?error=0");
    }

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
                    <?php echo "Client : ".$name; 
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
                          if(isset($_POST["confirmAddress"])OR isset($_POST["addCustomer"])OR isset($_POST["modCustomer"])){
                          
                             echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                             echo "<p>".$message."</p>";

                             echo "<hr class=\"style_two\"/></div>";
                           }
                         ?>

                       <div class='col-sm-12' >

                        <hr class="style_one"/>
                    
                          <div class='col-sm-12' >
                                 <h2><?php echo $name ;?></h2>
                                  <p><?php echo $desc ;?></p>
                                  <p><a href="<?php echo $url ;?>" title="Site du client <?php echo $name ;?>" target="_blank"><?php echo $url ;?></a></p>
                            </div>
                              <?php
                              echo "<div class='col-sm-4' >";
                                  if($address_id!=0){
                                    echo "<p>".$address.", ".$numeroRue."<br/>".$city."<br/>".$province."<br/>".$cp."<br/>".$country."</p>";
                                  }else{
                                     echo "<p>L'adresse n'est pas encore enregistrée !</p>";
                                  }


                               

                              
                                echo  "</div><hr class=\"style_one\"/>";
                               
                              ?>
                            <div class='col-sm-4' >
                              <h3><?php echo $contact ;?></h3>
                            
                              <p>Email : <a href="mailto:<?php echo $mail;?>" title="Ecrire un mail"><?php echo $mail ;?></a></p>
                              <p>Portable : <a href="telto:<?php echo $mobile ;?>" title="Téléphoner"><?php echo $mobile ;?></a></p>
                              <p>Téléphone : <?php echo $phone ;?></p>
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
                                   if(!empty($customer_id)){
                                      echo "<a style=\"float:right;\" href=\"CustomerMod.php?id_mod=$customer_id\" class=\"btn btn-danger btn-lg\">Modifier </a>";
                                   }else{
                                      echo "<a style=\"float:right;\" href=\"CustomerMod.php?id_mod=$customer_id_insert\" class=\"btn btn-danger btn-lg\">Modifier </a>";

                                   }

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
                <?php
               
               if(!empty($address_id)){
                  echo "<input id=\"address_id\" name=\"address_id\" value=\"".$address_id."\" type=\"hidden\">";
               }
               if(!empty($customer_id_insert)){
                  echo "<input id=\"customer_id\" name=\"customer_id\" value=\"".$customer_id_insert."\" type=\"hidden\">";
                }else{
                  echo "<input id=\"customer_id\" name=\"customer_id\" value=\"".$customer_id."\" type=\"hidden\">";
                }
        
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
