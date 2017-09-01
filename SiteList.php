<?php include("header.php");
      $dem=mysqli_query($connect,"SELECT * FROM SITE "); 
?>
 <hr class="style_one"/>
    <div id='wrapper'>
      <section id='content'>
        <div class='container'>
              <div class='row'>
                <div class='col-sm-12'>
                  <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                    <div class='box-header red-background'>
                     <div class='title'><p>Sites</p>
                        <div class='actions'>
                          <a class="btn btn-md btn-link" style="float:right;" href="../Accueil.php" title="Retour au Manager"><i class='icon-home' ></i><span class="hidden-xs"> Retour au Manager</span></a>
                          <a class="btn btn-md btn-link" href="SiteAdd.php"><i class='icon-plus' ></i><span class="hidden-xs">Ajouter un chantier</span></a>
                        </div>
					             </div>
                    </div>
                    <div class='box-content'>
                      <div class='responsive-table'>
                        <div class='col-sm-12' id='afficheMessage'></div>
                        <div class='scrollable-area'>
                          <table id="example" class='data-table-column-filter table table-bordered table-striped' style='margin-bottom:0; width:100% !important;'>
                            <thead>
                              <tr><th>Nom</th><th>Client</th><th>Description</th><th>Mod</th><th>Sup</th></tr>
                            </thead>
                            <tbody>
                              <?php 
                              while($data=$dem->fetch_assoc()){
                                $id=$data["SITE_ID"];
                                $customer_id=$data["CUSTOMER_ID"];
                                $req3=mysqli_query($connect,"SELECT * FROM CUSTOMER WHERE CUSTOMER_ID='$customer_id'");
                                $data3=$req3->fetch_assoc();
                                echo "<tr><td id=\"".$data["NAME"]."\">".$data["NAME"]."</td><td>".$data3["NAME"]."</td><td>".$data["DESCRIPTION"]."</td>
                                <td>
                                  <div class=\"text-right\">
                                    <a class=\"btn btn-warning btn-xs\" href=\"SiteMod.php?id_mod=$id\">
                                      <i class=\"icon-edit\"></i>
                                    </a>
                                  </div>
                                </td>
                                 <td id=\"".$id."\" class=\"supp\">
                                  <div class=\"text-right\">
                                      <a class=\"btn btn-danger btn-xs\" >
                                        <i class=\"icon-remove remove\"></i>
                                      </a>
                                  </div>
                                </td>
                              </tr>";
                              }
                             
                              ?>
                              </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
        </div>
      </section>
    </div>
    <!-- / jquery [required] -->
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
    <script src="assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/datatables/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script>
    <!-- / END - page related files and scripts [optional] -->
    <script type="text/javascript">
     $(document).ready(function() {
        var table = $('#example').DataTable();
         
        $('#example tbody').on('click', 'td.supp',function () {
           var id=$(this).attr("id");
           var name=$(this).siblings().attr("id");
           var message="<p>Voulez-vous vraiment supprimer ce chantier '"+name+"'&nbsp;? <a class='btn btn-danger' id='oui'>OUI</a>&nbsp&nbsp;<a class='btn btn-danger' id='non'>NON</a></p>";
            
            $("#afficheMessage").css("display","block").html(message);
            
            $("#non").click(function(){
              $("#afficheMessage").css("display","none");
            });

            $("#oui").click(function(){
                var envoi=$.post('removeSite.php',{id:id});
                envoi.done(function(data) {
                location.reload();

                });
                return false; 
              });
          
        } );
    } );

     </script>
  </body>


</html>
