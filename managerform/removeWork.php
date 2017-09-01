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
$req=mysqli_query($connect,"DELETE FROM WORKORDER_MATERIAL WHERE WORKORDER_ID = '$id'");
$req=mysqli_query($connect,"DELETE FROM WORKORDER_COLLABORATOR WHERE WORKORDER_ID = '$id'");
$req=mysqli_query($connect,"DELETE FROM WORKORDER_ACTIVITY WHERE WORKORDER_ID = '$id'");
$req=mysqli_query($connect,"DELETE FROM WORKORDER WHERE WORKORDER_ID = '$id'");

?>