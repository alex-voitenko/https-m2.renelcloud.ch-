  <?php include("header.php");
  	// Collaborator Name for auto-complete 
  	$sql_collaborator = "SELECT * FROM UI_COLLABORATOR";
  	$req_collaborator = mysqli_query($connect, $sql_collaborator);
    //$collaborator_json = json_encode($req_collaborator->toArray());
    $result = array();
    if($req_collaborator){
    	while($data = $req_collaborator->fetch_assoc()){
    		$row = array();
    		$row['value'] = $data['FULL_NAME'];
    		$row['id'] = $data['COLLABORATOR_ID'];
    		$result[] = $row;
    	}
    }
    //print_r($result);
    $collaborator_json = json_encode($result);
    
    
  	$sql = "SELECT * FROM Rep_horaires";
  	$sql_schedule = "SELECT * FROM UI_SCHEDULE";
  	
  	
  	$req_schedule = mysqli_query($connect, $sql_schedule);
  	$sql_workstamp = "SELECT * FROM UI_WORKSTAMP_TYPES";
    $req_workstamp = mysqli_query($connect,$sql_workstamp);
  	$sql_organization= "SELECT * FROM UI_ORGANIZATION_UNITS";
  	$req_organization = mysqli_query($connect, $sql_organization);
  	$schedule_id = 0;
  	$date_start = '';
  	$date_end = '';
  	$workstamp_type = 0;
  	$respect_horaire = '0';
  	$organization_unit = 0;
  	$collaborator_name ='';
  	$distance_km = 0;
  	$respect_localization = 25;
  	$percent_localization = 20;
  	$type_respect_localization = "All";
  	if(!empty($_POST)){
    	$where = '';
		$schedule_id = $_POST['schedule'];
		//print $schedule_id;
		if(isset($schedule_id) && $schedule_id > 0) $where = $where."`SCHEDULE_ID` = ".$schedule_id;
		
		$date_start = $_POST['start'];
		
		if($date_start !=''){
			//list($day) = explode(":", $data);
			$number = str_replace("-","",$date_start);
			//print $number;
			if($where !='' ) $where = $where." AND `DATE_ID` >= ".intval($number);
			else $where = $where."`DATE_ID` >= ".intval($number);
		}
		
    	$date_end = $_POST['end'];
		
		if($date_end !=''){
			//list($day) = explode(":", $data);
			$number = str_replace("-","",$date_end);
			//print $number;
			if($where !='' ) $where = $where." AND `DATE_ID` <= ".intval($number);
			else $where = $where."`DATE_ID` >= ".intval($number);
		}
		$collaborator_name = $_POST['collaborator'];
		if($collaborator_name !=''){
			if($where!=''){
				$where = $where." AND CONCAT( `LASTNAME`,  ' ', `FIRSTNAME` ) LIKE  '%".$collaborator_name."%'";
			}
			else $where = $where."CONCAT(`LASTNAME`,  ' ', `FIRSTNAME` ) LIKE  '%".$collaborator_name."%'";
		}
		
		$workstamp_type = $_POST['workstamp_type'];
		if($workstamp_type !='0'){
			if($where !=''){
				$where = $where." AND `WORKSTAMP_TYPE_ID` = ".$workstamp_type;
			}
			else $where = "`WORKSTAMP_TYPE_ID` = ".$workstamp_type;
		
		}
		
   		$respect_horaire = $_POST['respect_horaire'];
		if($respect_horaire !='0'){
			if($where !=''){
				$where = $where." AND `RESPECT_HORAIRE` = '".$respect_horaire."'";
			}
			else $where = "`RESPECT_HORAIRE` = '".$respect_horaire."'";
		
		}
		
    	$organization_unit = $_POST['organization_unit'];
		if($organization_unit !=0){
			if($where !=''){
				$where = $where." AND `ORGANIZATION_UNIT_ID` = ".$organization_unit;
			}
			else $where = "`ORGANIZATION_UNIT_ID` = ".$organization_unit;
			
		}
		
		$distance_km = $_POST['distance_km'];
		
		if($where == ''){
			$sql = "SELECT * FROM Rep_horaires ORDER BY `SCHEDULE_NAME`, `DATE_ID`";;
		}
    	else{
    		$sql = "SELECT * FROM  Rep_horaires WHERE ".$where." ORDER BY `SCHEDULE_NAME`, `DATE_ID`";
    	}
    	$respect_localization = $_POST['respect_localization'];
  		$percent_localization = $_POST['percent_localization'];
  		$type_respect_localization = $_POST['type_respect_localization'];
  		
  	}
  		
   	//print $sql;
     $req=mysqli_query($connect,$sql); 
    
  ?>
  <style>
 	.ui-autocomplete{
		background-color: white;
    	border: 1px solid #7f7f7f;
    	border-radius: 5px;
	}
  </style>
     <hr class="style_one"/>
    <div id='wrapper'>
    	
      <section id='content'>
        <div class='container'>
         
              <div class='row'>
                <div class='col-sm-12'>
                  <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                    <div class='box-header red-background'>
                      <div class='title'><p>Rapport RH</p>
                        <div class='actions'>
                          <a class="btn btn-md btn-link" style="float:right;" href="../Rapports.php" title="Retour au Rapports"><i class='icon-home' ></i>  Retour au Rapports</a>
                          <button class="btn btn-md btn-link" style="display:inline-block !important;font-size: 0.8em !important; float:right;" title="Retour au Reports"  id="search-button"a><i class='icon-search' ></i>  Chercher</a>
                        
                        </div>
                
					            </div>
                    </div>
                    <div class='box-content'>
                    	<div class="row">
	                    	<form class="form" method="post" action="RepHoraire.php" id="search-form">
	                    		<div class="col-sm-4">
		                    		<div class="form-group">
		                    			<label for='inputText'>Organisation </label> 
						                 <select class="form-control" name="organization_unit">
						                 	<option value="0" <?php if($organization_unit == 0) echo "selected";?> >**TOUS**</option>>
						                 	<?php if($req_organization):while($row=$req_organization->fetch_assoc()):?>
			                    			<option value="<?php echo $row['ORGANIZATION_UNIT_ID'];?>"  <?php if($organization_unit == $row['ORGANIZATION_UNIT_ID']) echo "selected";?>  ><?php echo $row['ORGANIZATION_NAME'];?></option>
			                    			<?php endwhile;endif;?>
						                 </select>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-4">
		                    		<div class="form-group">
		                    			<label for='inputText'>Nom collaborateur</label> 
						                   <!-- <div class="datepicker-input input-group" id="datepicker">-->
						                      <input class="form-control" type="text" id = "collaborator_name" name = "collaborator" value="<?php echo $collaborator_name;?>" />
						                    <!-- </div>-->
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-4">
		                    		<div class="form-group">
		                    			<label for="inputText">Defined Respect_Localization</label>
		                    			<select class="form-control" name="respect_localization">
		                    				<option value="10">10m</option>
		                    				<?php for($i = 25; $i < 100; $i+=25):?>
		                    				<option value = "<?php echo $i;?>" <?php if($respect_localization == $i) echo "selected"?>><?php echo $i;?>m</option>
		                    				<?php endfor;?>
		                    				<?php for($i = 100; $i < 300; $i+=50):?>
		                    				<option value = "<?php echo $i;?>" <?php if($respect_localization == $i) echo "selected"?> ><?php echo $i;?>m</option>
		                    				<?php endfor;?>
		                    				<?php for($i = 300; $i <= 500; $i+=100):?>
		                    				<option value = "<?php echo $i;?>" <?php if($respect_localization == $i) echo "selected"?> ><?php echo $i;?>m</option>
		                    				<?php endfor;?>
		                    				<?php for($i = 1000; $i < 4000; $i+=1000):?>
		                    				<option value = "<?php echo $i;?>" <?php if($respect_localization == $i) echo "selected"?> ><?php echo $i / 1000;?>Km</option>
		                    				<?php endfor;?>
		                    				<?php for($i = 5000; $i < 30000; $i+=5000):?>
		                    				<option value = "<?php echo $i;?>" <?php if($respect_localization == $i) echo "selected"?> ><?php echo $i / 1000;?>Km</option>
		                    				<?php endfor;?>
		                    				<?php for($i = 30000; $i <= 100000; $i+=10000):?>
		                    				<option value = "<?php echo $i;?>" <?php if($respect_localization == $i) echo "selected"?> ><?php echo $i / 1000;?>Km</option>
		                    				<?php endfor;?>
		                    				
		                    			</select>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-4">
		                    		<div class="form-group">
		                    			<label for="inputText">Type horaire</label>
			                    		<select class="form-control" name="schedule">
			                    			<option value="0" <?php if($schedule_id == 0) echo "selected";?>>**TOUS**</option>
			                    			<?php if($req_schedule):while($row=$req_schedule->fetch_assoc()):?>	
			                    				<option value="<?php echo $row['SCHEDULE_ID'];?>" <?php if($schedule_id == $row['SCHEDULE_ID']) echo "selected"; ?> ><?php echo $row['SCHEDULE_NAME'];?></option>
			                    			<?php endwhile;endif;?>
			                    		</select>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-2">
		                    		<div class="form-group">
		                    			<label for='inputText'>Date début </label> 
						                   <div class="datepicker-input input-group" id="datepicker">
						                      <input id="date_debut" class="form-control" data-format="YYYY-MM-DD" name="start" value="<?php echo $date_start;?>">
						                   
						                      <span class="input-group-addon">
						                        <span data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar"></span>
						                      </span>
						                    </div>
		                    			
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-2">
		                    		<div class="form-group">
		                    			<label for='inputText'>Date Fin </label> 
						                   <div class="datepicker-input input-group" id="datepicker2">
						                      <input  id="date_fin" class="form-control" data-format="YYYY-MM-DD" name="end" value="<?php echo $date_end;?>">
						                      <span class="input-group-addon">
						                        <span data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar"></span>
						                      </span>
						                    </div>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-4">
		                    		<div class="form-group">
		                    			<label for="inputText">Percent for Respect_Localization</label>
		                    			<select class="form-control" name="percent_localization">
		                    				<?php for($i = 10; $i <= 100; $i+=10):?>
		                    				<option value = "<?php echo $i;?>" <?php if($percent_localization == $i) echo "selected";?> ><?php echo $i;?>%</option>
		                    				<?php endfor;?>
		                    				
		                    			</select>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-4">
		                    		<div class="form-group">
		                    			<label for='inputText'>Type timbrage </label> 
						                 <select class="form-control" name="workstamp_type">
						                 	<option value="0" <?php if($workstamp_type == 0) echo "selected";?> >**TOUS**</option>	
						                 	<?php if($req_workstamp):while($row=$req_workstamp->fetch_assoc()):?>
			                    			<option value="<?php echo $row['WORKSTAMP_TYPE_ID'];?>" <?php if($workstamp_type == $row['WORKSTAMP_TYPE_ID']) echo "selected"; ?> ><?php echo $row['WORKSTAMP_TYPE'];?></option>
			                    			<?php endwhile;endif;?>
						                 </select>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-4">
		                    		<div class="form-group">
		                    			<label for='inputText'>Respect Horaires </label> 
						                 <select class="form-control" name="respect_horaire">
						                 	<option value="0" <?php if($respect_horaire == '0') echo "selected"; ?> >**TOUS**</option>
			                    			<option value="ROUGE" <?php if($respect_horaire == 'ROUGE') echo "selected"; ?> >ROUGE</option>
			                    			<option value="VERT" <?php if($respect_horaire == 'VERT') echo "selected"; ?> >VERT</option>
			                    			<option value="ORANGE" <?php if($respect_horaire == 'ORANGE') echo "selected"; ?>  >ORANGE</option>
						                 </select>
		                    		</div>
		                    	</div>

		                    	
		                    	
		                    	
		                    	
		                    	<!-- respect localization and traffic lights -->
		                    	<div class="col-sm-4">
		                    		<div class="form-group">
		                    			<label for="inputText">Type of Respect_Localization</label>
		                    			<select class="form-control" name="type_respect_localization">
						                 	<option value="All" <?php if($respect_horaire == 'All') echo "selected"; ?> >**TOUS**</option>
			                    			<option value="red" <?php if($type_respect_localization == 'red') echo "selected"; ?> >ROUGE</option>
			                    			<option value="green" <?php if($type_respect_localization == 'green') echo "selected"; ?> >VERT</option>
			                    			<option value="yellow" <?php if($type_respect_localization == 'yellow') echo "selected"; ?>  >ORANGE</option>
						                 </select>
		                    		</div>
		                    	</div>
	                    	</form>
	                    </div>
                      <div class='responsive-table'>
                        <div class='col-sm-12' id='afficheMessage'></div>
                        <div class='scrollable-area'>
                          <table id="example" class='data-table-column-filter table table-bordered' style='width:100% !important;margin-bottom:0;'>
                            <thead>
                             <tr>
                             	<th>#</th>
                             	<th>ORGANISATION</th>
                             	<th>TYPE HORAIRE</th>
                             	<th>TYPE TIMBRAGE</th>
                             	<th>PRENOM</th>
                             	<th>NOM</th>
                             	<th>DATE</th>
                             	
								<th>HEURE</th>
                             	<th>TIMBRAGE</th>
                             	<th>DIFFERENCE</th>
                             	<th>H</th>
                             	<th>SITE NAME</th>
                             	<th>DISTANCE_KM</th>
                             	<th>L</th>
                             	
                             	
