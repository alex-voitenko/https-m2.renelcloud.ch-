<?php
include_once 'config.php';
include_once 'LogFile.php';
include_once 'MySqlDB.php';
 
//set_time_limit(180);
/*
 * Global Variables
 */

$dbMySQL;
$selectHistory;
$resultHistory;
$imei = $_GET["imei"];
$startdate = $_GET["startdate"];
$enddate = $_GET["enddate"];

$dom = new DOMDocument("1.0");
$node = $dom->createElement("history");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server
    $dbMySQL = new MySqlDB();
    if($dbMySQL->isConnected()) {
        $dbMySQL->dbconnection()->query("SET NAMES utf8");
        $selectHistory = "SELECT DLH.* FROM DEVICE_LOCATION_HISTORY DLH JOIN DEVICE D ON DLH.IMEI=D.IMEI WHERE DLH.IMEI=".$imei." AND DLH.TIMESTAMP > '".$startdate."' AND DLH.TIMESTAMP < '".$enddate."' ORDER BY TIMESTAMP ASC";
        $resultHistory = $dbMySQL->dbconnection()->query($selectHistory);
        if($resultHistory) {
            mysqli_data_seek($resultHistory, 0);
            header("Content-type: text/xml");
            while($location = mysqli_fetch_assoc($resultHistory)) {
                $node = $dom->createElement("location");
                $newnode = $parnode->appendChild($node);
                $newnode->setAttribute("imei", $location['IMEI']);
                $newnode->setAttribute("timestamp", $location['TIMESTAMP']);
                $newnode->setAttribute("status", $location['STATUS']);
                $newnode->setAttribute("type", $location['TYPE']);
                $newnode->setAttribute("lat", $location['LATITUDE']);
                $newnode->setAttribute("lng", $location['LONGITUDE']);
                $newnode->setAttribute("alt", $location['ALTITUDE']);
                $newnode->setAttribute("bearing", $location['BEARING']);
                $newnode->setAttribute("speed", $location['SPEED']);
            }
            echo $dom->saveXML();
        }
    }
  ?> 