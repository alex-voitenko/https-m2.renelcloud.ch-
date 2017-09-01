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


$dem=mysqli_query($connect,"SELECT * FROM CUSTOMER WHERE CUSTOMER_ID = '$id'");
$data=$dem->fetch_assoc();
$address_id=$data["ADDRESS_ID"];
$req2=mysqli_query($connect,"DELETE FROM ADDRESS WHERE ADDRESS_ID = '$address_id'");

$dem2=mysqli_query($connect,"SELECT SITE_ID FROM SITE WHERE CUSTOMER_ID = '$id'");
$data=$dem2->fetch_assoc();
$site_id=$data["SITE_ID"];
$req2=mysqli_query($connect,"DELETE FROM ADDRESS WHERE SITE_ID = '$site_id'");

$dem3=mysqli_query($connect,"SELECT WORKORDER_ID FROM WORKORDER WHERE SITE_ID = '$site_id'");
$data=$dem3->fetch_assoc();
$wo_id=$data["WORKORDER_ID"];

$req4=mysqli_query($connect,"DELETE FROM WORKORDER_COLLABORATOR WHERE WORKORDER_ID = '$wo_id'");

$req4=mysqli_query($connect,"DELETE FROM WORKORDER_ACTIVITY WHERE WORKORDER_ID = '$wo_id'");


$req5=mysqli_query($connect,"DELETE FROM WORKORDER WHERE SITE_ID = '$site_id'");
$req6=mysqli_query($connect,"DELETE FROM SITE_CONTACT WHERE SITE_ID = '$site_id'");
$req3=mysqli_query($connect,"DELETE FROM SITE WHERE CUSTOMER_ID = '$id'");
$req=mysqli_query($connect,"DELETE FROM CUSTOMER WHERE CUSTOMER_ID = '$id'");

?>