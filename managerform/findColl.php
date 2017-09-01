<?php
header('Content-Type: application/json');
session_start();
if(!isset($_SESSION["costumer"])){
  $_SESSION["costumer"]=array();
  $_SESSION["costumer"]["name"]=array();
  $_SESSION["costumer"]["bdd"]=array();
  $_SESSION["costumer"]["pass"]=array();
}
include("../config.php");
	$i=0;
	$id=$_POST["id"];
	$table;
	$req=mysqli_query($connect,"SELECT * FROM COLLABORATOR_ACTIVITY WHERE ACTIVITY_ID = '$id'");
	while($data=$req->fetch_assoc()){
		$collaborator_id=$data["COLLABORATOR_ID"];
		$table["collaborator_id"][$i]=$collaborator_id;
		
		$req2=mysqli_query($connect,"SELECT * FROM COLLABORATOR WHERE COLLABORATOR_ID = '$collaborator_id'");
		$data=$req2->fetch_assoc();
		$table["lastname"][$i]=$data["LASTNAME"];
		$table["firstname"][$i]=$data["FIRSTNAME"];
		
		$i++;
	}
	
	
	
	echo json_encode($table);


	

?>