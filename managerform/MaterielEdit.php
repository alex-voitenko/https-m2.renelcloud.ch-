<?php include("header.php");

 if(isset($_GET["id"])){
    $dernier_material_id=$_GET["id"];
    $req=mysqli_query($connect,"SELECT * FROM MATERIAL WHERE MATERIAL_ID='$dernier_material_id'");
    $data=$req->fetch_assoc();
    $name=$data["NAME"];
    $description=$data["DESCRIPTION"];
    $prixUnit=$data["UNIT_PRICE"];

 }

 if(isset($_POST["modMat"])){
    $dernier_material_id=$_POST["material_id"];
    $name=mysqli_real_escape_string($connect,$_POST["mat_name"]);
    $description=mysqli_real_escape_string($connect,$_POST["mat_desc"]);
    $prixUnit=$_POST["mat_prix"];
    $photo=$_FILES["photo"]["tmp_name"];
    if(!empty($name)&&!empty($description)&&!empty($prixUnit)){
       if($req=mysqli_query($connect,"UPDATE MATERIAL SET NAME='$name', DESCRIPTION='$description',UNIT_PRICE='$prixUnit' WHERE MATERIAL_ID='$dernier_material_id'")){
        $message="Modification effectuée !";
         if(!empty($photo)&& is_uploaded_file($photo)){
                    list($largeur,$hauteur,$type,$attr) = getimagesize($photo);
                    if($type==2) $format="jpg";
                    if($type==3) $format="png";
                     $chemin="../images/photo".$dernier_material_id.".".$format;
                      $chemin2="https://m2.renelcloud.ch/images/photo".$dernier_material_id.".".$format;
                    $new_largeur =200;
                    if($type == 2 OR $type==3){  
                        if($largeur>$new_largeur){
                            if(move_uploaded_file($photo,$chemin)){
                              $req=mysqli_query($connect,"UPDATE MATERIAL SET PICTURE_URL='$chemin2' WHERE MATERIAL_ID='$dernier_material_id'");
                              $message.="Photo téléchargée ! ";
                            }else{
                              $message.="Probleme insertion photo";
                            }
                        }else{
                          $message.="La photo doit avoir une largeur de 200px minimum ! ";
                        }
                    }else{
                        $message.="La photo doit être au format jpg ou png.";
                    }
                 }else{
                        $message.="Vous n'avez pas téléchargé de photo";
                    }
      }else{
        header("Location:MaterielMod.php?error=0&id=$dernier_material_id");
      }
    }else{
      header("Location:MaterielMod.php?error=1&id=$dernier_material_id");
    }
 }
 if(isset($_POST["addMat"])){
   // $material_id=$_POST["material_id"];
    $name=mysqli_real_escape_string($connect,$_POST["mat_name"]);
    $description=mysqli_real_escape_string($connect,$_POST["mat_desc"]);
    $prixUnit=$_POST["mat_prix"];
    $photo=$_FILES["photo"]["tmp_name"];
    if(!empty($name)&&!empty($description)&&!empty($prixUnit)){
       if($req=mysqli_query($connect,"INSERT INTO MATERIAL (MATERIAL_ID,NAME,DESCRIPTION,UNIT_PRICE) VALUES (NULL,'$name','$description','$prixUnit')")){
        $dernier_material_id=mysqli_insert_id($connect);
        $message="Ajout effectué !";
         if(!empty($photo)&& is_uploaded_file($photo)){
                    list($largeur,$hauteur,$type,$attr) = getimagesize($photo);
                    if($type==2) $format="jpg";
                    if($type==3) $format="png";
                     $chemin="../images/photo".$dernier_material_id.".".$format;
                      $chemin2="https://m2.renelcloud.ch/images/photo".$dernier_material_id.".".$format;
                    $new_largeur =200;
                    if($type == 2 OR $type==3){  
                        if($largeur>$new_largeur){
                            if(move_uploaded_file($photo,$chemin)){
                              $req=mysqli_query($connect,"UPDATE MATERIAL SET PICTURE_URL='$chemin2' WHERE MATERIAL_ID='$dernier_material_id'");
                              $message.="Photo téléchargée ! ";
                            }else{
                              $message.="Probleme insertion photo";
                            }
                        }else{
                          $message.="La photo doit avoir une largeur de 200px minimum ! ";
                        }
                    }else{
                        $message.="La photo doit être au format jpg ou png.";
                    }
                 }else{
                        $message.="Vous n'avez pas téléchargé de photo";
                    }
      }else{
        header("Location:MaterielAdd.php?error=0&id=$dernier_material_id");
      }
    }else{
      header("Location:MaterielAdd.php?error=1&id=$dernier_material_id");
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
                  <div class='title'><p>Matériel : <?php echo $name; ?></p>
                      <a class="btn btn-danger btn-lg" style="float:right;" href="MaterielList.php" title="Retour au tableau des matériels">Retour au tableau</a>
                      <hr class="style_two"/>
                  </div>
                 </div>
                    <div class='box-content'>
                       <?php
                          if(isset($_POST["addMat"])OR isset($_POST["modMat"])){
                          
                             echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                             echo "<p>".$message."</p>";

                             echo "<hr class=\"style_two\"/></div>";

                           }
                         ?>

                       <div class='col-sm-12' >

                        <hr class="style_one"/>
                         <div class='col-sm-2' style="margin:1em auto;">
                             <?php 
                               if(is_file("../images/photo".$dernier_material_id.".jpg")){
                                echo "<img class=\"img-responsive avatar\" src=\"../images/photo".$dernier_material_id.".jpg\">";
                              }elseif(is_file("../images/photo".$dernier_material_id.".png")){
                                 echo "<img class=\"img-responsive avatar\" src=\"../images/photo".$dernier_material_id.".png\">";
                              }else{
                                echo "<img class=\"img-responsive avatar\" src=\"../images/tools.png\">";
                              }
                            
                            ?>
                     
                    </div>
                          
                        <div class='col-sm-10' >
                           <h2><?php echo $name ;?></h2>
                           <h3><?php echo $description;?></h3>
                           <p>Prix à l'unité : <?php echo $prixUnit ;?>&nbsp;CHF</p>
                      </div>
                        <hr class="style_two"/>
                        <div class="col-sm-12">
                          <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                              <div class="col-sm-6"></div>
                              <div class="col-sm-6" >
                                 <a style="float:right;" href="MaterielMod.php?id_mod=<?php echo $dernier_material_id; ?>" class="btn btn-danger btn-lg">Modifier </a>
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
