<?php include("header.php");

 if(isset($_GET["id"])){
    $activity_id=$_GET["id"];
    $req=mysqli_query($connect,"SELECT * FROM ACTIVITY WHERE ACTIVITY_ID='$activity_id'");
    $data=$req->fetch_assoc();
    $name=$data["NAME"];
    $description=$data["DESCRIPTION"];

 }

 if(isset($_POST["modAct"])){
    $activity_id=$_POST["activity_id"];
    $name=mysqli_real_escape_string($connect,$_POST["mat_name"]);
    $description=mysqli_real_escape_string($connect,$_POST["mat_desc"]);

    if(!empty($name)&&!empty($description)){
       if($req=mysqli_query($connect,"UPDATE ACTIVITY SET NAME='$name', DESCRIPTION='$description' WHERE ACTIVITY_ID='$activity_id'")){
        $message="Modification effectuée !";
        
      }else{
        header("Location:ActivityMod.php?error=0&id=$activity_id");
      }
    }else{
      header("Location:ActivityMod.php?error=1&id=$activity_id");
    }
 }
 if(isset($_POST["addAct"])){
    $activity_id=$_POST["activity_id"];
    $name=mysqli_real_escape_string($connect,$_POST["act_name"]);
    $description=mysqli_real_escape_string($connect,$_POST["act_desc"]);
   
    if(!empty($name)){
       if($req=mysqli_query($connect,"INSERT INTO ACTIVITY (ACTIVITY_ID,NAME,DESCRIPTION) VALUES (NULL,'$name','$description')")){
        $dernier_activite_id=mysqli_insert_id($connect);
        $message="Ajout effectué !";
        
      }else{
        header("Location:ActivityAdd.php?error=0&id=$activity_id");
      }
    }else{
      header("Location:ActivityAdd.php?error=1&id=$activity_id");
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
                  <div class='title'><p>Activité : <?php echo $name; ?></p>
                      <a class="btn btn-danger btn-lg" style="float:right;" href="ActivityList.php" title="Retour au tableau des activités">Retour au tableau</a>
                      <hr class="style_two"/>
                  </div>
                 </div>
                    <div class='box-content'>
                       <?php
                          if(isset($_POST["addAct"])OR isset($_POST["modAct"])){
                          
                             echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                             echo "<p>".$message."</p>";

                             echo "<hr class=\"style_two\"/></div>";

                           }
                         ?>

                       <div class='col-sm-12' >

                        <hr class="style_one"/>
                       
                          
                        <div class='col-sm-12' >
                           <h2><?php echo $name ;?></h2>
                           <p><?php echo $description;?></p>
                   
                      </div>
                        <hr class="style_two"/>
                        <div class="col-sm-12">
                          <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                              <div class="col-sm-6"></div>
                              <div class="col-sm-6" >
                                 <a style="float:right;" href="ActivityMod.php?id_mod=<?php echo $activity_id;?>" class="btn btn-danger btn-lg">Modifier </a>
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
