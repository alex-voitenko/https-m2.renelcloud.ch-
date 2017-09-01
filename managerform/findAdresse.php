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

$req=mysqli_query($connect,"SELECT ADDRESS_ID FROM SITE WHERE SITE_ID = '$id'");
$data=$req->fetch_assoc();
$address_id=$data["ADDRESS_ID"];
$req=mysqli_query($connect,"SELECT * FROM ADDRESS WHERE ADDRESS_ID = '$address_id'");
$data=$req->fetch_assoc();
$addresse="&nbsp;".$data["STREETNR"];
$addresse.="&nbsp;".$data["STREET"];
$addresse.="&nbsp;".$data["CITY"];
$addresse.="&nbsp;".$data["ZIP"];
$addresse.="&nbsp;".$data["STATE"];
$addresse.="&nbsp;".$data["COUNTRY"];
echo $addresse;
?>