<?php

	session_start();
	
	if(!isset($_SESSION["costumer"])){
		
		$_SESSION["costumer"] = array();
		$_SESSION["costumer"]["name"] = array();
		$_SESSION["costumer"]["bdd"] = array();
		$_SESSION["costumer"]["pass"] = array();
	}
	
	// Informations de connexion
	$database = $_SESSION["costumer"]["bdd"][0];
	$userName = $_SESSION["costumer"]["name"][0];
	$password = $_SESSION["costumer"]["pass"][0];
	
	$host_name  = "192.168.18.117:3306";
    $connect = mysqli_connect($host_name, $userName, $password, $database);
	
	// Query - Requ�te
	$r = "SELECT WORKORDER.WORKORDER_ID, WORKORDER.NAME FROM WORKORDER ORDER BY WORKORDER.NAME ASC";
	
	// Execute query - Execution de la requ�te
	$req = mysqli_query($connect, $r);
	
	// Number of query results - Nombre de r�sultats de la requ�te
	$rows = $req->num_rows;
	
	// Writing results in JSON format - Ecriture des r�sultats au format JSON
	echo "{";
	echo '"workorders": [';	
	
	$i = 1;
	
	while($data=$req->fetch_assoc()){
	
		$workorderId = $data["WORKORDER_ID"];
		$workorderName = $data["NAME"];
		
		$g = '"';
		$d = ':';
		$v = ',';		
		
		echo "{";
		
		echo $g.'workorderId'.$g.$d.$g.$workorderId.$g.$v;
		echo $g.'workorderName'.$g.$d.$g.$workorderName.$g;
		
		echo "}";
		
		if ($i < $rows) {
			echo $v;
		}

		$i++;
	}
	
	echo "]";
	echo "}";
?>
