<?php
session_start();
if(!isset($_SESSION["costumer"])){
  $_SESSION["costumer"]=array();
  $_SESSION["costumer"]["name"]=array();
  $_SESSION["costumer"]["bdd"]=array();
  $_SESSION["costumer"]["pass"]=array();
}
include("../config.php");
$id=$_POST["id"];

$req=mysqli_query($connect,"DELETE FROM MATERIAL WHERE MATERIAL_ID = '$id'");
if(is_file("../images/photo".$id.".jpg")){
	unlink("../images/photo".$id.".jpg");
}elseif(is_file("../images/photo".$id.".png")){
	unlink("../images/photo".$id.".png");
}    

?>