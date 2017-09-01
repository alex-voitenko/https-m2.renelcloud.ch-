<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
      	
//    RDS1 EXTERNAL PORT (prod) = "5.144.37.152:444"
//    RDS1 INTERNAL PORT (prod) = "192.168.18.17:3306"



//    RDS2 EXTERNAL PORT (dev) = "5.144.37.152:544"
//    RDS2 INTERNAL PORT (dev)  = "192.168.18.117:3306"



//    DATABASE = "RENELCO_BMA_DEV"; par défaut si pas d'autres
 


	if(!empty($_SESSION["costumer"]["name"])){
		// serveur de dev RDS2
		//$host_name  = "192.168.18.117:3306"; 
		// serveur de prod RDS1
		//$host_name  = "192.168.18.17:3306";

		$host_name  = "127.0.0.1:3306"; 
		
		
	    $connect = mysqli_connect($host_name, 'root'/*$_SESSION["costumer"]["name"][0]*/, '1234'/*$_SESSION["costumer"]["pass"][0]*/, $_SESSION["costumer"]["bdd"][0]);
	    
	    if(mysqli_connect_errno())
	    {
	        $erreur= '<p>Erreur de connexion au serveur : '.mysqli_connect_error().' Veuillez recommencer plus tard !</p>';
	    }
	}else{
		 header("location:index.php?logout=0");
        exit();
	}
	
?>