<!--							<th>COLLABORATOR_ID</th>
								
								<th>SCHEDULE NAME</th>
                             	<th>LASTNAME</th>
                             	<th>FIRSTNAME</th>
                             	<th>DAY_STAMP</th>
                             	<th>WORK_STAMP </th>
                             	<th>TIME_STAMP </th>
                             	<th>VALID_START_TIME </th>
                             	<th>VALID_END_TIME</th>
                             	<th>WITHIN SCHEDULE </th>
                             	<th>COLLABORATOR_ID</th>
-->
                             </tr>
                            </thead>
                            <tbody>
                    <?php  
                           //print_r($req);
                           if($req):$i=0;
                    while($data=$req->fetch_assoc()):$i++;
                    	$distance_m = $data['DISTANCE_KM'] * 1000;
                    	$imagename = "red";
						if($distance_m <= $respect_localization) $imagename =  "green";
						else if($distance_m > $respect_localization && $distance_m <= (100 + $percent_localization) * $respect_localization / 100)
						$imagename= "yellow";
						else $imagename =  "red";
						if($type_respect_localization == "All" || $imagename == $type_respect_localization):
						
                   	?>
				
                         <tr>
                         	<td><?php echo $i;?></td>
                         	<td><?php echo $data['ORGANIZATION_NAME'];?></td>
                         	<td><?php echo $data['SCHEDULE_NAME'];?></td>
                         	<td><?php echo $data['WORKSTAMP_NAME'];?></td>
                         	<td><?php echo $data['LASTNAME'];?></td>
                         	<td><?php echo $data['FIRSTNAME'];?></td>
                         	<td><?php echo $data['DAY_STAMP'];?></td>
 
                         	
                         	
							<td><?php echo $data['VALID_START_TIME'];?></td>
                         	<td><?php echo $data['TIME_STAMP'];?></td>
                         	<td><?php echo $data['DELTA_DISPLAY'];?></td>
                         	
							<td>
								<img src="../images/<?php if($data['RESPECT_HORAIRE'] == "ROUGE") echo "red"; else if ($data['RESPECT_HORAIRE'] == "VERT") echo "green"; else echo "yellow"?>.png" width="30px" height="30px"	>					
							</td>
							<td><?php echo $data['SITE_NAME'];?></td>
							<td><?php echo number_format($data['DISTANCE_KM'], 3);?></td>
							<td>
								<img src="../images/
								<?php 
								echo $imagename;
								?>.png"
								 width="30px" height="30px"	>					
							</td>
                         	
                         </tr>
						
                      <?php 
                      endif;
                      endwhile;
                      endif; 
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
    <input type="hidden" id="collaborator_json" value='<?php echo $collaborator_json;?>' />
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
    <!-- / theme file [required] -->
    <script src="assets/javascripts/theme.js" type="text/javascript"></script>
	<script src="assets/javascripts/plugins/fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/select2/select2.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/datatables/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script> 
   <!--  <script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script> -->
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.jqueryui.min.js" type="text/javascript"></script>
    <script type="text/javascript">

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
    });
     
    
} );
    $(document).ready(function(){

        $('#datepicker').on("changeDate", function() {
            $('#date_debut').val(
                $('#datepicker').datepicker('getFormattedDate')
            );
        });
        /*
        $('#collaborator_name').autocomplete({
            
			source:"CollaboratorName.php",
	      	select: function( event, ui ) {
		      	
		          if(ui.item.id == 0){
			          alert("Please select correct Collaborator Name");
		          }
		          else{
			          $('#collaborator_name').val(ui.item.value);
		          }
		          
	      		 $('#collaborator_name').val(ui.item.value);
	        }
        });
    */
       
     });
     $(document).ready(function(){

        $('#datepicker2').on("changeDate", function() {
            $('#date_fin').val(
                $('#datepicker2').datepicker('getFormattedDate')
            );	
        });
     });
     
 
     $(document).ready(function(){
         var jsonData = JSON.parse($('#collaborator_json').val());
	       $( "#collaborator_name" ).autocomplete({
		       source: jsonData,
		       autofocus: true,
		       select: function(event, ui) {
			       
		       }
	       });
           $('#search-button').on('click', function(){
               $('#search-form').submit();    	
           });                  
                           
                            
     });
     

     </script>
  
  </body>

</html>
