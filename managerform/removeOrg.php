<?php
session_start();
include("../config.php");

if(!isset($_SESSION["costumer"])){
  $_SESSION["costumer"]=array();
  $_SESSION["costumer"]["name"]=array();
  $_SESSION["costumer"]["bdd"]=array();
  $_SESSION["costumer"]["pass"]=array();
}
$id=$_POST["id"];
$dem=mysqli_query($connect,"SELECT * FROM ORGANIZATION_UNIT WHERE ORGANIZATION_UNIT_ID = '$id'");
$data=$dem->fetch_assoc();
$address_id=$data["ADDRESS_ID"];
if($address_id > 0)
$req2=mysqli_query($connect,"DELETE FROM ADDRESS WHERE ADDRESS_ID = '$address_id'");


$req=mysqli_query($connect,"DELETE FROM ORGANIZATION_UNIT WHERE ORGANIZATION_UNIT_ID = '$id'");

?>