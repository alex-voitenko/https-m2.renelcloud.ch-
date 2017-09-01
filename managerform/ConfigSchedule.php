
   
      <?php  include("header.php");
        if(isset($_GET["id_mod"])){
      		$id=$_GET["id_mod"];
      		if($id > 0){
				$get_days_sql = "SELECT `SCHEDULE_ID`,
					COUNT(CASE WHEN `DAY_OF_WEEK` = '1' THEN 1 END) AS DAY1,
					COUNT(CASE WHEN `DAY_OF_WEEK` = '2' THEN 1 END) AS DAY2,
					COUNT(CASE WHEN `DAY_OF_WEEK` = '3' THEN 1 END) AS DAY3,
					COUNT(CASE WHEN `DAY_OF_WEEK` = '4' THEN 1 END) AS DAY4,
					COUNT(CASE WHEN `DAY_OF_WEEK` = '5' THEN 1 END) AS DAY5,
					COUNT(CASE WHEN `DAY_OF_WEEK` = '6' THEN 1 END) AS DAY6,
					COUNT(CASE WHEN `DAY_OF_WEEK` = '7' THEN 1 END) AS DAY7 
					FROM `SCHEDULE_EVENT` WHERE `SCHEDULE_ID` = ".$id."  GROUP BY `SCHEDULE_ID`";
				$days_query = mysqli_query($connect, $get_days_sql);
				$current_days = $days_query->fetch_assoc();
				$get_config_sql = "SELECT SCHEDULE_ID, WORKSTAMP_TYPE_ID, START_TIME, BEFORE_TOLERANCE_MINUTES, AFTER_TOLERANCE_MINUTES,BEFORE_FORBIDDEN_MINUTES,AFTER_FORBIDDEN_MINUTES
				FROM `SCHEDULE_EVENT` WHERE `SCHEDULE_ID` = ".$id." GROUP BY WORKSTAMP_TYPE_ID";
				$config_query = mysqli_query($connect, $get_config_sql);
				//$current_config_data = $config_query->fetch_assoc();
      			$current_config_horaires = array(100);
				if($config_query){
		      		while($current_config_data = $config_query->fetch_assoc()){
		      			$row = array(
		      				"ST"=>$current_config_data['START_TIME'],
		      				"BT"=>$current_config_data['BEFORE_TOLERANCE_MINUTES'],
		      				"AT"=>$current_config_data['AFTER_TOLERANCE_MINUTES'],
		      				"BF"=>$current_config_data['BEFORE_FORBIDDEN_MINUTES'],
		      				"AF"=>$current_config_data['AFTER_FORBIDDEN_MINUTES']
		      			);
		      			$current_config_horaires[$current_config_data['WORKSTAMP_TYPE_ID']] = $row;
		      		}
		      	}
      		
      		}
      	}
      	$sql_schedules = "SELECT * FROM `SCHEDULE`";
      	$schedules = mysqli_query($connect, $sql_schedules);
      	if(isset($_POST["id"])){
      		$id = $_POST["id"];
      		$days = array(8);
	      		for($i = 0; $i < 8; $i++){
	      			$days[$i] = 0;
	      		}
	      		if(!empty($_POST['day_list'])){
	      			foreach ($_POST['day_list'] as $row_number){
	      				$days[$row_number] = 1;
	      			}
	      	}
      		$config_data = json_decode($_POST['config_data']);
      		//echo "</br>".count($config_data)."</br>";
      		//print_r($config_data);
	      		$config_horaires = array();
	      		$i = 0;
	      		//echo $config_data[0]->row_id;
	      		while($i < count($config_data)){
	      			$config_horaire = array(
	      				"workstamp_type_id"=>$config_data[$i]->row_id,
	      				"Start_Time"=>$config_data[$i]->value,
	      				"BT"=>$config_data[$i+1]->value,
	      				"AT"=>$config_data[$i+2]->value,
	      				"BF"=>$config_data[$i+3]->value,
	      				"AF"=>$config_data[$i+4]->value
	      			);
	      			$i+=5;
	      			$config_horaires[] = $config_horaire;
	      		}
	      		//echo "</br>";
	      		//print_r($config_horaires);
      			for($i = 1; $i < 8; $i++){
	      			 if($days[$i] == 1){
	      			 	//print_r($config_horaires);
	      			 	//echo "</br>".count($config_horaires)."</br>";
	      			 	//$j = 0;
	      			 	foreach($config_horaires as $config_row){
	      			 		//print_r($config_row);
		      			 	$tmp_sql = "SELECT * FROM `SCHEDULE_EVENT` WHERE `SCHEDULE_ID` = '$id' AND `DAY_OF_WEEK` = '$i' AND `WORKSTAMP_TYPE_ID` = '".$config_row['workstamp_type_id']."'";
		      			 	
		      			 	$tmp_rows = mysqli_query($connect, $tmp_sql);
		      			 	$compte=$tmp_rows->num_rows;
		      			 	if($compte == 0){
		      			 		$config_sql = "INSERT INTO `SCHEDULE_EVENT` (`SCHEDULE_ID`, `DAY_OF_WEEK`, `WORKSTAMP_TYPE_ID`, `START_TIME`,`BEFORE_TOLERANCE_MINUTES`, `AFTER_TOLERANCE_MINUTES`, `BEFORE_FORBIDDEN_MINUTES`, `AFTER_FORBIDDEN_MINUTES`)
		      			 		 VALUES ('$id', '$i', '".$config_row['workstamp_type_id']."', '".$config_row['Start_Time']."',  '".
		      			 		
		      			 		$config_row['BT']."', '".$config_row['AT']."', '".$config_row['BF']."', '".$config_row['AF']."')";
		      			 		
		      			 		//echo $config_sql."</br>";
		      			 		
		      			 	}
		      			 	else{
		      			 		$tmp_row = $tmp_rows->fetch_assoc();
		      			 		$schedule_event_id = $tmp_row['SCHEDULE_EVENT_ID'];
		      			 		$config_sql = "UPDATE `SCHEDULE_EVENT` SET `SCHEDULE_ID`='$id', `DAY_OF_WEEK`='$i', `WORKSTAMP_TYPE_ID`='".$config_row['workstamp_type_id'].
		      			 		"', `START_TIME`='".$config_row['Start_Time']."', 
		      			 		`BEFORE_TOLERANCE_MINUTES`='".$config_row['BT']."', `AFTER_TOLERANCE_MINUTES`='".$config_row['AT']."', `BEFORE_FORBIDDEN_MINUTES`='".
		      			 		$config_row['BF']."',
		      			 		 `AFTER_FORBIDDEN_MINUTES`='".$config_row['AF']."' WHERE `SCHEDULE_EVENT_ID`='$schedule_event_id';";
		      			 		//echo $config_sql."</br>";
		      			 	}
		      			 	
		      			 	//echo $config_sql."</br>"."day = ".$i."</br>".$j."</br>";
		      			 	mysqli_query($connect, $config_sql);
		      			 	//$j++;
	      			 	}
	      			 }
	      			 else{
	      			 	foreach($config_horaires as $config_row){
	      			 		//print_r($config_row);
		      			 	$tmp_sql = "SELECT * FROM `SCHEDULE_EVENT` WHERE `SCHEDULE_ID` = '$id' AND `DAY_OF_WEEK` = '$i'";
		      			 	
		      			 	$tmp_rows = mysqli_query($connect, $tmp_sql);
		      			 	
		      			 	$compte=$tmp_rows->num_rows;
		      			 	if($compte == 0){
		      			 		
		      			 	}
		      			 	else{
		      			 		while($tmp_row = $tmp_rows->fetch_assoc()){
		      			 			$schedule_event_id = $tmp_row['SCHEDULE_EVENT_ID'];
		      			 			$delete_config_sql= "DELETE FROM `SCHEDULE_EVENT` WHERE `SCHEDULE_EVENT_ID`='$schedule_event_id';";
		      			 			mysqli_query($connect, $delete_config_sql);
		      			 		}
		      			 	}
		      			 	//echo $config_sql."</br>";
		      			 	
	      			 	}
	      			 }
	      		}
	      		?><script type="text/javascript">
<!--
				location.href="ScheduleList.php";
//-->
</script><?php 
	      	
      	}
      	
		
      ?>
    
       <hr class="style_one"/>
      <section id='content'>
        <div class='container'>
        	<div class="row">
                <div class='col-sm-12'>
                  <div class='box'>
                    <div class='box-header red-background'>
                       <div class='title'><p>Config Horaires</p>
                          <a class="btn btn-danger btn-lg" style="float:right;" href="ScheduleList.php" title="Retour au tableau">Retour au tableau</a>
                          <hr class="style_two"/>
                      </div>
                      </div>
						<div class='box-content clearfix'>
                       <?php
                       if(!empty($message)){
                         echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                         echo "<p>".$message;
                         echo "</p></div>";
                       }
                        
                         ?>
				<form class="form" style="margin-bottom: 0;" id="config-horaire-form" method="post" action="ConfigSchedule.php" enctype="multipart/form-data" >
	                        <div class="col-sm-12">
	                        	<hr class="style_one"/>
					<input type="hidden" name="days" value="<?php if( $_POST['config_horaire'] == 1) echo json_encode($days); else echo "{}";?>" />
					<input type="hidden" name="config_horaires" value='<?php if( $_POST['config_horaire'] == 1) echo json_encode($config_horaires); else echo "{}"; ?>' />
					<input type="hidden" name="config_horaire" value="<?php if( $_POST['config_horaire'] == 1) echo "2"; else echo "0"; ?>" ?>
                    <div class="col-sm-4">
                    	<select class="form-control" name="id" id="schedule_id">
                    		<?php if($schedules):while($row = $schedules->fetch_assoc()):?>
                    		<option value="<?php echo $row['SCHEDULE_ID'];?>" <?php if($row['SCHEDULE_ID'] == $id) echo "selected";?>><?php echo $row['NAME'];?></option>
                    		<?php endwhile;endif;?>
                    	</select>
                    </div>
             		<div class="col-sm-1"><input type="checkbox" id="Day1" name="day_list[]" value="1" <?php if($current_days['DAY1'] > 0) echo "checked";?>  /><label for="Day1">&nbsp;&nbsp;Lundi&nbsp;</label></div>
             		<div class="col-sm-1"><input type="checkbox" id="Day2" name="day_list[]" value="2" <?php if($current_days['DAY2'] > 0) echo "checked";?> /><label for="Day2">&nbsp;&nbsp;Mardi&nbsp;</label></div>
             		<div class="col-sm-1"><input type="checkbox" id="Day3" name="day_list[]" value="3" <?php if($current_days['DAY3'] > 0) echo "checked";?> /><label for="Day3">&nbsp;&nbsp;Mercredi&nbsp;</label></div>
             		<div class="col-sm-1"><input type="checkbox" id="Day4" name="day_list[]" value="4" <?php if($current_days['DAY4'] > 0) echo "checked";?> /><label for="Day4">&nbsp;&nbsp;Jeudi&nbsp;</label></div>
             		<div class="col-sm-1"><input type="checkbox" id="Day5" name="day_list[]" value="5" <?php if($current_days['DAY5'] > 0) echo "checked";?> /><label for="Day5">&nbsp;&nbsp;Vendredi&nbsp;</label></div>
             		<div class="col-sm-1"><input type="checkbox" id="Day6" name="day_list[]" value="6" <?php if($current_days['DAY6'] > 0) echo "checked";?> /><label for="Day6">&nbsp;&nbsp;Samedi&nbsp;</label></div>
             		<div class="col-sm-1"><input type="checkbox" id="Day7" name="day_list[]" value="7" <?php if($current_days['DAY7'] > 0) echo "checked";?> /><label for="Day7">&nbsp;&nbsp;Dimanche&nbsp;</label></div>
                   	<div class="col-sm-1"></div>
                    <hr class="style_one"/>
                   	<div class="col-sm-12">
		                  <table id="employee_grid" class="table table-condensed table-hover table-striped bootgrid-table" style='margin-bottom:0; width:100% !important;' cellspacing="0">
							   <thead>
							      <tr>
							      	<th>#</th>
							         <th>WORKSTAMP_TYPE</th>
							         <th>START_TIME</th>
							         <th>BEFORE_TOLERANCE</th>
							         <th>AFTER_TOLERANCE</th>
							         <th>BEFORE_FORBIDEN</th>
							         <th>AFTER_FORBIDEN</th>
							      </tr>
							   </thead>
							   <tbody>
							      <tr data-row-id="1">
							      	<td>1</td>
							         <td >Start Working Day</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[1])) echo sprintf("%04d",$current_config_horaires[1]['ST']); else echo "";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[1])) echo $current_config_horaires[1]['BT']; else echo "";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[1])) echo $current_config_horaires[1]['AT']; else echo "";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[1])) echo $current_config_horaires[1]['BF']; else echo "";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[1])) echo $current_config_horaires[1]['AF']; else echo "";?></td>
							      </tr>
							       <tr data-row-id="4">
							       	<td>2</td>
							         <td >Start WorkOrder</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[4])) echo sprintf("%04d",$current_config_horaires[4]['ST']); else echo "";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[4])) echo $current_config_horaires[4]['BT']; else echo "";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[4])) echo $current_config_horaires[4]['AT']; else echo "";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[4])) echo $current_config_horaires[4]['BF']; else echo "";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[4])) echo $current_config_horaires[4]['AF']; else echo "";?></td>

							      </tr>
							       <tr data-row-id="10">
							       	<td>3</td>
							         <td >Start Pause</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[10])) echo sprintf("%04d",$current_config_horaires[10]['ST']); else echo "";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[10])) echo $current_config_horaires[10]['BT']; else echo "";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[10])) echo $current_config_horaires[10]['AT']; else echo "";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[10])) echo $current_config_horaires[10]['BF']; else echo "";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[10])) echo $current_config_horaires[10]['AF']; else echo "";?></td>

							      </tr>
							       <tr data-row-id="11">
							       	<td>4</td>
							         <td >End Pause</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[11])) echo sprintf("%04d",$current_config_horaires[11]['ST']); else echo "";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[11])) echo $current_config_horaires[11]['BT']; else echo "";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[11])) echo $current_config_horaires[11]['AT']; else echo "";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[11])) echo $current_config_horaires[11]['BF']; else echo "";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[11])) echo $current_config_horaires[11]['AF']; else echo "";?></td>

							      </tr>
							      <tr data-row-id="12">
							      	<td>5</td>
							         <td >Start Lunch</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[12])) echo sprintf("%04d",$current_config_horaires[12]['ST']); else echo "";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[12])) echo $current_config_horaires[12]['BT']; else echo "";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[12])) echo $current_config_horaires[12]['AT']; else echo "";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[12])) echo $current_config_horaires[12]['BF']; else echo "";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[12])) echo $current_config_horaires[12]['AF']; else echo "";?></td>

							      </tr>
							      <tr data-row-id="13">
							      	<td>6</td>
							         <td >End Lunch</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[13])) echo sprintf("%04d",$current_config_horaires[13]['ST']); else echo "";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[13])) echo $current_config_horaires[13]['BT']; else echo "";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[13])) echo $current_config_horaires[13]['AT']; else echo "";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[13])) echo $current_config_horaires[13]['BF']; else echo "";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[13])) echo $current_config_horaires[13]['AF']; else echo "";?></td>

							      </tr>
							      <tr data-row-id="9">
							      	<td>7</td>
							         <td >End WorkOrder</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[9])) echo sprintf("%04d",$current_config_horaires[9]['ST']); else echo "";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[9])) echo $current_config_horaires[9]['BT']; else echo "";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[9])) echo $current_config_horaires[9]['AT']; else echo "";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[9])) echo $current_config_horaires[9]['BF']; else echo "";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[9])) echo $current_config_horaires[9]['AF']; else echo "";?></td>

							      </tr>
							      <tr data-row-id="14">
							      	<td>8</td>
							         <td >End Working Day</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[14])) echo sprintf("%04d",$current_config_horaires[14]['ST']); else echo "";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[14])) echo $current_config_horaires[14]['BT']; else echo "";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[14])) echo $current_config_horaires[14]['AT']; else echo "";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[14])) echo $current_config_horaires[14]['BF']; else echo "";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[14])) echo $current_config_horaires[14]['AF']; else echo "";?></td>
							      </tr>
							   </tbody>
							   
							</table>
		              	</div>
		              	<input type="hidden" name="config_data" id="config-data-input" value='' />
					<div class="col-sm-12">
							<div class="col-sm-12">
					    <div class='form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg' style='margin-bottom: 0;'>
						
						  <div class='row' >

										<div class='col-sm-8'></div>

                       <div class='col-sm-2' >
                       </div>
                       <div class="col-sm-2">
                          <input type="submit" id="confirmhoraire" name="addCustomer" value="Enregister" class='btn btn-danger btn-lg'>
                      </div>
                      </div>
								</div>
                     
								<hr class="style_two"/>
							</div>
                      </form>
              	
              	
                    </div>
                  </div>
                </div>
            
              </div>
            </div>
          </div>
      </section>
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
	<script src="assets/javascripts/plugins/fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/select2/select2.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/bootstrap_colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/datatables/jquery.dataTables.columnFilter.js" type="text/javascript"></script>
    <script src="assets/javascripts/plugins/datatables/dataTables.overrides.js" type="text/javascript"></script> 
    
    <script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.jqueryui.min.js" type="text/javascript"></script>
