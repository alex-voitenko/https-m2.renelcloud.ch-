<?php include("header.php");
		$sql = "SELECT SCHEDULE.SCHEDULE_ID, SCHEDULE.NAME, SCHEDULE.DESCRIPTION ,
				COUNT(CASE WHEN SCHEDULE_EVENT.DAY_OF_WEEK = 1 THEN 1 END) AS DAY1, 
				COUNT(CASE WHEN SCHEDULE_EVENT.DAY_OF_WEEK = 2 THEN 1 END) AS DAY2,
				COUNT(CASE WHEN SCHEDULE_EVENT.DAY_OF_WEEK = 3 THEN 1 END) AS DAY3,
				COUNT(CASE WHEN SCHEDULE_EVENT.DAY_OF_WEEK = 4 THEN 1 END) AS DAY4,
				COUNT(CASE WHEN SCHEDULE_EVENT.DAY_OF_WEEK = 5 THEN 1 END) AS DAY5,
				COUNT(CASE WHEN SCHEDULE_EVENT.DAY_OF_WEEK = 6 THEN 1 END) AS DAY6,
				COUNT(CASE WHEN SCHEDULE_EVENT.DAY_OF_WEEK = 7 THEN 1 END) AS DAY7
				FROM SCHEDULE 
				LEFT JOIN SCHEDULE_EVENT ON SCHEDULE.SCHEDULE_ID = SCHEDULE_EVENT.SCHEDULE_ID
				
				GROUP BY SCHEDULE.SCHEDULE_ID ORDER BY SCHEDULE.SCHEDULE_ID";
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
                       <div class='title'><p>Horaires</p>
                        <div class='actions'>
                          <a class="btn btn-md btn-link" style="float:right;" href="../Accueil.php" title="Retour au Manager"><i class='icon-home' ></i> Retour au Manager</a>
                          <a class="btn btn-md btn-link" href="ScheduleAdd.php"><i class='icon-plus' ></i> Ajouter</a>
                        </div>
                
                      </div>
					  
                    </div>
                    <div class='box-content'>
                      <div class='responsive-table'>
                          <div class='col-sm-12' id='afficheMessage'></div>
                        <div class='scrollable-area'>
                          <table id="table" class='table table-bordered' style='margin-bottom:0; width:100% !important;'>
                            <thead>
                              <tr>
	                              <th>#</th>
	                              <th>NAME</th>
	                              <th>DESCRIPTION</th>
	                              <th>DAY1</th>
	                              <th>DAY2</th>
	                              <th>DAY3</th>
	                              <th>DAY4</th>
	                              <th>DAY5</th>
	                              <th>DAY6</th>
	                              <th>DAY7</th>
	                              <th>Modifier</th>
	                              <th>Supprimer</th>
                              </tr>
                            </thead>
							<tbody>
								 <?php 
								 	$i = 0; if($req): while($row = $req->fetch_assoc()): $i++;
								 ?>
                            	<tr>
                            	
                            		<td><?php echo $i;?></td>
                            		<td><?php echo $row['NAME'];?></td>
                            		<td><?php echo $row['DESCRIPTION'];?></td>
                            		<td <?php if($row['DAY1'] == 0) echo "class = 'unchecked-horaire'";?>><?php if($row['DAY1'] > 0) echo "<img src = '../images/checked.png' width='30px' height='30px'>"?></td>
                            		<td <?php if($row['DAY2'] == 0) echo "class = 'unchecked-horaire'";?>><?php if($row['DAY2'] > 0) echo "<img src = '../images/checked.png' width='30px' height='30px'>"?></td>
									<td <?php if($row['DAY3'] == 0) echo "class = 'unchecked-horaire'";?>><?php if($row['DAY3'] > 0) echo "<img src = '../images/checked.png' width='30px' height='30px'>"?></td>
									<td <?php if($row['DAY4'] == 0) echo "class = 'unchecked-horaire'";?>><?php if($row['DAY4'] > 0) echo "<img src = '../images/checked.png' width='30px' height='30px'>"?></td>
									<td <?php if($row['DAY5'] == 0) echo "class = 'unchecked-horaire'";?>><?php if($row['DAY5'] > 0) echo "<img src = '../images/checked.png' width='30px' height='30px'>"?></td>
									<td <?php if($row['DAY6'] == 0) echo "class = 'unchecked-horaire'";?>><?php if($row['DAY6'] > 0) echo "<img src = '../images/checked.png' width='30px' height='30px'>"?></td>
									<td <?php if($row['DAY7'] == 0) echo "class = 'unchecked-horaire'";?>><?php if($row['DAY7'] > 0) echo "<img src = '../images/checked.png' width='30px' height='30px'>"?></td>
									
									 <td>
	                                  <div class="text-right">
	                                    <a class="btn btn-warning btn-xs icon-a" href="ScheduleMod.php?id_mod=<?php echo $row['SCHEDULE_ID']; ?>">
	                                      <i class="icon-edit"></i>
	                                    </a>
	                                  </div>
	                                </td>
	                                 <td>
	                                  <div class="text-right supp" id="<?php echo $row['SCHEDULE_ID'];?>" name="<?php echo $row['NAME'];?>">
	                                      <a class="btn btn-danger btn-xs icon-a" >
	                                        <i class="icon-remove remove"></i>
	                                      </a>
	                                  </div>
	                                </td>
                            	</tr>
                            	<?php endwhile; endif;?>
								<!--  <tr data-tt-id="1">
									<td>1</td>
									<td>sdfjsld</td>
									<td>sdfjsld</td>
									<td>sdfjsld</td>
									<td>sdfjsld</td>
									<td>sdfjsld</td>
									<td>sdfjsld</td>
									<td>sdfjsld</td>
									<td>sdfjsld</td>
								</tr>
								<tr data-tt-id="2" data-tt-parent-id="1">
									<td>2</td>
									<td>akdjf</td>
									<td>akdjf</td>
									<td>akdjf</td>
									<td>akdjf</td>
									<td>akdjf</td>
									<td>akdjf</td>
									<td>akdjf</td>
									<td>akdjf</td>
								</tr>-->

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
	<!-- jquery treetable -->
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
              var envoi=$.post('removeSch.php',{id:id});
               envoi.done(function(data) {
               location.reload();

               });
               return false; 
             });
  	};	
   $(document).ready(function() {

	 	$('#table').DataTable({
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
           var name=$(this).attr("name");
          // alert(name);
           var message="<p>Voulez-vous vraiment supprimer cet horaire : '"+name+"'&nbsp;? <a class='btn btn-danger' id='oui'>OUI</a>&nbsp&nbsp;<a class='btn btn-danger' id='non'>NON</a></p>";
            
            $("#afficheMessage").css("display","block").html(message);
            
            $("#non").click(function(){
              $("#afficheMessage").css("display","none");
            });

            $("#oui").click(function(){
               var envoi=$.post('removeSch.php',{id:id});
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
