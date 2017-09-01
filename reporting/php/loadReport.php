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


// Call table $_GET
if (isset($_POST['id'])) {
	
	// Call WORKORDER_ID - récupération de WORKORDER_ID
	$workOrderId = $_POST['id'];
	
	// Classes importation - Importation des classes
	include("classes/Workstamp.php");
	include("classes/Collaborator.php");

	// Query for selected WORKORDER - Requête sur l'ordre de travail désiré
	$r = "
	SELECT 
	COLLABORATOR.FIRSTNAME, 
	COLLABORATOR.LASTNAME, 
	COLLABORATOR.COST,
	ACTIVITY.NAME AS ACTIVITYNAME,
	WORKSTAMP_TYPE.NAME AS TYPESTAMP,
	FROM_UNIXTIME(WORKSTAMP.CHECKTIME/1000,'%d.%m.%Y') AS DATESTAMP,
	FROM_UNIXTIME(WORKSTAMP.CHECKTIME / 1000, '%Y-%m-%d %h:%m:%s') AS STAMP
	FROM WORKSTAMP
	INNER JOIN WORKSTAMP_TYPE ON WORKSTAMP.WORKSTAMP_TYPE_ID = WORKSTAMP_TYPE.WORKSTAMP_TYPE_ID
	INNER JOIN COLLABORATOR ON WORKSTAMP.COLLABORATOR_ID = COLLABORATOR.COLLABORATOR_ID
	LEFT JOIN ACTIVITY ON WORKSTAMP.ACTIVITY_ID = ACTIVITY.ACTIVITY_ID
	WHERE 
	WORKSTAMP.WORKORDER_ID = $workOrderId
	AND
	(WORKSTAMP_TYPE.NAME = 'Start Activity' OR WORKSTAMP_TYPE.NAME = 'End Activity')
	ORDER BY TYPESTAMP
	";
	
	// Execute query - Execution de la requête
	$req = mysqli_query($connect, $r);

	// Number of query results - Nombre de résultats de la requête
	$rows = $req->num_rows;
	
	$list = array();
	$collabList = array();
	
	// For each query result - Pour chaque résultat de la requête
	while($data=$req->fetch_assoc()) {
		
		// Call field - Récupération des champs
		$dateStamp = $data["DATESTAMP"];
		$activityName = $data["ACTIVITYNAME"];
		$typeStamp = $data["TYPESTAMP"];
		$firstName = $data["FIRSTNAME"];
		$lastName = $data["LASTNAME"];
		$cost = $data["COST"];
		$stamp = $data["STAMP"];
			
		$wk = new Workstamp();
			
		$wk->setDate($dateStamp);
		$wk->setActivity($activityName);
		$wk->setType($typeStamp);
		$wk->setCheckTime($stamp);
			
		$cb = new Collaborator();
			
		$cb->setFirstName($firstName);
		$cb->setLastName($lastName);
		$cb->setCost($cost);
			
		$wk->setCollaborator($cb);	
			
		if ($activityName != '') {
				
			$collabList[] = $firstName.'#'.$lastName.'#'.$activityName.'#'.$dateStamp;
			$list[] = $wk;
		}
	}
	
	$collabList = array_unique($collabList);
	$listToSend = array();
	
	// Loop on collaborators - On boucle sur les collaborateurs
	foreach ($collabList as $collab) {
		
		$e = explode("#", $collab);
		$firstName = $e[0];
		$lastName = $e[1];
		$activity = $e[2];
		$date = $e[3];
		
		$oneCollabList = array();
		
		foreach ($list as $wk) {
			
			$wkc = $wk->getCollaborator();
			
			if ($wk->getType() == "End Activity" && $wkc->getFirstName() == $firstName && $wkc->getLastName() == $lastName && $wk->getActivity() == $activity && $wk->getDate() == $date) {
				
				$oneCollabList['firstName'] = $wkc->getFirstName();
				$oneCollabList['lastName'] = $wkc->getLastName();
				$oneCollabList['cost'] = $wkc->getCost();
				$oneCollabList['activity'] = $wk->getActivity();
				$oneCollabList['date'] = $wk->getDate();
				$oneCollabList['endActivity'] = $wk->getCheckTime();
			}
			
			if ($wk->getType() == "Start Activity" && $wkc->getFirstName() == $firstName && $wkc->getLastName() == $lastName && $wk->getActivity() == $activity && $wk->getDate() == $date) {	
				
				$oneCollabList['startActivity'] = $wk->getCheckTime();
			}			
		}
		
		$listToSend[] = $oneCollabList;
	}
	
	// Writing results in JSON format - Ecriture des résultats au format JSON
	echo '{';
	echo '"items": [';
	
	$i = 1;
	$listCount = count($listToSend);
	
	foreach ($listToSend as $entry) {	
		
		$activity = $entry['activity'];
		$date = $entry['date'];
		$noRapport = 11;
		$collab = $entry['firstName'].' '.$entry['lastName'];
		$ecritures = 'Heures directes';
		$cost = $entry['cost'];
		$startActivity = $entry['startActivity'];
		$endActivity = $entry['endActivity'];
		
		$start = strtotime($startActivity);
		$end = strtotime($endActivity);
		
		$diff = $end - $start;
		
		$heures = gmdate('H:i:s', $diff);
		
		// Retrieve Hours & minutes - On récupère les heures et les minutes
		$hours = gmdate('H', $diff);
		$minutes = gmdate('i', $diff);
		
		// Calculation of minutes - On calcule ce que les heures représentent en minutes
		$hoursToMinutes = $hours * 60;
		
		// Total of minutes - On fait le total des minutes
		$minutesTotal = $hoursToMinutes + $minutes;
		
		// Retrieve minutes converted in hours * COLLABORATOR_COST - On calcule ce que le total des minutes représente en heures puis on fait * le coût de l'heure
		$montant = ($minutesTotal / 60) * $cost; 
		
		// Format the amount in 2 decimals - On formate le montant à deux décimales
		$montant = number_format($montant, 2, '.', "'");
		
		$g = '"';
		$d = ':';
		$v = ',';
		
		echo "{";
		
		echo $g.'categorie'.$g.$d.$g.$activity.$g.$v;
		echo $g.'dateRapport'.$g.$d.$g.$date.$g.$v;
		echo $g.'noRapport'.$g.$d.$g.$noRapport.$g.$v;
		echo $g.'collabRapport'.$g.$d.$g.$collab.$g.$v;
		echo $g.'ecritureRapport'.$g.$d.$g.$ecritures.$g.$v;
		echo $g.'heuresRapport'.$g.$d.$g.$heures.$g.$v;
		echo $g.'montantRapport'.$g.$d.$g.$montant.$g;		
		
		echo "}";
		
		// Add comma except for the last line - On ajoute une virgule, sauf pour la dernière ligne
		if ($i < $listCount) {
			echo $v;
		}
		
		$i++;
	}
	
	echo "]";
	echo "}";
}

else {
	
	echo "Aucun ID";
}
?>