<script type="text/javascript">


	//AJOUTER UNE ADRESSE
	 $(document).ready(function(){
	       $('#datepicker').on("changeDate", function() {
	            $('#date_debut').val(
	                $('#datepicker').datepicker('getFormattedDate')
	            );
	        });
	       $('#datepicker2').on("changeDate", function() {
	            $('#date_fin').val(
	                $('#datepicker2').datepicker('getFormattedDate')
	            );	
	        });
	        var data = [];
	        $('#confirmhoraire').click(function (){
	        	$("td[contenteditable=true]").each(function(){
	                var field_id = $(this).attr("id") ;
	                var value = $(this).text() ;
	                var row_id = $(this).parent().attr("data-row-id");
	                //alert(JSON.stringify({"row_id":row_id,"id":field_id,"value" :value}));
	                data.push({"row_id":row_id,"id":field_id,"value" :value});
					//alert($(this).text());
					

	                
	            });
	        	$('#config-data-input').val(JSON.stringify(data));
	            $('#config-horaire-form').submit();
	        					
	
			    });

		    $('#schedule_id').change(function(){
					 var id  = $(this).val();
					 location.href="ConfigSchedule.php?id_mod="+id;
				
				});

		    $('#employee_grid').DataTable({
		    	"bSort": false,
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
		                        if(i == 0){
		                        	return '<tr>'+
	                                '<td>'+col.title+':'+'</td> '+
	                                '<td>'+col.data+'</td>'+
	                            	'</tr>';
		                        }
		                        else{
								return '<tr>'+
			                                '<td>'+col.title+':'+'</td> '+
			                                '<td contenteditable="true">'+col.data+'</td>'+
			                            '</tr>';
		                        }
	                        } ).join('');
	     
	                        return $('<table/>').append( data );
	                    }
	                }
	            }
	     });

		






			 
	 var active = 0;


	 $(document).keydown(function(e){
		 if (e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40) {
		     reCalculate(e);
		     rePosition();
		     return true;
		 }
		 else return true;
	 });

	 $('td').click(function(){
	    active = $(this).closest('table').find('td').index(this);
	    rePosition();
	 });


	 function reCalculate(e){
	     var rows = $('#employee_grid tr').length;
	     var columns = $('#employee_grid tr:first-child td').length;
	     //alert(columns + 'x' + rows);

	     if (e.keyCode == 37) { //move left or wrap
	         active = (active>0)?active-1:active;
	     }
	     if (e.keyCode == 38) { // move up
	         active = (active-columns>=0)?active-columns:active;
	     }
	     if (e.keyCode == 39) { // move right or wrap
	        active = (active<(columns*rows)-1)?active+1:active;
	     }
	     
	     if (e.keyCode == 40) { // move down
	         active = (active+columns<=(rows*columns)-1)?active+columns:active;
	     }
	 };

	 function rePosition(){
	     $('.active').removeClass('active');
	     $('#employee_grid tr td').eq(active).addClass('active').trigger( "focus" );
	     scrollInView();
	 };

	 function scrollInView(){
	     var target = $('#employee_grid tr td.active');
	     if (target.length)
	     {
	         var top = target.offset().top;

	         $('html,body').stop().animate({scrollTop: top-100}, 400);
	         return false;
	     }
	 };
	 
	 });
</script>

  </body>


</html>
