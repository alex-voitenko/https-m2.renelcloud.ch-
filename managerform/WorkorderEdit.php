<?php include("header.php");
$tab_activity_id=array();
$tab_coll_id=array();

 if(isset($_GET["id"])){
    $wo_id=$_GET["id"];
    $req=mysqli_query($connect,"SELECT * FROM WORKORDER WHERE WORKORDER_ID='$wo_id'");
    $data=$req->fetch_assoc();
    $act_name=$data["NAME"];
    $description=$data["DESCRIPTION"];
    $site_id=$data["SITE_ID"];
    $date_debut=$data["STARTDATE"];
    $date_fin=$data["ENDDATE"];
    $status_id=$data["WORKORDER_STATUS_ID"];
    $dem1=mysqli_query($connect,"SELECT * FROM WORKORDER_STATUS WHERE WORKORDER_STATUS_ID='$status_id'");
    $data=$dem1->fetch_assoc();
    $status_name=$data["NAME"];
    $dem=mysqli_query($connect,"SELECT * FROM SITE WHERE SITE_ID='$site_id'");
    $data=$dem->fetch_assoc();
    $site_name=$data["NAME"];
    $address_id=$data["ADDRESS_ID"];
    $dem2=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id'");
    $data=$dem2->fetch_assoc();
    $num=$data["STREETNR"];
    $street=$data["STREET"];
    $city=$data["CITY"];
    $cp=$data["ZIP"];
    $state=$data["STATE"];
    $country=$data["COUNTRY"];

   
 }

