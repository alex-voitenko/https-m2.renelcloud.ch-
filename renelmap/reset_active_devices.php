<?php
include_once 'config.php';
include_once 'LogFile.php';
include_once 'MySqlDB.php';
 

//set_time_limit(180);
/*
 * Global Variables
 */

$dbMySQL;
$deletelocations;
$result;

$dom = new DOMDocument("1.0");

// Opens a connection to a MySQL server
    $dbMySQL = new MySqlDB();
    if($dbMySQL->isConnected()) {
        $dbMySQL->dbconnection()->query("SET NAMES utf8");
        $deleteActiveDevices = "DELETE FROM DEVICE_LOCATION";
        $result = $dbMySQL->dbconnection()->query($deleteActiveDevices);
        echo $result;
    }
 ?> 
