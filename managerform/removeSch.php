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
$dem=mysqli_query($connect,"SELECT * FROM `SCHEDULE_EVENT` WHERE `SCHEDULE_ID` = '$id'");
while($data=$dem->fetch_assoc()){
	$schedule_event_id = $data["SCHEDULE_EVENT_ID"];
	if($schedule_event_id > 0)
	$req2=mysqli_query($connect,"DELETE FROM `SCHEDULE_EVENT` WHERE `SCHEDULE_EVENT_ID` = '$schedule_event_id'");
}

$req=mysqli_query($connect,"DELETE FROM `SCHEDULE` WHERE `SCHEDULE_ID` = '$id'");

?>