if(isset($_POST["woAdd"])){
  $act_name=mysqli_real_escape_string($connect,$_POST["act_name"]);
  $customer_id=$_POST["customer_id"];
  $contact;
  $coord_contact;
  $site_id=$_POST["site_id"];
  $dem=mysqli_query($connect,"SELECT * FROM SITE WHERE SITE_ID='$site_id'");
  $data=$dem->fetch_assoc();
  $site_name=$data["NAME"];
  $address_id=$data["ADDRESS_ID"];
  $demad=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id'");
  $data=$demad->fetch_assoc();
  $num=$data["STREETNR"];
    $street=$data["STREET"];
    $city=$data["CITY"];
    $cp=$data["ZIP"];
    $state=$data["STATE"];
    $country=$data["COUNTRY"];
  
  $description=mysqli_real_escape_string($connect,$_POST["desc_activity"]);
  $date_debut=$_POST["date_debut"];
  $date_fin=$_POST["date_fin"];
  $collaborator_id=$_POST["coll_wo"];
  $state_id=$_POST["state_wo"];
  $reqStatus=mysqli_query($connect,"SELECT * FROM WORKORDER_STATUS WHERE WORKORDER_STATUS_ID='$state_id'");
  $data=$reqStatus->fetch_assoc();
  $status_name=$data["NAME"];
  //joket for workorder-ref
  $workorder_ref = $_POST['workorder_ref'];
  if(!empty($customer_id)&& !empty($state_id)&& !empty($act_name)&& !empty($site_id) && isset($workorder_ref)){
    $message="Insertion de la mission effectuée ! ";

    $req=mysqli_query($connect,"INSERT INTO WORKORDER (WORKORDER_ID,SITE_ID,WORKORDER_STATUS_ID,NAME,DESCRIPTION,STARTDATE,ENDDATE) VALUES(NULL,'$site_id','$state_id','$workorder_ref','$act_name','$description','$date_debut','$date_fin')");
    $wo_id=mysqli_insert_id($connect);


    $reqNbAct=mysqli_query($connect,"SELECT * FROM ACTIVITY");
    while($data=$reqNbAct->fetch_assoc()){
       $id=$data["ACTIVITY_ID"];
      

       foreach($_POST["activite".$id] as $val){
        if(!empty($val)){         
          $reqAct=mysqli_query($connect,"INSERT INTO WORKORDER_COLLABORATOR (WORKORDER_ID,COLLABORATOR_ID)VALUES ('$wo_id','$val')");
          $reqAct2=mysqli_query($connect,"INSERT INTO WORKORDER_ACTIVITY (WORKORDER_ID,ACTIVITY_ID)VALUES ('$wo_id','$id')");

        }
      }
    }
  }else{
      header("Location:WorkorderAdd.php?error=1&id=$id");
  }
}
  if(isset($_POST["woMod"])){
  	
    $wo_id=$_POST["wo_id"];

    $act_name=mysqli_real_escape_string($connect,$_POST["act_name"]);
    $customer_id=$_POST["customer_id"];

    $site_id=$_POST["site_id"];
     $dem=mysqli_query($connect,"SELECT * FROM SITE WHERE SITE_ID='$site_id'");
    $data=$dem->fetch_assoc();
    $site_name=$data["NAME"];

    $address_id=$_POST["wo_address_id"];
    $dem2=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID='$address_id'");
    $data=$dem2->fetch_assoc();
    $num=$data["STREETNR"];
    $street=$data["STREET"];
    $city=$data["CITY"];
    $cp=$data["ZIP"];
    $state=$data["STATE"];
    $country=$data["COUNTRY"];
   
    
    
    //$description=mysqli_real_escape_string($connect,$_POST["desc_activity"]);
    $date_debut=$_POST["date_debut"];
    $date_fin=$_POST["date_fin"];
  
    $state_id=$_POST["state_wo"];
    $reqStatus=mysqli_query($connect,"SELECT * FROM WORKORDER_STATUS WHERE WORKORDER_STATUS_ID='$state_id'");
    $data=$reqStatus->fetch_assoc();
    $status_name=$data["NAME"];
	
    //joket for workorder-ref
    $workorder_ref = $_POST['workorder_ref'];
   
    if(!empty($customer_id)&& !empty($state_id)&& !empty($act_name)&& !empty($site_id) && !empty($workorder_ref)){
    	//print "joket".$workorder_ref;
    	$message = "Modification de la mission effectuée!";
        if(!empty($date_debut) AND !empty($date_fin)){
        	print "joket1".$workorder_ref;
           $req=mysqli_query($connect,"UPDATE WORKORDER SET SITE_ID='$site_id',WORKORDER_STATUS_ID='$state_id',NAME='$act_name',DESCRIPTION='',STARTDATE='$date_debut',ENDDATE='$date_fin', WORKORDER_REF = '$workorder_ref' WHERE WORKORDER_ID='$wo_id'");
        }elseif(empty($date_debut) AND !empty($date_fin)){
           print "joket2".$workorder_ref;
        	$req=mysqli_query($connect,"UPDATE WORKORDER SET SITE_ID='$site_id',WORKORDER_STATUS_ID='$state_id',NAME='$act_name',DESCRIPTION='',ENDDATE='$date_fin', WORKORDER_REF = '$workorder_ref' WHERE WORKORDER_ID='$wo_id'");

        }elseif(!empty($date_debut) AND empty($date_fin)){
           
        	print "joket3".$workorder_ref;
        	$req=mysqli_query($connect,"UPDATE WORKORDER SET SITE_ID='$site_id',WORKORDER_STATUS_ID='$state_id',NAME='$act_name',DESCRIPTION='',STARTDATE='$date_debut' , WORKORDER_REF = '$workorder_ref' WHERE WORKORDER_ID='$wo_id'");

        }else{
        	print "joket4"."UPDATE WORKORDER SET SITE_ID='$site_id',WORKORDER_STATUS_ID='$state_id',NAME='$act_name',DESCRIPTION='' WHERE WORKORDER_ID='$wo_id', WORKORDER_REF = '$workorder_ref'";
           $req=mysqli_query($connect,"UPDATE WORKORDER SET SITE_ID='$site_id',WORKORDER_STATUS_ID='$state_id',NAME='$act_name',DESCRIPTION='', WORKORDER_REF = '$workorder_ref' WHERE WORKORDER_ID='$wo_id'");
        }
     
   
      $tab_id=array();
      $tab_name=array();
      $reqAct=mysqli_query($connect,"SELECT * FROM ACTIVITY");

      while($data=$reqAct->fetch_assoc()){
        $id=$data["ACTIVITY_ID"];
        foreach($_POST["activite".$id] as $val){
            if(!empty($val)){      
                array_push($tab_id,$id);
                array_push($tab_name,$val);
                $req=mysqli_query($connect,"DELETE FROM WORKORDER_COLLABORATOR WHERE WORKORDER_ID = '$wo_id'");
                $req2=mysqli_query($connect,"DELETE FROM WORKORDER_ACTIVITY WHERE WORKORDER_ID = '$wo_id'");
             
            }
         }   

       
      }
      if(!empty($tab_id)){
          foreach($tab_name as $val){
              $reqAct1=mysqli_query($connect,"INSERT INTO WORKORDER_COLLABORATOR (WORKORDER_ID,COLLABORATOR_ID)VALUES ('$wo_id','$val')");
          }
          foreach($tab_id as $val){
              $reqAct2=mysqli_query($connect,"INSERT INTO WORKORDER_ACTIVITY (WORKORDER_ID,ACTIVITY_ID)VALUES ('$wo_id','$val')");
          }
      }
     
    }else{
        header("Location:WorkorderAdd.php?error=1&id=$wo_id");
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
                  <div class='title'><p>Mission : <?php echo $act_name; ?></p>
                      <a class="btn btn-danger btn-lg" style="float:right;" href="WorkorderList.php" title="Retour au tableau des missions">Retour au tableau</a>
                      <hr class="style_two"/>
                  </div>
                 </div>
                    <div class='box-content'>
                       <?php
                          if(isset($_POST["woAdd"])OR isset($_POST["woMod"])){
                          
                             echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                             echo "<p>".$message."</p>";

                             echo "<hr class=\"style_two\"/></div>";

                           }
                         ?>

                       <div class='col-sm-12' >
                          <div class='col-sm-12' >
                             <h2>Chantier : <?php echo $site_name ;?></h2>
                                 <p><?php echo $num." ".$street." ".$city." ".$state." ".$cp." ".$country ;?></p>
                                 
                          </div>

                         <div class='col-sm-4' >
                             <?php
                             $reqSite=mysqli_query($connect,"SELECT * FROM SITE WHERE SITE_ID='$site_id'");
                             $data=$reqSite->fetch_assoc();
                             $customer_id=$data["CUSTOMER_ID"];
                             $site_name=$data["NAME"];
                             $req=mysqli_query($connect,"SELECT * FROM CUSTOMER WHERE CUSTOMER_ID='$customer_id'");
                             $data=$req->fetch_assoc();
                             $customer_name=$data["NAME"];
                             $contact=$data["CONTACTNAME"];
                             $phone=$data["PHONENR"];
                             $mobile=$data["MOBILENR"];
                             $mail=$data["EMAIL"];
                             echo "<h2>".$customer_name."</h2>";
                             echo "<p> Contact ".$contact."</p>";
                             echo "<p> Tel. bureau : <a href=\"telto:".$phone."\" title=\"Contacter ".$contact."\" >".$phone."</a></p>";
                             echo "<p> Tel. mobile : <a href=\"telto:".$mobile."\" title=\"Contacter ".$contact."\" >".$mobile."</a></p>";


                             ?>
                     
                    </div>
                  

                          
                        <div class='col-sm-8' >
                           <h2>Mission : <?php echo $act_name ;?></h2>

                           <p class="btn btn-danger"><?php echo $status_name ;?></p>
                           <hr class="style_three"/>
                           <p>Date début  : <?php
                           $dm=mysqli_query($connect,"SELECT * FROM WORKORDER WHERE WORKORDER_ID='$wo_id'");
                           $data=$dm->fetch_assoc();
                            echo $data["STARTDATE"] ;
                            ?></p>
                           <p>Date fin  : <?php echo $data["ENDDATE"]  ;?></p>
                          
                           <?php
                          
        
                           if(!empty($wo_id)){
                             $dem=mysqli_query($connect,"SELECT * FROM WORKORDER_ACTIVITY WHERE WORKORDER_ID='$wo_id'");
                              while($data=$dem->fetch_assoc()){
                                 $activity_id=$data["ACTIVITY_ID"];
                                 $dem4=mysqli_query($connect,"SELECT * FROM ACTIVITY WHERE ACTIVITY_ID='$activity_id'");
                                 $data=$dem4->fetch_assoc();
                                 $activity_name=$data["NAME"];
                                 $description_act=$data["DESCRIPTION"];
                                 echo "<p>".$activity_name."</p>";
                               }
                             $dem2=mysqli_query($connect,"SELECT * FROM WORKORDER_COLLABORATOR WHERE WORKORDER_ID='$wo_id'");
                              while($data=$dem2->fetch_assoc()){
                                 $collaborator_id=$data["COLLABORATOR_ID"];
                                  $dem4=mysqli_query($connect,"SELECT * FROM COLLABORATOR WHERE COLLABORATOR_ID='$collaborator_id'");
                                  $data=$dem4->fetch_assoc();
                                  $fname=$data["FIRSTNAME"];
                                  $lname=$data["LASTNAME"];
                                   echo "<p>".$fname." ".$lname."</p>";
                                 
                              }
                            

                             

                           }else{
                                echo "<p>L'id est vide </p>";
                           }
                          ?>
                       <hr class="style_two"/>
                      </div>
                        <hr class="style_two"/>
                        <div class="col-sm-12">
                          <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                              <div class="col-sm-6"></div>
                              <div class="col-sm-6" >
                                 <a style="float:right;" href="WorkorderMod.php?id_mod=<?php echo $wo_id; ?>" class="btn btn-danger btn-lg">Modifier </a>
                              </div>
                              <hr class="style_two"/>
                          </div>
                           <hr class="style_one"/>
                      </div>
                       <hr class="style_one"/>

             
                  </div>
                   <hr class="style_one"/>
                 </div>
               </div>
            </div>
          </div>
         </div>
      </section>
    </div>

</body>
</html>
