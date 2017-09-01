<?php

if ($_POST['export']) {
	
	$export = $_POST['export'];
	
	// Liste des catégories
	
	$categories = array();
	
	foreach ($export as $item) {
	
		array_push($categories, $item['categorie']);
	}
	
	$categories = array_unique($categories);
	
	$myfile = fopen("export.html", "w") or die("Unable to open file!");
	$headers = '<table style="width:100%; background:#eee; font-family:Arial"><tr style="font-weight:bold; background:orange"><td>No Rapport</td><td>Date</td><td>Collaborateur</td><td>T</td><td>R</td><td>Ecriture</td><td>Heures</td><td>Montant</td></tr>';	
	fwrite($myfile, $headers);
	
	// Pour chaque catégorie
	foreach ($categories as $title) {
		
		$totalHeures = 0;
		$totalMontant = 0;
		
		$t = $title;
		fwrite($myfile, '<tr style="background:#bbb; font-weight:bold"><td>'.$t.'</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>');
		
		// Pour chaque ligne
		foreach ($export as $item) {
			
			// Si la catégorie correspond
			if ($item['categorie'] == $t) {
				
				$date = $item['dateRapport'];
				$noRapport = $item['noRapport'];
				$collab = $item['collabRapport'];
				$ecritures = $item['ecritureRapport'];
				$heures = $item['heuresRapport'];
				$montant = $item['montantRapport'];	
				
				$m = str_replace("'", '', $montant);
				$pieces = explode(":", $heures);
				
				$hours = $pieces[0];
				$minutes = $pieces[1] / 60;
				$seconds = $pieces[2] / 3600;
				
				$th = $hours + $minutes + $seconds;
				
				$totalHeures = $totalHeures + $th;
				$totalMontant = $totalMontant + $m;				
				
				$html = "<tr><td>$noRapport</td><td>$date</td><td>$collab</td><td></td><td></td><td>$ecritures</td><td>$heures</td><td>CHF $montant</td></tr>";	
		
				fwrite($myfile, $html);				
			}
		}
		
		$total = "<tr style='font-weight:bold'><td></td><td></td><td></td><td></td><td></td><td>TOTAL</td><td>".round($totalHeures, 2)." heure(s)</td><td>CHF $totalMontant</td></tr>";
		fwrite($myfile, $total);
		
	}
	
	fwrite($myfile, '</table>');
	fclose($myfile);
	
	echo 'php/export.html';
}

?>

