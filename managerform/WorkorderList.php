<?php include("header.php");?>
   <hr class="style_one"/>
    <div id='wrapper'>
     
    
      <section id='content'>
        <div class='container'>
         
              <div class='row'>
                <div class='col-sm-12'>
                  <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                    <div class='box-header red-background'>
                       <div class='title'><p>Missions</p>
                        <div class='actions'>
                          <a class="btn btn-md btn-link" style="float:right;" href="../Accueil.php" title="Retour au Manager"><i class='icon-home' ></i> Retour au Manager</a>
                          <a class="btn btn-md btn-link" href="WorkorderAdd.php"><i class='icon-plus' ></i> Ajouter une mission</a>
                        </div>
                       </div>
                    </div>
                    <div class='box-content'>
                      <div class='responsive-table'>
                        <div class='col-sm-12' id='afficheMessage'></div>
                        <table id="example" class='data-table-column-filter table table-bordered table-striped' style='margin-bottom:0;'>
                            <thead>
                              <tr>
                              	<th>Nom de la mission</th>
                              	<th>Chantier</th>
                              	<th>Description</th>
                              	<th>Work Reference</th>
                              	<th>Modifier</th>
                              	<th>Supprimer</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $dem=mysqli_query($connect,"SELECT * FROM WORKORDER"); 

                              while($data=$dem->fetch_assoc()):
                                $id=$data["WORKORDER_ID"];
                                $id_site=$data["SITE_ID"];
                                $reqSite=mysqli_query($connect,"SELECT * FROM SITE WHERE SITE_ID='$id_site'");
                                $dat=$reqSite->fetch_assoc();
                                $name_site=$dat["NAME"];?>
                  				
                                <tr>
                                	<td class="name" id="<?php echo $data["NAME"];?>" ><?php echo $data["NAME"]; ?></td>
                                	<td><?php echo $name_site;?></td>
                                	<td><?php echo $data["DESCRIPTION"]; ?></td>
                                	<td><?php echo $data['WORKORDER_REF'];?></td>
                                	<td>
	                                  <div class="text-right">
	                                    <a class="btn btn-warning btn-xs icon-a" href="WorkorderEdit.php?id=<?php echo $data['WORKORDER_ID'];?>">
	                                      <i class="icon-edit"></i>
	                                    </a>
	                                  </div>
                                	</td>
                                 	<td >
                                  <div class="text-right supp" name="<?php echo $data['NAME']; ?>" id="<?php echo $id;?>" >
                                      <a class="btn btn-danger btn-xs icon-a" >
                                        <i class="icon-remove remove"></i>
                                      </a>
                                  </div>
                                </td>
                              </tr>
                              <?php endwhile;?>
                             
                              
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

<script src="assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="assets/javascripts/plugins/datatables/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
<script src="assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.jqueryui.min.js" type="text/javascript"></script>
<script type="text/javascript">
function suppclick(id, name){
    // alert(name);
     var message="<p>Voulez-vous vraiment supprimer cet employé : '"+name+"'&nbsp;? <a class='btn btn-danger' id='oui'>OUI</a>&nbsp&nbsp;<a class='btn btn-danger' id='non'>NON</a></p>";
      
      $("#afficheMessage").css("display","block").html(message);
      
      $("#non").click(function(){
        $("#afficheMessage").css("display","none");
      });

      $("#oui").click(function(){
         var envoi=$.post('removeWork.php',{id:id});
          envoi.done(function(data) {
          location.reload();

          });
          return false; 
        });
	};	
$(document).ready(function() {
        var table = $('#example').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal( {
                        header: function ( row ) {
                            var data = row.data();
                            return 'Details for '+data[0];

                    		$('.ui-dialog-content').find('div.supp').on('click', function(){
                    			console.log('modal click');
                    		});
                        }
                    } ),
                    ///renderer: $.fn.dataTable.Responsive.renderer.tableAll()
                    renderer: function ( api, rowIdx, columns ) {
                        var data = $.map( columns, function ( col, i ) {
                        	if(i != columns.length - 1){
								return '<tr>'+
			                                '<td>'+col.title+':'+'</td> '+
			                                '<td>'+col.data+'</td>'+
			                            '</tr>';
                            }
                            else{
                               var id, name;
                               id =	  $($.parseHTML(col.data)).attr('id');
                               name = "'" + $($.parseHTML(col.data)).attr('name')+"'";
                                console.log($($.parseHTML(col.data)[0]).attr('name'));
	                            return '<tr>'+
	                                    '<td>'+col.title+':'+'</td> '+
	                                    '<td onclick="javascript:suppclick('+id+','+ name + ');">'+col.data+'</td>'+
	                                '</tr>';
                            }
                        } ).join('');
     
                        return $('<table/>').append( data );
                    }
                }
            }
        } );
         
        $('.supp').click(function() {
           var id=$(this).attr("id");
           var name=$(this).siblings(".name").attr("id");
          // alert(name);
           var message="<p>Voulez-vous vraiment supprimer cet employé : '"+name+"'&nbsp;? <a class='btn btn-danger' id='oui'>OUI</a>&nbsp&nbsp;<a class='btn btn-danger' id='non'>NON</a></p>";
            
            $("#afficheMessage").css("display","block").html(message);
            
            $("#non").click(function(){
              $("#afficheMessage").css("display","none");
            });

            $("#oui").click(function(){
               var envoi=$.post('removeWork.php',{id:id});
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
