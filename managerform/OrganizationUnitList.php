<?php include("header.php");
		$sql = "SELECT ORGANIZATION_UNIT.ORGANIZATION_UNIT_ID,ORGANIZATION_UNIT.PARENT_ORGANIZATION_UNIT_ID, ORGANIZATION_UNIT.NAME,ORGANIZATION_UNIT.DESCRIPTION,ORGANIZATION_UNIT_TYPE.NAME AS TYPENAME, 
		ORGANIZATION_UNIT.IS_LEGAL_ENTITY, 
ORGANIZATION_UNIT.ACTIVE_FROM,ORGANIZATION_UNIT.ACTIVE_TO, SCHEDULE.NAME AS SCHEDULE_NAME, concat(ADDRESS.STREET, ' ', ADDRESS.STREETNR, ' ', ADDRESS.CITY, ' ', 
ADDRESS.STATE, ' ', ADDRESS.COUNTRY) AS ADDRESS
 FROM ORGANIZATION_UNIT LEFT JOIN ORGANIZATION_UNIT_TYPE
 ON  ORGANIZATION_UNIT.ORGANIZATION_UNIT_TYPE_ID =ORGANIZATION_UNIT_TYPE.ORGANIZATION_UNIT_TYPE_ID  
 LEFT JOIN ADDRESS ON ORGANIZATION_UNIT.ADDRESS_ID = ADDRESS.ADDRESS_ID
 LEFT JOIN SCHEDULE ON ORGANIZATION_UNIT.SCHEDULE_ID = SCHEDULE.SCHEDULE_ID";
        $req=mysqli_query($connect,$sql);
        $compte=$req->num_rows;
		/*$result = array();
		$start = array();
		while($row=$req->fetch_assoc()){
			$result[] = $row;
			if($row['ORGANIZATION_UNIT_ID'] == ''){
				$start = $row;
			};
		}
		$new_result = array();
		
		$new = array();
		foreach ($result as $a){
		    $new[$a['PARENT_ORGANIZATION_UNIT_ID']][] = $a;
		}
		$tree = createTree($new, array($arr[0]));
				
		
		function createTree(&$list, $parent){
		    $tree = array();
		    foreach ($parent as $k=>$l){
		        if(isset($list[$l['ORGANIZATION_UNIT_ID']])){
		            $l['children'] = createTree($list, $list[$l['ORGANIZATION_UNIT_ID']]);
		            $new_result[] = $l['children'];
		        }
		        $tree[] = $l;
		    } 
		    return $tree;
		}*/
		/*sortTree($start, $compte);
		function sortTree($start ,$num){
			global $new_result, $result;
			$new_result[] = $start;
			for($i = 0; $i <= $num; $i++){
				
				if($result[$i]['PARENT_ORGANIZATION_UNIT_ID'] == $start['ORGANIZATION_UNIT_ID']) sortTree($result[$i], $num);
			}
		}*/
      ?>
      <hr class="style_one"/>
    <div id='wrapper'>
     
    
      <section id='content'>
        <div class='container'>
         
              <div class='row'>
                <div class='col-sm-12'>
                  <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                    <div class='box-header red-background'>
                       <div class='title'><p>Organizations</p>
                        <div class='actions'>
                          <a class="btn btn-md btn-link" style="float:right;" href="../Accueil.php" title="Retour au Manager"><i class='icon-home' ></i> Retour au Manager</a>
                          <a class="btn btn-md btn-link" href="OrganizationUnitAdd.php"><i class='icon-plus' ></i> Ajouter</a>
                        </div>
                
                      </div>
					  
                    </div>
                    <div class='box-content'>
                      <div class='responsive-table'>
                          <div class='col-sm-12' id='afficheMessage'></div>
                        <div class='scrollable-area'>
                          <table id="treetable" class='table table-bordered' style='margin-bottom:0; width:100% !important;'>
                            <thead>
                              <tr>
	                              <th>Nom</th>
	                              <th>Organization Type</th>
	                              <th>NAME</th>
	                              <th>DESCRIPTION</th>
	                              <th>IS_LEGAL_ENTITY</th>
	                              <th>ADDRESS</th>
	                              <th>ACTIVE_FROM</th>
	                              <th>ACTIVE_TO</th>
	                              <th>SCHEDULE</th>
	                              <th>Modifier</th>
	                              <th>Supprimer</th>
                              </tr>
                            </thead>
							<tbody>
								 <?php $i = 0; while($row = $req->fetch_assoc()): $i++;?>
                            	<tr data-tt-id = "<?php echo $row['ORGANIZATION_UNIT_ID'];?>" data-tt-parent-id="<?php echo $row['PARENT_ORGANIZATION_UNIT_ID'];?>">
                            	
                            		<td><?php echo $i;?></td>
                            		<td><?php echo $row['TYPENAME'];?></td>
                            		<td><?php echo $row['NAME'];?></td>
                            		<td><?php echo $row['DESCRIPTION'];?></td>
                            		<td><?php echo $row['IS_LEGAL_ENTITY'];?></td>
                            		<td><?php echo $row['ADDRESS'];?></td>
									<td><?php echo $row['ACTIVE_FROM'];?></td>
									<td><?php echo $row['ACTIVE_TO'];?></td>
									<td><?php echo $row['SCHEDULE_NAME'];?></td>
									
									 <td>
	                                  <div class="text-right">
	                                    <a class="btn btn-warning btn-xs icon-a" href="OrganizationUnitMod.php?id_mod=<?php echo $row['ORGANIZATION_UNIT_ID']; ?>">
	                                      <i class="icon-edit"></i>
	                                    </a>
	                                  </div>
	                                </td>
	                                 <td >
	                                  <div class="text-right supp" id="<?php echo $row['ORGANIZATION_UNIT_ID'];?>"  name="<?php echo $row['NAME'];?>" >
	                                      <a class="btn btn-danger btn-xs icon-a" >
	                                        <i class="icon-remove remove"></i>
	                                      </a>
	                                  </div>
	                                </td>
                            	</tr>
                            	<?php endwhile;?>
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
	<script src="../js/jquery.treetable.js" type="text/javascript"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.jqueryui.min.js" type="text/javascript"></script>
     <script type="text/javascript">
     function suppclick(id, name){
         // alert(name);
          var message="<p>Voulez-vous vraiment supprimer cet Organisation : '"+name+"'&nbsp;? <a class='btn btn-danger' id='oui'>OUI</a>&nbsp&nbsp;<a class='btn btn-danger' id='non'>NON</a></p>";
           
           $("#afficheMessage").css("display","block").html(message);
           
           $("#non").click(function(){
             $("#afficheMessage").css("display","none");
           });

           $("#oui").click(function(){
              var envoi=$.post('removeOrg.php',{id:id});
               envoi.done(function(data) {
               location.reload();

               });
               return false; 
             });
  	};	
   $(document).ready(function() {
	 	$('#treetable').DataTable( {
	        responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal( {
                        header: function ( row ) {
                            var data = row.data();
                            return 'Details for '+data[2];

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
	           var message="<p>Voulez-vous vraiment supprimer cet organisation : '"+name+"'&nbsp;? <a class='btn btn-danger' id='oui'>OUI</a>&nbsp&nbsp;<a class='btn btn-danger' id='non'>NON</a></p>";
	            
	            $("#afficheMessage").css("display","block").html(message);
	            
	            $("#non").click(function(){
	              $("#afficheMessage").css("display","none");
	            });

	            $("#oui").click(function(){
	               var envoi=$.post('removeOrg.php',{id:id});
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
