<?php
function telecharge($photo,$larg,$haut,$dest,$new_larg){
	$coef= $haut * $new_larg;	
	$new_hauteur=$coef/$larg;
	$tempo = imagecreatefromjpeg($dest);
	$nouvelle = imagecreatetruecolor($new_larg,$new_hauteur);
	imagecopyresampled($nouvelle,$tempo,0,0,0,0,$new_larg,$new_hauteur,$larg,$haut);
	imagejpeg($nouvelle,$dest);
}
?>