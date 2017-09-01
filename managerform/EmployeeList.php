<?php include("header.php");
		$sql = "SELECT
		COLLABORATOR.COLLABORATOR_ID,COLLABORATOR.COLLABORATOR_TYPE_ID, COLLABORATOR.GENDER_ID, COLLABORATOR.MANAGER_ID, COLLABORATOR_TYPE.NAME AS TYPE_NAME, 
		COLLABORATOR.LASTNAME,
		COLLABORATOR.FIRSTNAME, COLLABORATOR.EMAIL, COLLABORATOR.PASSWORD, COLLABORATOR.MOBILENR, COLLABORATOR.IMEI, COLLABORATOR.IMEI_S, COLLABORATOR.UUID,
		COLLABORATOR.COST, COLLABORATOR.PICTURE_URL,COLLABORATOR.APP_ADMIN, COLLABORATOR.SCHEDULE_ID, ORGANIZATION_UNIT.NAME AS ORGANIZATION_NAME,
		COLLABORATOR.ORGANIZATION_UNIT_ID, SCHEDULE.NAME AS SCHEDULE_NAME
		FROM COLLABORATOR 
		LEFT JOIN COLLABORATOR_TYPE ON COLLABORATOR_TYPE.COLLABORATOR_TYPE_ID = COLLABORATOR.COLLABORATOR_TYPE_ID
		LEFT JOIN ORGANIZATION_UNIT ON ORGANIZATION_UNIT.ORGANIZATION_UNIT_ID = COLLABORATOR.ORGANIZATION_UNIT_ID
		LEFT JOIN SCHEDULE ON COLLABORATOR.SCHEDULE_ID = SCHEDULE.SCHEDULE_ID";
        $req=mysqli_query($connect,$sql);
        $compte=$req->num_rows;


      ?>
      <hr class="style_one"/>
    <div id='wrapper'>
     
    
      <section id='content'>
        <div class='container'>
         
              <div class='row'>
                <div class='col-sm-12'>
                  <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                    <div class='box-header red-background'>
                       <div class='title'><p>Collaborateurs</p>
                        <div class='actions'>
                          <a class="btn btn-md btn-link" style="float:right;" href="../Accueil.php" title="Retour au Manager"><i class='icon-home' ></i> Retour au Manager</a>
                          <a class="btn btn-md btn-link" href="EmployeeAdd.php"><i class='icon-plus' ></i> Ajouter</a>
                        </div>
                
                      </div>
					  
                    </div>
                    <div class='box-content'>
                      <div class='responsive-table'>
                          <div class='col-sm-12' id='afficheMessage'></div>
                        <div class='scrollable-area'>
                          <table id="example" class='data-table-column-filter table table-bordered table-striped' style='margin-bottom:0;width:100% !important;'>
                            <thead>
                              <tr><th>Nom</th><th>Type</th><th> Email</th><th>Schedule_Name</th><th>Organization_unit</th><th>APP_Admin</th><th>Modifier</th><th>Supprimer</th></tr>
                            </thead>
                            <tbody>
                              <?php
                              while($data=$req->fetch_assoc()):
                                $id=$data["COLLABORATOR_ID"];?>
                                <tr>
                                	<td class="name" id="<?php echo $data['FIRSTNAME'].' '.$data['LASTNAME'];?>" ><?php echo $data["FIRSTNAME"]." ".$data["LASTNAME"]; ?> </td>
                                	<td><?php echo $data["TYPE_NAME"]; ?> </td>
                                	<td><?php echo $data["EMAIL"]; ?></td>
                                	<td><?php echo $data["SCHEDULE_NAME"]?></td>
                               		<td><?php echo $data['ORGANIZATION_NAME'];?></td>
                               		<td><?php if($data['APP_ADMIN'] == 1) echo "YES"; else echo "NO"?></td>
	                               <td>
	                                  <div class="text-right">
	                                    <a class="btn btn-warning btn-xs icon-a" href="EmployeeEdit.php?id=<?php echo $id; ?>">
	                                      <i class="icon-edit"></i>
	                                    </a>
	                                  </div>
	                                </td>
	                                 <td >
	                                  <div class="text-right supp" name="<?php echo $data['FIRSTNAME']." ".$data['LASTNAME']; ?>" id="<?php echo $id;?>" >
	                                      <a class="btn btn-danger btn-xs icon-a" >
	                                        <i class="icon-remove remove"></i>
	                                      </a>
	                                  </div>
	                                </td>
                              	</tr>
                              
                             
							  <?php endwhile;?>           

                         

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
     <script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.jqueryui.min.js" type="text/javascript"></script>
    <!-- / END - page related files and scripts [optional] -->

     <script type="text/javascript">

     function suppclick(id, name){
         // alert(name);
          var message="<p>Voulez-vous vraiment supprimer cet employé : '"+name+"'&nbsp;? <a class='btn btn-danger' id='oui'>OUI</a>&nbsp&nbsp;<a class='btn btn-danger' id='non'>NON</a></p>";
           
           $("#afficheMessage").css("display","block").html(message);
           
           $("#non").click(function(){
             $("#afficheMessage").css("display","none");
           });

           $("#oui").click(function(){
              var envoi=$.post('removeEmp.php',{id:id});
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
                               name = "'" + $($.parseHTML(col.data)).attr('name') + "'";
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
        });
         
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
                var envoi=$.post('removeEmp.php',{id:id});
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
