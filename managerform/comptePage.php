<?php
session_start();
if(!isset($_SESSION["costumer"])){
  $_SESSION["costumer"]=array();
  $_SESSION["costumer"]["name"]=array();
  $_SESSION["costumer"]["bdd"]=array();
  $_SESSION["costumer"]["pass"]=array();
    $_SESSION["costumer"]["compte"]=array();
}
include("config.php");
$page=$_POST["page"];
array_push($_SESSION["costumer"]["compte"],$page);

?>