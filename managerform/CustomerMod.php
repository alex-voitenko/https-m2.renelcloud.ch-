
  <?php  include("header.php");
  if(isset($_GET["id_mod"])){
  $id=$_GET["id_mod"];
  $dem=mysqli_query($connect,"SELECT * FROM CUSTOMER WHERE CUSTOMER_ID = '$id'"); //CUSTOMER_ID,ADDRESS_ID,NAME,DESCRIPTION,CONTACTNAME,PHONENR,MOBILENR,EMAIL,WEBSITE
  $data=$dem->fetch_assoc();

}
if(isset($_GET["error"])){
    if($_GET["error"]==0){
        $message="Le champ 'Site web' doit obligatoirement contenir les caractères : http://" ;
    }
   if($_GET["error"]==1){
     $message="L'adresse mail doit contenir un @";  
   }
    if($_GET["error"]==2){
     $message="Une erreur s'est produite, veuillez recommencer !";  
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
                  <div class='title'><p>Clients : modifier</p>
                    <a class="btn btn-danger btn-lg" style="float:right;" href="CustomerList.php" title="Retour au tableau des clients">Retour au tableau des clients</a>
                    <hr class="style_two"/>
                </div>
                </div>
                    <div class='box-content'>
                    <?php
                       if(isset($_POST["modCustomer"])){
                         echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                         echo "<p>".$message;
                         echo "</div>";
                       }
                        
                    ?>
                   
                   
                     <form class="form" style="margin-bottom: 0;" method="post" action="CustomerEdit.php" enctype="multipart/form-data" >
                      <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $data["CUSTOMER_ID"]; ?>" >
                       <input type="hidden" id="address_id" name="address_id" value="<?php echo $data["ADDRESS_ID"]; ?>" >
                      <div class='form-group'>
                        <label for='name_cus'>Nom</label>
                        <?php
                        
                          echo  "<input class=\"form-control\" id=\"name_cus\" name=\"name_cus\" value=\"".$data["NAME"]."\" type=\"text\">";
                      
                        ?>
                       
                      </div>

                     <div class='form-group'>
                        <label for="desc_cus">Description</label>
                        <?php
                        
                          echo  "<input class=\"form-control\" id=\"desc_cus\" name=\"desc_cus\" value=\"".$data["DESCRIPTION"]."\" type=\"text\">";
                       
                        ?>
                      </div>

                    <div class='form-group'>
                        <label for='tel_cus'>Tel. Bureau</label>
                        <?php
                         
                          echo  "<input class=\"form-control\" id=\"tel_cus\" name=\"tel_cus\" value=\"".$data["PHONENR"]."\" type=\"text\">";
                        
                        ?>
                      </div>

                     <div class='form-group'>
                        <label for='contact_cus'>Contact</label>
                         <?php
                        
                          echo  "<input class=\"form-control\" id=\"contact_cus\" name=\"contact_cus\" value=\"".$data["CONTACTNAME"]."\" type=\"text\">";
                       
                        ?>
                      </div>

                     <div class='form-group'>
                        <label for='mob_cus'>Tel. Mobile</label>
                         <?php
                        
                          echo  "<input class=\"form-control\" id=\"mob_cus\" name=\"mob_cus\" value=\"".$data["MOBILENR"]."\" type=\"text\">";
                      
                        ?>
                      </div>

                     <div class='form-group'>
                        <label for='mail_cus'>Email</label>
                         <?php
                        
                          echo  "<input class=\"form-control\" id=\"mail_cus\" name=\"mail_cus\" value=\"".$data["EMAIL"]."\" type=\"text\">";
                      
                        ?>
                      </div>

                     <div class='form-group'>
                        <label for='url_cus'>Site Web</label>
                         <?php
                        
                          echo  "<input class=\"form-control\" id=\"url_cus\" name=\"url_cus\" value=\"".$data["WEBSITE"]."\" type=\"text\">";
                       
                        ?>
                      </div>  

                      <div class='form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg' style='margin-bottom: 0;'>
                          <div class='row' >
                            <div class='col-sm-10'></div>

                             <div class='col-sm-2' >

                                <input type="submit" id="modCustomer" name="modCustomer" value="MODIFIER" class='btn btn-danger btn-lg'>
                            </div>
                          </div>
                      </div>
                    </form>
              
              
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
        
        </div>
      </section>
    </div>


  </body>


</html>
