<?php include("header.php");
    if(isset($_GET["error"])){
      if($_GET["error"]==0){
        $message="Vous n'avez pas rempli les champs Nom, Prénom, Email ou/et IMEI. ";
      }
       if($_GET["error"]==1){
        $message="L'adresse mail n'est pas correctement formatée !";
       }
        if($_GET["error"]==2){
          $message="Ce n'est pas une image au format jpg ou png. ";
       }
       if($_GET["error"]==3){
          $message="La photo n'est pas assez large ! (minimum : 200px de largeur)";
       }
      //$id=$_GET["id"];
    }

   ?>
   <hr class="style_one"/>
      <section id='content'>
        <div class='container'>
              <div class='row'>
                <div class='col-sm-12'>
                  <div class='box'>
                    <div class='box-header red-background'>
                      <div class='title'><p>Collaborateurs : ajouter</p>
                          <a class="btn btn-danger btn-lg" style="float:right;" href="EmployeeList.php" title="Retour au tableau des collaborateurs">Retour au tableau</a>
                          <hr class="style_two"/>
                      </div>
                     </div>
                    <div class='box-content'>
                       <?php
                          if(isset($_GET["error"])){

                             echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                             echo "<p>".$message."</p>";
                             echo "<hr class=\"style_two\"/></div>";
                           }
                         ?>
                       <form class="form" style="margin-bottom: 0;" method="post" action="EmployeeEdit.php" enctype="multipart/form-data">                     

               <div class='col-sm-12' >
                  <hr class="style_one"/>
                     <div class='col-sm-8' >
        					     <div class='form-group'>
                            <label for='last_name_col'>Nom de famille  </label>
                            <?php
                              if(isset($_POST["last_name_col"])){
                                echo "<input class=\"form-control\" id=\"last_name_col\" name=\"last_name_col\" value=\"".$_POST["last_name_col"]."\" type=\"text\">";
                              }else{
                                echo "<input class=\"form-control\" id=\"last_name_col\" name=\"last_name_col\" placeholder=\"Nom\" type=\"text\">";
                              }
                            ?>
                            
                        </div>
          					    <div class='form-group'>
                            <label for='first_name_col'>Prénom  </label>
                            <?php
                              if(isset($_POST["first_name_col"])){
                                echo "<input class=\"form-control\" id=\"first_name_col\" name=\"first_name_col\" value=\"".$_POST["first_name_col"]."\" type=\"text\">";
                              }else{
                                echo "<input class=\"form-control\" id=\"first_name_col\" name=\"first_name_col\" placeholder=\"Prénom\" type=\"text\">";
                              }
                            ?>
                        </div>
          					  
                        <div class='form-group'>
                             <label for='gender_col'>Genre</label>
    					               <select class="form-control" name="gender_col">
                                <option value="0" selected="selected">Choisir</option>
                                <?php
                                  echo "<option value=\"1\"";
                                  if(isset($_POST["gender_col"])&& $_POST["gender_col"]==1) 
                                    echo "selected='selected'";
                                    echo ">Homme</option>";
                                  echo "<option value=\"2\"";
                                  if(isset($_POST["gender_col"])&& $_POST["gender_col"]==2)
                                   echo "selected='selected'";
                                    echo ">Femme</option>";
                                ?>
                              </select>
                        </div>
                    </div> 
                    <div class='col-sm-4'  >
                       
                        <?php 
                            /* if(is_file("../images/avatar".$id.".jpg")){
                              echo "<img class=\"img-responsive avatar\" src=\"../images/avatar".$id.".jpg\">";
                            }elseif(is_file("../images/avatar".$id.".png")){
                               echo "<img class=\"img-responsive avatar\" src=\"../images/avatar".$id.".png\">";
                            }else{
                              echo "";
                            }*/
                          ?>
                          <img class="img-responsive avatar" src="../images/user.png">
                           <div class='form-group'>
                             <label for='avatar_col'>Télécharger une photo (petit format)  </label>
                            <input class="form-control" id='avatar_col' name='avatar_col' type='file'>
                       </div>
                     </div>    
             
              <hr class="style_two"/>
              


          
            


            <div class='col-sm-12'>
    							<div class='form-group' id='type'>
                     <label for='type_col'>Type</label> 
                     <select class="form-control" name="type_col" id="type_col">
                        <option value="0" selected="selected">Choisir</option>
                        <?php
                          $requete=mysqli_query($connect,"SELECT * FROM COLLABORATOR_TYPE");
                          $count=$requete->num_rows;
                          while($data=$requete->fetch_assoc()){
                            echo "<option value=\"".$data["COLLABORATOR_TYPE_ID"]."\"";
                            if(isset($_POST["type_col"])&& $_POST["type_col"]==$data["COLLABORATOR_TYPE_ID"]) 
                            echo "selected='selected'";
                            echo ">".$data["NAME"]."</option>";
                          }
                         
                        ?>
                      </select>
                  </div>
              
  							
						
						 
    							<div class='form-group' id='responsable'>
                    <label for='resp_col'>Responsable</label>   
      						  <select class="form-control" name="resp_col">
                        <option value="0" selected="selected">Choisir</option>

                        <?php
                          $dem=mysqli_query($connect,"SELECT COLLABORATOR_ID,LASTNAME,FIRSTNAME FROM COLLABORATOR WHERE COLLABORATOR_TYPE_ID = 1");
                          $compte=$dem->num_rows;
                       
                          if($compte>0){
                            while($data=$dem->fetch_assoc()){
                              echo "<option value=\"".$data["COLLABORATOR_ID"]."\"";
                               echo "selected=\"selected\">".$data["FIRSTNAME"]." ".$data["LASTNAME"]."</option>";
                            }
                          }else{

                              echo "<option value=\"0\" selected=\"selected\">Pas de manager</option>";
                            }
                        ?>
                      
                     
                    </select>
    							</div>

						        <div class="form-group" id="choixAct">
                       <label>Choisir une ou plusieurs activités</label> 
                         <?php
                           $q=mysqli_query($connect,"SELECT * FROM ACTIVITY"); 
                            while($data=$q->fetch_assoc()){
                              $activite_name=$data["NAME"];
                              $activite_id=$data["ACTIVITY_ID"];
                              echo "<p class=\"form-control\"><input type=\"checkbox\" name=\"activite_id[]\" value=\"".$activite_id."\">&nbsp;".$activite_name."</p>";
                          }
                          ?>
                       
                        <hr class="style_three"/>
                       </div>
                  <hr class="style_one"/>
						 <div class='form-group'>
                <label for='mail_col'>Adresse e-mail  </label>
                <?php
                  if(isset($_POST["mail_col"])){
                    echo "<input class=\"form-control\" id=\"mail_col\" name=\"mail_col\" value=\"".$_POST["mail_col"]."\" type=\"text\">";
                  }else{
                    echo "<input class=\"form-control\" id=\"mail_col\" name=\"mail_col\" placeholder=\"Adresse e-mail\" type=\"text\">";
                  }
                ?>
             </div>

             <div class='form-group'>
                <label for='pass_col1'>Mot de passe  </label>
                <input class="form-control" id="pass_col1" name="pass_col1" type="password">
               
             </div>
             <div class='form-group'>
                <label for='pass_col'>Vérifier votre mot de passe  </label>
                <input class="form-control" id="pass_col" name="pass_col" type="password">
             
             </div>
              <div class='form-group'>
                <span id="pass1" style="padding:0.5em; color:red;"></span>
              </div>
              
               <?php
				$sql_organization = "SELECT * FROM SCHEDULE";
				$organizations = mysqli_query($connect, $sql_organization);
				
			?>
              <div class="form-group">
				<label for="schedult_id">Schedule</label>
				<select class="form-control" id="schedule_id" name="schedule_id">
					<?php if($organizations):while($row = $organizations->fetch_assoc()):?>
                	<option value="<?php echo $row['SCHEDULE_ID'];?>" <?php if($row['SCHEDULE_ID'] == $data['SCHEDULE_ID']) echo "selected";?> >
                		<?php echo $row['NAME'];?>
                	</option>
                	<?php endwhile;endif;?>
				</select>
				</div>
			 <div class="form-group">
				<label for="app_admin">APP Admin</label>
				<input type="checkbox" checked name="app_admin"  id="app_admin" />
			  </div>
			
			<?php
				$sql_organization = "SELECT * FROM ORGANIZATION_UNIT";
				$organizations = mysqli_query($connect, $sql_organization);
				
			?>
			<div class="form-group">
                <label for="organization_unit_col">Organization Unit </label>
                <select class="form-control" id='organization_unit_col' name='organization_unit_col' >
                	<?php if($organizations):while($row = $organizations->fetch_assoc()):?>
                	<option value="<?php echo $row['ORGANIZATION_UNIT_ID'];?>" >
                		<?php echo $row['NAME'];?>
                	</option>
                	<?php endwhile;endif;?>
                </select>
            </div>		  
			<div class='form-group'>
                <label for='tel_col'>Tel. Mobile  </label>
                <?php
                  if(isset($_POST["tel_col"])){
                    echo "<input class=\"form-control\" id=\"tel_col\" name=\"tel_col\" value=\"".$_POST["tel_col"]."\" type=\"text\">";
                  }else{
                    echo "<input class=\"form-control\" id=\"tel_col\" name=\"tel_col\" placeholder=\"Tel. Mobile\" type=\"text\">";
                  }
                ?>
            </div>

						 <div class='form-group'>
                <label for='imei_col'>Numéro IMEI  </label>
                 <?php
                  if(isset($_POST["imei_col"])){
                    echo "<input class=\"form-control\" id=\"imei_col\" name=\"imei_col\" value=\"".$_POST["imei_col"]."\" type=\"text\">";
                  }else{
                    echo "<input class=\"form-control\" id=\"imei_col\" name=\"imei_col\" placeholder=\"Numéro IMEI\" type=\"text\">";
                  }
                ?>
            </div>
						
						 <div class='form-group'>
                <label for='cost_col'>Coût horaire  </label>
                <?php
                  if(isset($_POST["cost_col"])){
                    echo "<input class=\"form-control\" id=\"cost_col\" name=\"cost_col\" value=\"".$_POST["cost_col"]."\" type=\"text\">";
                  }else{
                    echo "<input class=\"form-control\" id=\"cost_col\" name=\"cost_col\" placeholder=\"Coût\" type=\"text\">";
                  }
                ?>
            </div>
					
              </div>

    				 <div class="col-sm-12">
                  <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                    <div class="col-sm-10"></div>
                    <div class="col-sm-2" >                  
                      <input style="float:right;" type="submit" id="addCollaborator" name="addCollaborator" value="Ajouter un collaborateur" class="btn btn-danger btn-lg">
                    </div>
                      <hr class="style_two"/>
                  </div>

              </div>
               <hr class="style_two"/>
             </div>
          </form>
          <hr class="style_two"/>
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
    $("#pass_col").change(function () {

        if($("#pass_col").val()!=$("#pass_col1").val()) {
            $("#pass1").text("Les mots de passe sont différents !");
            $("#addCollaborator").attr("type","hidden");
        }else{
            $("#pass1").text("Mot de passe ok !");
            $("#addCollaborator").attr("type","submit");
        }
    });
 });

</script>
</body>
</html>
