<?php
include_once 'config.php';
include_once 'LogFile.php';
include_once 'MySqlDB.php';
 

//set_time_limit(180);
/*
 * Global Variables
 */

$dbMySQL;
$selectlocations;
$resultlocations;

$dom = new DOMDocument("1.0");
$node = $dom->createElement("devices");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server
    $dbMySQL = new MySqlDB();
    if($dbMySQL->isConnected()) {
        $dbMySQL->dbconnection()->query("SET NAMES utf8");
        $selectRegisteredDevices = "SELECT DISTINCT D.IMEI, D.COLLABORATOR_ID, D.NAME, D.MODEL, D.MANUFACTURER, D.OS, D.VERSION FROM DEVICE D LEFT JOIN DEVICE_LOCATION_HISTORY DLH ON D.IMEI=DLH.IMEI";
        $resultRegisteredDevices = $dbMySQL->dbconnection()->query($selectRegisteredDevices);
        if($resultRegisteredDevices) {
            mysqli_data_seek($resultRegisteredDevices, 0);
            header("Content-type: text/xml");
            while($device = mysqli_fetch_assoc($resultRegisteredDevices)) {
                $nodeDevice = $dom->createElement("device");
                $nodeDeviceData = $parnode->appendChild($nodeDevice);
                $nodeDeviceData->setAttribute("imei", $device['IMEI']);
                $nodeDeviceData->setAttribute("collaborator_id", $device['COLLABORATOR_ID']);
                $nodeDeviceData->setAttribute("name", $device['NAME']);
                $nodeDeviceData->setAttribute("model", $device['MODEL']);
                $nodeDeviceData->setAttribute("manufacturer", $device['MANUFACTURER']);
                $nodeDeviceData->setAttribute("os", $device['OS']);
                $nodeDeviceData->setAttribute("version", $device['VERSION']);
                /* We don't need Location at this moment
                $nodeLocation = $dom->createElement("location");
                $nodeDeviceLocation = $nodeDevice->appendChild($nodeLocation);
                $nodeDeviceLocation->setAttribute("timestamp", $device['TIMESTAMP']);
                $nodeDeviceLocation->setAttribute("type", $device['TYPE']);
                $nodeDeviceLocation->setAttribute("status", $device['STATUS']);
                $nodeDeviceLocation->setAttribute("lat", $device['LATITUDE']);
                $nodeDeviceLocation->setAttribute("lng", $device['LONGITUDE']);
                $nodeDeviceLocation->setAttribute("alt", $device['ALTITUDE']);
                $nodeDeviceLocation->setAttribute("bearing", $device['BEARING']);
                $nodeDeviceLocation->setAttribute("speed", $device['SPEED']);
                 */
            }
            echo $dom->saveXML();
        }
    }
 ?> 
