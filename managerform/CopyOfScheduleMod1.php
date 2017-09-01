
   
      <?php  include("header.php");
        if(isset($_GET["id_mod"])){
      		$id=$_GET["id_mod"];
      		if($id > 0){
      			$get_sql = "SELECT * FROM `SCHEDULE` WHERE `SCHEDULE_ID` = ".$id;
				$query = mysqli_query($connect, $get_sql);
				$data = $query->fetch_assoc();
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
      	if( $_POST['config_horaire'] == 1){
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
	      	
      	}
      	
		if(isset($_POST["id"])){
	    	$id = $_POST["id"];
	    	$schedule_name = $_POST['schedule_name'];
	    	$description = $_POST['description'];
	    	$is_legal = $_POST['is_legal'];
	    	$active_from = $_POST['start'];
	    	$active_end = $_POST['end'];
	    	if($id == 0){
	    		$sql = "INSERT `SCHEDULE` (`SCHEDULE_ID`, `NAME`, `DESCRIPTION`, `IS_LEGAL`, `ACTIVE_FROM`,`ACTIVE_TO`) VALUES (NULL, '$schedule_name', '$description', '$is_legal', '$active_from', '$active_end')";
	    		
	    	}
	    	else if($id > 0){
	    		
	    		$sql = "UPDATE `SCHEDULE`  SET `NAME`='".$schedule_name."', `DESCRIPTION`='".$description."',
	    		 `IS_LEGAL`='".$is_legal."', `ACTIVE_FROM`='".$active_from."', `ACTIVE_TO`='".$active_end."' WHERE `SCHEDULE_ID`=".$id;
	    	}
	    	//echo $sql."</br>";
	    	mysqli_query($connect, $sql);
	    	if($id == 0){
	    		$id=mysqli_insert_id($connect);
	    		
	    	}
			if($_POST['config_horaire'] == 2){
	      		$days = json_decode($_POST['days']);
	      		$config_horaires = json_decode($_POST['config_horaires']);
	      		for($i = 1; $i < 8; $i++){
	      			 if($days[$i] == 1){
	      			 	//print_r($config_horaires);
	      			 	foreach($config_horaires as $config_row){
	      			 		//print_r($config_row);
		      			 	$tmp_sql = "SELECT * FROM `SCHEDULE_EVENT` WHERE `SCHEDULE_ID` = '$id' AND `DAY_OF_WEEK` = '$i' AND `WORKSTAMP_TYPE_ID` = '$config_row->workstamp_type_id'";
		      			 	
		      			 	$tmp_rows = mysqli_query($connect, $tmp_sql);
		      			 	$compte=$tmp_rows->num_rows;
		      			 	if($compte == 0){
		      			 		$config_sql = "INSERT INTO `SCHEDULE_EVENT` (`SCHEDULE_ID`, `DAY_OF_WEEK`, `WORKSTAMP_TYPE_ID`, `START_TIME`,`BEFORE_TOLERANCE_MINUTES`, `AFTER_TOLERANCE_MINUTES`, `BEFORE_FORBIDDEN_MINUTES`, `AFTER_FORBIDDEN_MINUTES`)
		      			 		 VALUES ('$id', '$i', '$config_row->workstamp_type_id', '$config_row->Start_Time',  '$config_row->BT', '$config_row->AT', '$config_row->BF', '$config_row->AF')";
		      			 	}
		      			 	else{
		      			 		$tmp_row = $tmp_rows->fetch_assoc();
		      			 		$schedule_event_id = $tmp_row['SCHEDULE_EVENT_ID'];
		      			 		$config_sql = "UPDATE `SCHEDULE_EVENT` SET `SCHEDULE_ID`='$id', `DAY_OF_WEEK`='$i', `WORKSTAMP_TYPE_ID`='$config_row->workstamp_type_id', `START_TIME`='$config_row->Start_Time', 
		      			 		`BEFORE_TOLERANCE_MINUTES`='$config_row->BT', `AFTER_TOLERANCE_MINUTES`='$config_row->AT', `BEFORE_FORBIDDEN_MINUTES`='$config_row->BF',
		      			 		 `AFTER_FORBIDDEN_MINUTES`='$config_row->AF' WHERE `SCHEDULE_EVENT_ID`='$schedule_event_id';";
		      			 	}
		      			 	//echo $config_sql;
		      			 	mysqli_query($connect, $config_sql);
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
		      			 			$config_sql = "DELETE FROM `SCHEDULE_EVENT` WHERE `SCHEDULE_EVENT_ID`='$schedule_event_id';";
		      			 		}
		      			 	}
		      			 	//echo $config_sql;
		      			 	mysqli_query($connect, $config_sql);
	      			 	}
	      			 }
	      		}
	      	}
	    	$error = "";
	    	
	    	?><script>
    			window.location.href = "ScheduleList.php";
    		</script>
    		<?php 
	    }
      ?>
    
       <hr class="style_one"/>
      <section id='content'>
        <div class='container'>
        	<div class="row">
                <div class='col-sm-12'>
                  <div class='box'>
                    <div class='box-header red-background'>
                       <div class='title'><p>Schedule:</p>
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
				<form class="form" style="margin-bottom: 0;" method="post" action="ScheduleMod.php" enctype="multipart/form-data" >
	                        <div class="col-sm-12">
	                        	<hr class="style_one"/>
					<input type="hidden" value="<?php echo $data['SCHEDULE_ID'];?>" name="id" id="id" />
					<input type="hidden" name="days" value="<?php if( $_POST['config_horaire'] == 1) echo json_encode($days); else echo "{}";?>" />
					<input type="hidden" name="config_horaires" value='<?php if( $_POST['config_horaire'] == 1) echo json_encode($config_horaires); else echo "{}"; ?>' />
					<input type="hidden" name="config_horaire" value="<?php if( $_POST['config_horaire'] == 1) echo "2"; else echo "0"; ?>" ?>
                    <div class='form-group'>
                        <label for='organizatin_unit_name'>Nom</label>
                        <input class="form-control" id="schedule_name" name="schedule_name" placeholder="Schedule Name" type="text" value="<?php echo $data['NAME'];?>">
                      </div>
					<div class='form-group'>
                    	<label for="desc_cus">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Schedule Description" value="<?php echo $data['DESCRIPTION'];?>" />
                    </div>
					<div class='form-group'>
						<label for='is_legal'>Legal Entity</label>
						<select id = "is_legal" name="is_legal" class="form-control">
							<option value="Y" <?php if($data['IS_LEGAL'] == 'Y') echo "selected";?>>YES</option>
							<option value="N" <?php if($data['IS_LEGAL'] == 'N') echo "selected";?> >NO</option>
						</select>
                      </div>
                    </div>
					<div class="col-sm-12">
                    		<div class="form-group">
                    			<label for='inputText'>ACTIVE FROM</label> 
				                   <div class="datepicker-input input-group" id="datepicker">
				                      <input class="form-control" data-format="YYYY-MM-DD" name="start" value="<?php echo $data['ACTIVE_FROM'];?>" >
				                      <span class="input-group-addon">
				                        <span data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar"></span>
				                      </span>
				                    </div>
                    			
                    		</div>
                    	</div>
                    	<div class="col-sm-12">
                    		<div class="form-group">
                    			<label for='inputText'>ACTIVE TO </label> 
				                   <div class="datepicker-input input-group" id="datepicker2">
				                      <input class="form-control" data-format="YYYY-MM-DD" name="end" value="<?php echo $data['ACTIVE_TO'];?>" >
				                      <span class="input-group-addon">
				                        <span data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar"></span>
				                      </span>
				                    </div>
                    		</div>
                    	</div>
					<div class="col-sm-12">
							<div class="col-sm-12">
					    <div class='form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg' style='margin-bottom: 0;'>
						
						  <div class='row' >

										<div class='col-sm-8'></div>

                       <div class='col-sm-2' >
                       	  <a style="float:left;" id="addAddress" href="#displayAddress" class="btn btn-danger btn-lg">Config Horaire</a>&nbsp;&nbsp;
                       </div>
                       <div class="col-sm-2">
                          <input type="submit" id="addCustomer" name="addCustomer" value="MODIFIER" class='btn btn-danger btn-lg'>
                      </div>
                      </div>
								</div>
                     
								<hr class="style_two"/>
							</div>
                      </form>
              	
              		<!--ADRESSE-->
          <div class="col-sm-12" id="displayAddress">
	          					<hr class="style_one"/>	
             <form class="form" style="margin-bottom: 0;" method="post" action="#" enctype="multipart/form-data" id="config-horaire-form">   
             	<input type="hidden" name="config_horaire" value="1" />
             	<input type="hidden" name="schedule_id" value="<?php echo $id;?>" />
             		<div>
             			<div class="col-sm-3"></div>
             			<div class="col-sm-1"><input type="checkbox" id="Day1" name="day_list[]" value="1" <?php if($current_days['DAY1'] > 0) echo "checked";?>  /><label for="Day1">&nbsp;&nbsp;Lundi&nbsp;</label></div>
             			<div class="col-sm-1"><input type="checkbox" id="Day2" name="day_list[]" value="2" <?php if($current_days['DAY2'] > 0) echo "checked";?> /><label for="Day2">&nbsp;&nbsp;Mardi&nbsp;</label></div>
             			<div class="col-sm-1"><input type="checkbox" id="Day3" name="day_list[]" value="3" <?php if($current_days['DAY3'] > 0) echo "checked";?> /><label for="Day3">&nbsp;&nbsp;Mercredi&nbsp;</label></div>
             			<div class="col-sm-1"><input type="checkbox" id="Day4" name="day_list[]" value="4" <?php if($current_days['DAY4'] > 0) echo "checked";?> /><label for="Day4">&nbsp;&nbsp;Jeudi&nbsp;</label></div>
             			<div class="col-sm-1"><input type="checkbox" id="Day5" name="day_list[]" value="5" <?php if($current_days['DAY5'] > 0) echo "checked";?> /><label for="Day5">&nbsp;&nbsp;Vendredi&nbsp;</label></div>
             			<div class="col-sm-1"><input type="checkbox" id="Day6" name="day_list[]" value="6" <?php if($current_days['DAY6'] > 0) echo "checked";?> /><label for="Day6">&nbsp;&nbsp;Samedi&nbsp;</label></div>
             			<div class="col-sm-1"><input type="checkbox" id="Day7" name="day_list[]" value="7" <?php if($current_days['DAY7'] > 0) echo "checked";?> /><label for="Day7">&nbsp;&nbsp;Dimanche&nbsp;</label></div>
             		</div>
             		<hr class="style_two"/>
             		</br>
             		</br>
             		<div class="">
		                  <table id="employee_grid" class="table table-condensed table-hover table-striped bootgrid-table" width="60%" cellspacing="0">
							   <thead>
							      <tr>
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
							      	<?php 
							      	
							      	?>
							         <td >Start Working Day</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[1])) echo sprintf("%04d",$current_config_horaires[1]['ST']); else echo "0700";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[1])) echo $current_config_horaires[1]['BT']; else echo "2";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[1])) echo $current_config_horaires[1]['AT']; else echo "2";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[1])) echo $current_config_horaires[1]['BF']; else echo "30";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[1])) echo $current_config_horaires[1]['AF']; else echo "30";?></td>
							      </tr>
							       <tr data-row-id="4">
							         <td >Start WorkOrder</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[4])) echo sprintf("%04d",$current_config_horaires[4]['ST']); else echo "0700";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[4])) echo $current_config_horaires[4]['BT']; else echo "2";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[4])) echo $current_config_horaires[4]['AT']; else echo "2";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[4])) echo $current_config_horaires[4]['BF']; else echo "30";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[4])) echo $current_config_horaires[4]['AF']; else echo "30";?></td>

							      </tr>
							       <tr data-row-id="10">
							         <td >Start Pause</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[10])) echo sprintf("%04d",$current_config_horaires[10]['ST']); else echo "0900";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[10])) echo $current_config_horaires[10]['BT']; else echo "5";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[10])) echo $current_config_horaires[10]['AT']; else echo "5";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[10])) echo $current_config_horaires[10]['BF']; else echo "15";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[10])) echo $current_config_horaires[10]['AF']; else echo "15";?></td>

							      </tr>
							       <tr data-row-id="11">
							         <td >End Pause</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[11])) echo sprintf("%04d",$current_config_horaires[11]['ST']); else echo "0900";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[11])) echo $current_config_horaires[11]['BT']; else echo "5";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[11])) echo $current_config_horaires[11]['AT']; else echo "5";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[11])) echo $current_config_horaires[11]['BF']; else echo "15";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[11])) echo $current_config_horaires[11]['AF']; else echo "15";?></td>

							      </tr>
							      <tr data-row-id="12">
							         <td >Start Launch</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[12])) echo sprintf("%04d",$current_config_horaires[12]['ST']); else echo "1215";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[12])) echo $current_config_horaires[12]['BT']; else echo "10";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[12])) echo $current_config_horaires[12]['AT']; else echo "10";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[12])) echo $current_config_horaires[12]['BF']; else echo "20";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[12])) echo $current_config_horaires[12]['AF']; else echo "20";?></td>

							      </tr>
							      <tr data-row-id="13">
							         <td >End Launch</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[13])) echo sprintf("%04d",$current_config_horaires[13]['ST']); else echo "1315";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[13])) echo $current_config_horaires[13]['BT']; else echo "10";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[13])) echo $current_config_horaires[13]['AT']; else echo "10";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[13])) echo $current_config_horaires[13]['BF']; else echo "20";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[13])) echo $current_config_horaires[13]['AF']; else echo "20";?></td>

							      </tr>
							      <tr data-row-id="9">
							         <td >End WorkOrder</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[9])) echo sprintf("%04d",$current_config_horaires[9]['ST']); else echo "1730";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[9])) echo $current_config_horaires[9]['BT']; else echo "5";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[9])) echo $current_config_horaires[9]['AT']; else echo "5";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[9])) echo $current_config_horaires[9]['BF']; else echo "15";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[9])) echo $current_config_horaires[9]['AF']; else echo "15";?></td>

							      </tr>
							      <tr data-row-id="14">
							         <td >End Working Day</td>
							         <td contenteditable="true" id="ST"><?php if(isset($current_config_horaires[14])) echo sprintf("%04d",$current_config_horaires[14]['ST']); else echo "1730";?></td>
							         <td contenteditable="true" id="BT"><?php if(isset($current_config_horaires[14])) echo $current_config_horaires[14]['BT']; else echo "2";;?></td>
							         <td contenteditable="true" id="AT"><?php if(isset($current_config_horaires[14])) echo $current_config_horaires[14]['AT']; else echo "2";?></td>
							         <td contenteditable="true" id="BF"><?php if(isset($current_config_horaires[14])) echo $current_config_horaires[14]['BF']; else echo "30";?></td>
							         <td contenteditable="true" id="AF"><?php if(isset($current_config_horaires[14])) echo $current_config_horaires[14]['AF']; else echo "30";?></td>
							      </tr>
							   </tbody>
							   
							</table>
		              	</div>
       				<input type="hidden" name="config_data" id="config-data-input" value="" />
                  <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                     <div class="col-sm-10"> </div>
                      <div class="col-sm-2">
                          <input style="float:right;"  type="button" id="confirmhoraire" name="confirmhoraire" value="Enregistrer" class="btn btn-danger btn-lg">
                          
                      </div>
                    <hr class="style_two"/>
                  </div>  
                  </div>
                 </form>
								<hr class="style_two"/>
              	
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
	  $("#addAddress").click(function () {

          if( $("#displayAddress").css("display","block")){
            var page = $(this).attr('href'); // Page cible
            var speed = 2000; // Durée de l'animation (en ms)
            $('html, body').animate( { scrollTop: $(page).offset().top }, speed );
            return false;
          }
          
       });
 });
  function initializeAutocomplete(id) {
	  var element = document.getElementById(id);
	  if (element) {
	    var autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
	    google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
	  }
	}
	function onPlaceChanged() {
	  var place = this.getPlace();
	  document.getElementById('lat').value = place.geometry.location.lat();
	  document.getElementById('lng').value  = place.geometry.location.lng();

	  // console.log(place);  // Uncomment this line to view the full object returned by Google API.
	   
	  for (var i in place.address_components) {
	    var component = place.address_components[i];
	    
	    for (var j in component.types) {  // Some types are ["country", "political"]
	       var type_element = document.getElementById(component.types[j]);

	      if (type_element) {
	        if(type_element==administrative_area_level_1){
	          type_element.value = component.short_name;
	        }else{
	          type_element.value = component.long_name;

	        }

	      }
	    }
	  }
	}

	google.maps.event.addDomListener(window, 'load', function() {
	  initializeAutocomplete('user_input_autocomplete_address');
	 
	});

	//AJOUTER UNE ADRESSE
	 $(document).ready(function(){
	       $("#addAddress").click(function () {

	           if( $("#displayAddress").css("display","block")){
	             var page = $(this).attr('href'); // Page cible
	             var speed = 2000; // Durée de l'animation (en ms)
	             $('html, body').animate( { scrollTop: $(page).offset().top }, speed );
	             return false;
	           }
	           
	        });
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
	                data.push({"row_id":row_id,"id":field_id,"value" :value});
					//alert($(this).text());
					

	                
	            });
	        	$('#config-data-input').val(JSON.stringify(data));
	            $('#config-horaire-form').submit();
	        					
	
			    });
	     });


</script>

  </body>


</html>
