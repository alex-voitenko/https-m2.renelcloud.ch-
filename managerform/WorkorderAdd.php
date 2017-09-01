<?php include("header.php");

    if(isset($_GET["error"])){
      if($_GET["error"]==1){
          $message="Vous n'avez pas rempli les champs Nom, Chantier... ";
      }
      
    $id=$_GET["id"];
    }
  ?>
    <hr class="style_one"/>
      <section id='content'>
        <div class='container'>
         
              <div class='row'>
                <div class='col-sm-12'>
                  <div class='box'>
                    <div class='box-header red-background'>
                      <div class='title'><p>Mission : Ajouter</p>
                         <a class="btn btn-danger btn-lg" style="float:right;" href="WorkorderList.php" title="Retour au tableau des missions">Retour au tableau</a>
                          <hr class="style_two"/>
                      </div>
                     
                    </div>
                  <div class='box-content'>
                  <form class="form" style="margin-bottom: 0;" method="post" action="WorkorderEdit.php" enctype="multipart/form-data" accept-charset="UTF-8"> <!--accept-charset="UTF-8"-->
          
                  <?php
                  if(isset($_GET["error"])){
                       echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                         echo "<p>".$message;
                         echo "<a class=\"btn btn-danger btn-lg\" style=\"float:right;\" href=\"WorkorderList.php\" title=\"Retour au tableau des missions\">Retour au tableau des missions</a><hr class=\"style_two\"/></p>";
                         echo "</div>";

                            
                  }
            
                 ?>
                   
                     
                    <div class='col-sm-12' >   
                      <div class='form-group'>
                        <label for='act_name'>Nom / Référence</label>
                        <input class='form-control' id='act_name' name='act_name' type='text' placeholder="Nom / Référence">
                      </div>
                    </div>
                    <div class='col-sm-12' >     
                      <div class='form-group'>
                        <label for='client'>Client </label> 
                         <select class="form-control" name="customer_id" id="customer_id">
                            <option value="0" selected="selected">Choisir</option>
                            <?php
                            
                              $req2=mysqli_query($connect,"SELECT * FROM CUSTOMER");
                              while($data2=$req2->fetch_assoc()){
                                 $idClient=$data2["CUSTOMER_ID"];
                                  $clientName=$data2["NAME"];
                                  echo "<option value=\"".$idClient."\"";
                                  echo ">".$clientName."</option>";
                                }
                             ?>
                          </select>
                         </div>
                       </div>
                      <!--  <div class='col-sm-1' style="margin-top: 25px;padding-left: 5px;" >
                          <div class='form-group'>
                             <a class="btn btn-danger" style="margin-bottom:5px" href="CustomerAdd.php">
                                 <i class="icon-plus"></i></a> 
                            </a>
                          </div>
                        </div>-->
                    
                     <div class='col-sm-12 ' id="display_contact" >
                         <div class='col-sm-11 form-actions '>
                          <div class='col-sm-11 '>
                          <div class='form-group' id='contact_site'><label for='contact_site'>Contact</label></div>
            
                        <div class='form-group' id='contact_coords'><label>Coordonnées contact</label></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
						<div class="form-group">
							<label for="work-ref">Work Reference</label>
							<div>
								<input class="form-control" type="text" name="workorder_ref" />
							</div>
						</div>
					</div>
                    <hr class="style_one"/>
                    
                    <div class='col-sm-12' >     
                      <div class='form-group'>
                        <label for='client'>Chantiers </label> 
                         <select class="form-control" name="site_id" id="site_id">
                            <option value="0" selected="selected">Choisir</option>
                          </select>
                         </div>
                       </div>
                      <!--  <div class='col-sm-1' style="margin-top: 25px;padding-left: 5px;" >
                          <div class='form-group'>
                             <a class="btn btn-danger" style="margin-bottom:5px" href="SiteAdd.php">
                                 <i class="icon-plus"></i></a> 
                            </a>
                          </div>
                        </div>-->

                     <div class='col-sm-12' id="display_site" >  
                      <label>Adresse du chantier</label>
                      <div class='form-group' id='address_site'></div>
                    </div>
                
               

           
                  <div class='col-sm-12' >     
                      <div class="form-group" id="choixAct">
                       <label>Choisir une ou plusieurs activités</label> 
                       <hr class="style_three"/>
                         <?php
                         $i=1;
                           $q=mysqli_query($connect,"SELECT * FROM ACTIVITY"); 
                            while($data=$q->fetch_assoc()){
                              $activite_name=$data["NAME"];
                              $activite_id=$data["ACTIVITY_ID"];


                              echo "<div class=\"container_act\">
                                <p class=\"btn btn-danger choixAct\" style=\"float:left;cursor:pointer\" id=\"".$activite_id."\">".$activite_name."</p>";
                                echo "<hr class=\"style_three\"/>";
                               
                               echo "<div class=\"col-sm-11 activite coll\"> ";
                                  
                                     echo "<hr class=\"style_two\"/></div>";
                               
                               /* echo "<div class=\"col-sm-11 activite desc\">     
                                         <div class=\"form-group\">
                                       <label for=\"desc_activity\"> Description</label> 
                                        <textarea class=\"form-control\" id=\"".$desc_activity."\" placeholder=\"Description ...\"  rows=\"3'\"></textarea>
                                      </div>
                                    </div>";*/
                                    echo "<hr class=\"style_two\"/>";
                             echo "</div>";

                          }
                          ?>
                       
                      
                       </div>
                     </div>
                  

                      <!-- <div class='col-sm-1' style="margin-top: 25px;padding-left: 5px;" >
                          <div class='form-group'>
                             <a class="btn btn-danger" style="margin-bottom:5px" href="ActivityAdd.php">
                                 <i class="icon-plus"></i></a> 
                            </a>
                          </div>
                        </div>

               
              
                <div class='col-sm-1' style="margin-top: 25px;padding-left: 5px;" >
                  <div class='form-group'>
                   <a class="btn btn-danger  " style="margin-bottom:5px" href="EmployeeAdd.php">
                      <i class="icon-plus"></i>
                    </a>
                   </div>
                </div>-->
              
            <div class='col-sm-6'>
                <div class='form-group'>
                    <label for='inputText'>Date début </label> 
                   <div class="datepicker-input input-group" id="datepicker">
                      <input class="form-control" data-format="YYYY-MM-DD">
                      <input id="date_debut" name="date_debut" type="hidden" value="">
                      <span class="input-group-addon">
                        <span data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar"></span>
                      </span>
                    </div>
                  </div>
              </div>
            
             <div class='col-sm-6'>
                <div class='form-group'>
                    <label for='inputText'>Date Fin </label> 
                   <div class="datepicker-input input-group" id="datepicker2">
                      <input class="form-control " data-format="YYYY-MM-DD">
                      <input id="date_fin" name="date_fin" type="hidden" value="">
                      <span class="input-group-addon">
                        <span data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar"></span>
                      </span>
                    </div>
                  </div>
              </div>


          <div class='col-sm-12'>
           <div class='form-group'>
            <label for='inputText'> Etat </label> 
             <select class="form-control" name="state_wo">
                  <option value="0" selected="selected">Choisir</option>
                   <?php
                    $req3=mysqli_query($connect,"SELECT * FROM WORKORDER_STATUS");
                    while($data=$req3->fetch_assoc()){
                        $wo_status_id=$data["WORKORDER_STATUS_ID"];
                        $wo_status_name=$data["NAME"];
                        echo "<option value=\"".$wo_status_id."\">".$wo_status_name."</option>";
                    }    
                    ?>
              </select>
            </div>
             </div>
            
           
         
            
                <hr class="style_two"/>
                  <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                      <div class="col-sm-10"></div>
                      <div class="col-sm-2">
                          <input style="float:right;" type="submit" id="woAdd" name="woAdd" value="Ajouter" class="btn btn-danger btn-lg">
                      </div>
                    <hr class="style_two"/>
                    </div>  
                  </div>
                 </div> 
                  <hr class="style_one"/>
                 </form>
              
                    <hr class="style_one"/>
                     </div>
                  </div>
                    <hr class="style_one"/>
                </div>
              </div>
            </div>
          </div>
        
        </div>
      </section>
    </div>

     <script src="assets/javascripts/jquery/jquery.min.js" type="text/javascript"></script>
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
    <!-- / START - page related files and scripts [optional] -->
    <script src="assets/javascripts/plugins/fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/select2/select2.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/input_mask/bootstrap-inputmask.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/charCount/charCount.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/autosize/jquery.autosize-min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_switch/bootstrapSwitch.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/naked_password/naked_password-0.2.4.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/mention/mention.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/typeahead/typeahead.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/common/wysihtml5.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/common/bootstrap-wysihtml5.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/pwstrength/pwstrength.js" type="text/javascript"></script>
  <script type="text/javascript">
      $(document).ready(function(){
       
          $("#customer_id").change(function () {
             $("#site_id option:not(:first)").remove();
              $("#address_site p").remove();
                  $("#contact_coords p").remove();
                  $("#contact_site p").remove();
            if($("#customer_id option:selected").val()!=1){
              
                  var id=$("#customer_id option:selected").val();
                  var envoi=$.post('findSite.php',{id:id});
                  var val;
                  envoi.done(function(data) {
                    $("#display_coord").css("display","block");
                    $("#display_contact").css("display","block");
                    $("#contact_site").append("<p class='form-control'>"+data.contact+"</p>");
                    $("#contact_coords").append("<p class='form-control' style='float:left;'>Tel. bureau : <a href='telto='"+data.phone+"' title='Contacter "+data.contact+"'>"+data.phone+"</a></p><p style='float:left;' class='form-control'>Tel. mobile : <a href='telto='"+data.mobile+"' title='Contacter "+data.contact+"'>"+data.mobile+"</a></p><p style='float:left;' class='form-control'>Adresse mail : <a href='mailto='"+data.mail+"' title='Contacter "+data.contact+"'>"+data.mail+"</a></p>");
                   var i=0;
                    for(i in data.id_site){
                     // if(data.id_site[i].length!=0)
                          $("#site_id").append("<option value='"+data.id_site[i]+"' >"+data.nom[i]+"</option>");
                          i ++;
                      }
                   
                    },'json');
          return false; 
          }
        });
       });

       $(document).ready(function(){
     
        $("#site_id").change(function () {

            if($("#site_id option:selected").val()!=1){
               $("#address_site p").remove();
                  var id=$("#site_id option:selected").val();
                  var envoi=$.post('findAdresse.php',{id:id});
                  envoi.done(function(data) {
                     $("#display_site").css("display","block");
                  $("#address_site").append("<p style='float:left;' class='form-control'>"+data+"</p>");
            },'json');
          return false; 
          }
        });
       });

        $(document).ready(function(){
          
          $(".choixAct").click(function () {
           $(this).unbind("click");
            var container=$(this).closest(".container_act");
            var activite=container.children(".activite.coll");
            var desc=container.children(".activite.desc");
           // activite.children().remove();
            
            activite.css("display","block");
            desc.css("display","block");
            if($(this).attr("id")!=0){
                var id=$(this).attr("id");
                var envoi=$.post('findColl.php',{id:id});
                envoi.done(function(data) {
                   
                  for(var i = 0; i< 100;i++){
                      if(data.collaborator_id[i].length!=0 && data.lastname[i]!="null"){

                        activite.append("<p style='float:left;width:100%;'><input type='checkbox' value='"+data.collaborator_id[i]+"' name='activite"+id+"[]'>&nbsp;"+data.firstname[i]+" "+data.lastname[i]+"</p>");
                      }
                  }
                     
            },'json');
          return false; 
          }
       
       });
      });
  $(document).ready(function(){

      $('#datepicker').on("changeDate", function() {
          $('#date_debut').val(
              $('#datepicker').datepicker('getFormattedDate')
          );
      });
   });
   $(document).ready(function(){

      $('#datepicker2').on("changeDate", function() {
          $('#date_fin').val(
              $('#datepicker2').datepicker('getFormattedDate')
          );
      });
   });

  </script> 
</body>
</html>
