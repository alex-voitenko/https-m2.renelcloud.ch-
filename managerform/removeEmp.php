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
if(is_file("../images/".$prefixe."_avatar".$id.".jpg")){
	unlink("../images/".$prefixe."_avatar".$id.".jpg");
}elseif(is_file("../images/".$prefixe."_avatar".$id.".png")){
	unlink("../images/".$prefixe."_avatar".$id.".png");
} 

$dem=mysqli_query($connect,"SELECT * FROM COLLABORATOR WHERE COLLABORATOR_ID = '$id'");
$data=$dem->fetch_assoc();
$address_id=$data["ADDRESS_ID"];
$req2=mysqli_query($connect,"DELETE FROM ADDRESS WHERE ADDRESS_ID = '$address_id'");
$req3=mysqli_query($connect,"DELETE FROM COLLABORATOR_ACTIVITY WHERE COLLABORATOR_ID = '$id'");
$req3=mysqli_query($connect,"DELETE FROM WORKORDER_COLLABORATOR WHERE COLLABORATOR_ID = '$id'");
$req=mysqli_query($connect,"DELETE FROM COLLABORATOR WHERE COLLABORATOR_ID = '$id'");




?>