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

$req=mysqli_query($connect,"DELETE FROM SITE WHERE SITE_ID = '$id'");
$req2=mysqli_query($connect,"DELETE FROM SITE_CONTACT WHERE SITE_ID = '$id'");
?>