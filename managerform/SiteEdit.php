<?php include("header.php");
    if(isset($_GET["id"])){
        $site_id=$_GET["id"];
        $req=mysqli_query($connect,"SELECT * FROM SITE WHERE SITE_ID='$site_id'");
        $data=$req->fetch_assoc();
        $customer_id=$data["CUSTOMER_ID"];
        $address_id=$data["ADDRESS_ID"];
        $site_name=$data["NAME"];
        $desc_site=$data["DESCRIPTION"];
   }


if(isset($_POST["addSite"])){
    $numeroRue=$_POST["street_number"];
    $address=mysqli_real_escape_string($connect,$_POST["route"]);
    $cp=mysqli_real_escape_string($connect,$_POST["postal_code"]);
    $city=mysqli_real_escape_string($connect,$_POST["locality"]);
    $province=mysqli_real_escape_string($connect,$_POST["administrative_area_level_1"]);
    $country=mysqli_real_escape_string($connect,$_POST["country"]);
    $lng=$_POST["lng"];
    $lat=$_POST["lat"];

    $customer_id=$_POST["customer_id"];
    $site_name=mysqli_real_escape_string($connect,$_POST["site_name"]);
    $desc_site=mysqli_real_escape_string($connect,$_POST["desc_site"]);

  if(!empty($numeroRue)&&!empty($customer_id)){
    if($req2=mysqli_query($connect,"INSERT INTO SITE (SITE_ID,CUSTOMER_ID,NAME,DESCRIPTION) VALUES(NULL,'$customer_id','$site_name','$desc_site')")){
      $site_id=mysqli_insert_id($connect);
      $dem=mysqli_query($connect,"INSERT INTO ADDRESS (ADDRESS_ID,STREET,STREETNR,ZIP,CITY,STATE,COUNTRY,LATITUDE,LONGITUDE)VALUES(NULL,'$address','$numeroRue','$cp','$city','$province','$country','$lat','$lng')");
      $dernier_address_id=mysqli_insert_id($connect);
      $reqAdd=mysqli_query($connect,"UPDATE SITE SET ADDRESS_ID='$dernier_address_id' WHERE SITE_ID='$site_id'");

      $req3=mysqli_query($connect,"INSERT INTO SITE_CONTACT (SITE_ID,CONTACT_ID) VALUES('$site_id','$customer_id')");
      $message="Enregistrement du site effectué";
    }else{
       $message="Problème à l'insertion des données !";
    }
  }else{
       $message="Tous les champs sont obligatoires !";
    }
  $address_id=$dernier_address_id;

}
if(isset($_POST["modSite"])){
  $site_id=$_POST["site_id"];
  $customer_id=$_POST["customer_id"];
  $site_name=mysqli_real_escape_string($connect,$_POST["site_name"]);
  $desc_site=mysqli_real_escape_string($connect,$_POST["desc_site"]);
  $address_id=$_POST["address_id"];
  $numeroRue=$_POST["street_number"];
  $address=mysqli_real_escape_string($connect,$_POST["route"]);
  $cp=mysqli_real_escape_string($connect,$_POST["postal_code"]);
  $city=mysqli_real_escape_string($connect,$_POST["locality"]);
  $province=mysqli_real_escape_string($connect,$_POST["administrative_area_level_1"]);
  $country=mysqli_real_escape_string($connect,$_POST["country"]);
  $lng=$_POST["lng"];
  $lat=$_POST["lat"];

  if(!empty($site_name)&&!empty($numeroRue)){

    if($req2=mysqli_query($connect,"UPDATE SITE SET NAME='$site_name',DESCRIPTION='$desc_site' WHERE SITE_ID='$site_id'")){
      $dem=mysqli_query($connect,"UPDATE ADDRESS SET STREET='$address', STREETNR='$numeroRue',ZIP='$cp', CITY='$city',STATE='$province',COUNTRY='$country',LATITUDE='$lat',LONGITUDE='$lng' WHERE ADDRESS_ID='$address_id'");
      $message="Modifications effectuées.";
    }else{
       $message="Problème à l'insertion des données !";
    }
  }else{
     $message="Tous les champs sont obligatoires !";
  }
  

}

        $req1=mysqli_query($connect,"SELECT * FROM CUSTOMER WHERE CUSTOMER_ID=$customer_id");
        $data1=$req1->fetch_assoc();
        $contact=$data1["CONTACTNAME"];
        $mail=$data1["EMAIL"];
        $mobile=$data1["MOBILENR"];
        $phone=$data1["PHONENR"];
        $name=$data1["NAME"];
 


        $req2=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id'");
        $data2=$req2->fetch_assoc();
        $numeroRue=$data2["STREETNR"];
        $address=$data2["STREET"];
        $cp=$data2["ZIP"];
        $city=$data2["CITY"];
        $province=$data2["STATE"];
        $country=$data2["COUNTRY"];

     ?>
    <hr class="style_one"/>
      <section id='content'>
        <div class='container'>
          <div class='row'>
            <div class='col-sm-12'>
              <div class='box'>
                <div class='box-header red-background'>
                  <div class='title'><p>Site : <?php echo $site_name; ?></p>
                      <a class="btn btn-danger btn-lg" style="float:right;" href="SiteList.php" title="Retour au tableau des sites">Retour au tableau</a>
                      <hr class="style_two"/>
                  </div>
                 </div>
                    <div class='box-content'>
                       <?php
                          if(isset($_POST["addSite"])OR isset($_POST["ModSite"])){
                          
                             echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                             echo "<p>".$message."</p>";

                             echo "<hr class=\"style_two\"/></div>";

                           }
                         ?>

                       <div class='col-sm-12' >

                        <hr class="style_one"/>
                          
                              <div class='col-sm-12' >
                                 <h2>Site <?php echo $site_name ;?></h2>
                            </div>
                            <div class='col-sm-6' >
                              <h3>Client : <?php echo $name;?></h3>
                              <p>Contact : <?php echo $contact ;?></p>
                            
                             </div>
                             <div class='col-sm-6' >
                              <p>Email : <a href="mailto:<?php echo $mail ;?>" title="Ecrire un mail"><?php echo $mail ;?></a></p>
                              <p>Portable : <a href="telto:<?php echo $mobile ;?>" title="Téléphoner"><?php echo $mobile ;?></a></p>
                              <p>Téléphone : <a href="telto:<?php echo $phone ;?>" title="Téléphoner"><?php echo $phone ;?></a></p>
                            </div>
                             <hr class="style_one"/>
                              

                              <div class='col-sm-6' >
                                <p>Description : <?php echo $desc_site ;?></p>

                             </div>
                             

                             

                              <?php
                              echo "<div class='col-sm-6' >";
                              echo "<h3>Adresse du site :</h3>
                                        <p>Numéro de voie : ".$numeroRue."</p>
                                        <p>Voie : ".$address."</p>
                                        <p>Ville : ".$city."</p>
                                        <p>Province : ".$province."</p>
                                        <p>Pays : ".$country."</p>";
                                  
                                echo  "</div><hr class=\"style_one\"/>";
                              ?>
                              </div>
                          <hr class="style_two"/>
                        <div class="col-sm-12">
                        <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6" >
                            <?php
                              echo "<a style=\"float:right;\" href=\"SiteMod.php?id_mod=$site_id\" class=\"btn btn-danger btn-lg\">Modifier </a>";


                            ?>
                               
                            </div>
                            <hr class="style_two"/>
                        </div>

                      </div>
                       <hr class="style_one"/>

             
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

//DISPLAY CHOISIR UN RESPONSABLE 
 $(document).ready(function(){
   $("#type_col").change(function () {
         if($("#type_col option:selected").val()==1) {
            $("#responsable").css("display","block");
        }else{
            $("#responsable").css("display","none");
        }
    });
 });

</script>
</body>
</html>
