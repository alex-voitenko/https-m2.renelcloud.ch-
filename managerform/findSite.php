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

if(isset($_POST["id"])){
		$table;

	$id=$_POST["id"];

	$req=mysqli_query($connect,"SELECT * FROM CUSTOMER WHERE CUSTOMER_ID = '$id'");

	$data=$req->fetch_assoc();
	$customer_id=$data["CUSTOMER_ID"];
	$table["contact"]=$data["CONTACTNAME"];
	$table["phone"]=$data["PHONENR"];
	$table["mobile"]=$data["MOBILENR"];
	$table["mail"]=$data["EMAIL"];

	$i=0;
	$req2=mysqli_query($connect,"SELECT * FROM SITE WHERE CUSTOMER_ID = '$id'");
	
	if($req2->num_rows!=0){
		$table["compte"]=$req2->num_rows;
		while($data=$req2->fetch_assoc()){
			$table["nom"][$i]=$data["NAME"];
			$table["id_site"][$i]=$data["SITE_ID"];
			$i++;
		}

	}else{
		$table["compte"]=0;
	}
	
	echo json_encode($table);
}

	

?>