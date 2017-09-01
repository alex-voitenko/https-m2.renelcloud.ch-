  <?php include("header.php");
  	// Collaborator Name for auto-complete 
  	$sql_collaborator = "SELECT * FROM renelco_bma_dev.ui_collaborator";
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
    
    
  	$sql = "SELECT * FROM renelco_bma_dev.rep_horaires";
  	$sql_schedule = "SELECT * FROM renelco_bma_dev.ui_schedule";
  	$req_schedule = mysqli_query($connect, $sql_schedule);
  	$sql_workstamp = "SELECT * FROM renelco_bma_dev.ui_workstamp_types";
    $req_workstamp = mysqli_query($connect,$sql_workstamp);
  	$sql_organization= "SELECT * FROM renelco_bma_dev.ui_organization_units";
  	$req_organization = mysqli_query($connect, $sql_organization);
  	$schedule_id = 0;
  	$date_start = '';
  	$date_end = '';
  	$workstamp_type = 0;
  	$respect_horaire = '0';
  	$organization_unit = 0;
  	$collaborator_name ='';
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
		if($where == ''){
			$sql = "SELECT * FROM renelco_bma_dev.rep_horaires";
		}
    	else{$sql = "SELECT * FROM  renelco_bma_dev.rep_horaires
	    WHERE
	        ".$where."
	    ORDER BY `SCHEDULE_NAME`, `DATE_ID`";
    	}
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
                      <div class='title'><p>Rapport Financier</p>
                        <div class='actions'>
                          <a class="btn btn-md btn-link" style="float:right;" href="../Rapports.php" title="Retour au Rapports"><i class='icon-home' ></i>  Retour au Rapports</a>
                          <button class="btn btn-md btn-link" style="display:inline-block !important;font-size: 0.8em !important; float:right;" title="Retour au Reports"  id="search-button"a><i class='icon-search' ></i>  Chercher</a>
                        
                        </div>
                
					            </div>
                    </div>
                    <div class='box-content'>
                    	<div class="row">
	                    	<form class="form" method="post" action="RepFinance.php" id="search-form">
	                    	
		                    	<div class="col-sm-12">
		                    		<div class="form-group">
		                    			<label for="inputText">Type horaire</label>
			                    		<select class="form-control" name="schedule">
			                    			<option value="0" <?php if($schedule_id == 0) echo "selected";?>>**ALL SCHEDULE**</option>
			                    			<?php if($req_schedule):while($row=$req_schedule->fetch_assoc()):?>	
			                    				<option value="<?php echo $row['SCHEDULE_ID'];?>" <?php if($schedule_id == $row['SCHEDULE_ID']) echo "selected"; ?> ><?php echo $row['SCHEDULE_NAME'];?></option>
			                    			<?php endwhile;endif;?>
			                    		</select>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-6">
		                    		<div class="form-group">
		                    			<label for='inputText'>Date début </label> 
						                   <div class="datepicker-input input-group" id="datepicker">
						                      <input class="form-control" data-format="YYYY-MM-DD" name="start" value="<?php echo $date_start;?>">
						                      <span class="input-group-addon">
						                        <span data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar"></span>
						                      </span>
						                    </div>
		                    			
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-6">
		                    		<div class="form-group">
		                    			<label for='inputText'>Date Fin </label> 
						                   <div class="datepicker-input input-group" id="datepicker">
						                      <input class="form-control" data-format="YYYY-MM-DD" name="end" value="<?php echo $date_end;?>">
						                      <span class="input-group-addon">
						                        <span data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar"></span>
						                      </span>
						                    </div>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-6">
		                    		<div class="form-group">
		                    			<label for='inputText'>Nom collaborateur</label> 
						                   <!-- <div class="datepicker-input input-group" id="datepicker">-->
						                      <input class="form-control" type="text" id = "collaborator_name" name = "collaborator" value="<?php echo $collaborator_name;?>" />
						                    <!-- </div>-->
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-6">
		                    		<div class="form-group">
		                    			<label for='inputText'>Type timbrage </label> 
						                 <select class="form-control" name="workstamp_type">
						                 	<option value="0" <?php if($workstamp_type == 0) echo "selected";?> >**ALL WORKSTAMP**</option>	
						                 	<?php if($req_workstamp):while($row=$req_workstamp->fetch_assoc()):?>
			                    			<option value="<?php echo $row['WORKSTAMP_TYPE_ID'];?>" <?php if($workstamp_type == $row['WORKSTAMP_TYPE_ID']) echo "selected"; ?> ><?php echo $row['WORKSTAMP_TYPE'];?></option>
			                    			<?php endwhile;endif;?>
						                 </select>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-6">
		                    		<div class="form-group">
		                    			<label for='inputText'>RESPECT HORAIRES </label> 
						                 <select class="form-control" name="respect_horaire">
						                 	<option value="0" <?php if($respect_horaire == '0') echo "selected"; ?> >**ALL RESPECT HORAIRES**</option>
			                    			<option value="ROUGE" <?php if($respect_horaire == 'ROUGE') echo "selected"; ?> >ROUGE</option>
			                    			<option value="VERT" <?php if($respect_horaire == 'VERT') echo "selected"; ?> >VERT</option>
			                    			<option value="ORANGE" <?php if($respect_horaire == 'ORANGE') echo "selected"; ?>  >ORANGE</option>
						                 </select>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-6">
		                    		<div class="form-group">
		                    			<label for='inputText'>Organization Unit </label> 
						                 <select class="form-control" name="organization_unit">
						                 	<option value="0" <?php if($organization_unit == 0) echo "selected";?> >**ALL UNITS**</option>>
						                 	<?php if($req_organization):while($row=$req_organization->fetch_assoc()):?>
			                    			<option value="<?php echo $row['ORGANIZATION_UNIT_ID'];?>"  <?php if($organization_unit == $row['ORGANIZATION_UNIT_ID']) echo "selected";?>  ><?php echo $row['ORGANIZATION_NAME'];?></option>
			                    			<?php endwhile;endif;?>
						                 </select>
		                    		</div>
		                    	</div>
		                    	
	                    	</form>
	                    </div>
                      <div class='responsive-table'>
                        <div class='col-sm-12' id='afficheMessage'></div>
                        <div class='scrollable-area'>
                          <table id="example" class='data-table-column-filter table table-bordered' style='margin-bottom:0;'>
                            <thead>
                             <tr>
                             	<th>#</th>
                             	<th>TYPE HORAIRE</th>
                             	<th>PRENOM</th>
                             	<th>NOM</th>
                             	<th>DATE</th>
                             	<th>TYPE TIMBRAGE</th>
								<th>HEURE VALIDE</th>
                             	<th>HEURE TIMBRAGE</th>
                             	<th>RETARD-AVANCE</th>
                             	<th>RESPECT HORAIRE</th>
                             	<th>ORGANISATION</th>
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
                   // $data = array();
                    /*$data = array(
                    	"LASTNAME"=>"Franco",
                    	"FIRSTNAME"=>"Franco",
                    	"DAYSTAMP"=>"2017-3-12",
                    	"TIMESTAMP"=>"2017-3-12 9:00",
                    	"WORKSTAMP_NAME"=>"aaa",
                    	"VALID_START_TIME"=>"2017-3-12 3:54pm",
                    	"VALID_END_TIME"=>"2017-3-12 4:54pm"
                    );*/
                   	?>
				
                         <tr>
                         	<td><?php echo $i;?></td>
                         	<td><?php echo $data['SCHEDULE_NAME'];?></td>
                         	<td><?php echo $data['LASTNAME'];?></td>
                         	<td><?php echo $data['FIRSTNAME'];?></td>
                         	<td><?php echo $data['DAY_STAMP'];?></td>
                         	<td><?php echo $data['WORKSTAMP_NAME'];?></td>
							<td><?php echo $data['VALID_START_TIME'];?></td>
                         	<td><?php echo $data['TIME_STAMP'];?></td>
                         	<td><?php echo $data['DELTA_DISPLAY'];?></td>
							<td>
								<img style="margin-left:30px;"src="../images/<?php if($data['RESPECT_HORAIRE'] == "ROUGE") echo "red"; else if ($data['RESPECT_HORAIRE'] == "VERT") echo "green"; else echo "yellow"?>.png" width="30px" height="30px"	>					
							</td>
                         	<td><?php echo $data['ORGANIZATION_NAME'];?></td>
                         </tr>
						
                      <?php 
                      
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

    $(document).ready(function() {
    var table = $('#example').DataTable();
     
     $('#example tbody').on('click', 'td.supp',function () {
       var id=$(this).attr("id");
       var name=$(this).siblings().attr("id");
       var message="<p>Voulez-vous vraiment supprimer ce client '"+name+"'&nbsp;? <a class='btn btn-danger' id='oui'>OUI</a>&nbsp&nbsp;<a class='btn btn-danger' id='non'>NON</a></p>";
        
        $("#afficheMessage").css("display","block").html(message);
        
        $("#non").click(function(){
          $("#afficheMessage").css("display","none");
        });

        $("#oui").click(function(){
            var envoi=$.post('removeCus.php',{id:id});
            envoi.done(function(data) {
            location.reload();

            });
            return false; 
          });
        
      
    } );
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
