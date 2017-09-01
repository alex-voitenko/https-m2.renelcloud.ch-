<?php

if ($_POST['export']) {

	$export = $_POST['export'];
	$myfile = fopen("export.csv", "w") or die("Unable to open file!");

	$p = ',';
	$r = PHP_EOL;

	$headers = 'categorie'.$p.'dateRapport'.$p.'noRapport'.$p.'collabRapport'.$p.'ecrituresRapport'.$p.'heuresRapport'.$p.'montantRapport'.$r;
	fwrite($myfile, $headers);
	
	foreach ($export as $item) {
		
		$categorie = $item['categorie'];
		$date = $item['dateRapport'];
		$noRapport = $item['noRapport'];
		$collab = $item['collabRapport'];
		$ecritures = $item['ecritureRapport'];
		$heures = $item['heuresRapport'];
		$montant = $item['montantRapport'];
		
		$txt = $categorie.$p.$date.$p.$noRapport.$p.$collab.$p.$ecritures.$p.$heures.$p.$montant.$r;
			
		fwrite($myfile, $txt);
	}
	
	fclose($myfile);
	echo 'php/export.csv';
}



?>
