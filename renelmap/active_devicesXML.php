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
        $selectActiveDevices = "SELECT D.IMEI, D.COLLABORATOR_ID, D.NAME, D.MODEL, D.MANUFACTURER, D.OS, D.VERSION, DL.TIMESTAMP, DL.TYPE, DL.STATUS, DL.LATITUDE, DL.LONGITUDE, DL.ALTITUDE, DL.BEARING, DL.SPEED, DL.ADDRESS FROM DEVICE_LOCATION DL JOIN DEVICE D ON DL.IMEI=D.IMEI";
        $resultActiveDevices = $dbMySQL->dbconnection()->query($selectActiveDevices);
        if($resultActiveDevices) {
            mysqli_data_seek($resultActiveDevices, 0);
            header("Content-type: text/xml");
            while($device = mysqli_fetch_assoc($resultActiveDevices)) {
                $nodeDevice = $dom->createElement("device");
                $nodeDeviceData = $parnode->appendChild($nodeDevice);
                $nodeDeviceData->setAttribute("imei", $device['IMEI']);
                $nodeDeviceData->setAttribute("collaborator_id", $device['COLLABORATOR_ID']);
                $nodeDeviceData->setAttribute("name", $device['NAME']);
                $nodeDeviceData->setAttribute("model", $device['MODEL']);
                $nodeDeviceData->setAttribute("manufacturer", $device['MANUFACTURER']);
                $nodeDeviceData->setAttribute("os", $device['OS']);
                $nodeDeviceData->setAttribute("version", $device['VERSION']);
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
                $nodeDeviceLocation->setAttribute("address", $device['ADDRESS']);
            }
            echo $dom->saveXML();
        }
    }
    /*
    $url = 'http://192.168.18.17:9763/services/renelco_bma_dev/getDeviceCollaborators';
    $result = file_get_contents($url);
    $devices = simplexml_load_string($result);
    header("Content-type: text/xml");
    foreach($devices->Row as $row) {
        $nodeDevice = $dom->createElement("device");
        $nodeDeviceData = $parnode->appendChild($nodeDevice);
        $nodeDeviceData->setAttribute("imei", $row->IMEI);
        $nodeDeviceData->setAttribute("collaborator_id", $row->COLLABORATOR_ID);
        $nodeDeviceData->setAttribute("name", $row->NAME);
        $nodeDeviceData->setAttribute("model", $row->MODEL);
        $nodeDeviceData->setAttribute("manufacturer", $row->MANUFACTURER);
        $nodeDeviceData->setAttribute("os", $row->OS);
        $nodeDeviceData->setAttribute("version", $row->VERSION);
        $nodeLocation = $dom->createElement("location");
        $nodeDeviceLocation = $nodeDevice->appendChild($nodeLocation);
        $nodeDeviceLocation->setAttribute("timestamp", $row->TIMESTAMP);
        $nodeDeviceLocation->setAttribute("type", $row->TYPE);
        $nodeDeviceLocation->setAttribute("status", $row->STATUS);
        $nodeDeviceLocation->setAttribute("lat", $row->LATITUDE);
        $nodeDeviceLocation->setAttribute("lng", $row->LONGITUDE);
        $nodeDeviceLocation->setAttribute("alt", $row->ALTITUDE);
        $nodeDeviceLocation->setAttribute("bearing", $row->BEARING);
        $nodeDeviceLocation->setAttribute("speed", $row->SPEED);
        $nodeDeviceLocation->setAttribute("address", $row->ADDRESS);
        $nodeCollaborator = $dom->createElement("collaborator");
        $nodeDeviceCollaborator = $nodeDevice->appendChild($nodeCollaborator);
        $nodeDeviceCollaborator->setAttribute("collaborator_id", $row->COLLABORATOR_ID);
        $nodeDeviceCollaborator->setAttribute("collaborator_id", $row->GENDER_ID);
        $nodeDeviceCollaborator->setAttribute("collaborator_id", $row->MANAGER_ID);
        $nodeDeviceCollaborator->setAttribute("collaborator_id", $row->ADDRESS_ID);
        $nodeDeviceCollaborator->setAttribute("collaborator_id", $row->LASTNAME);
        $nodeDeviceCollaborator->setAttribute("collaborator_id", $row->FIRSTNAME);
        $nodeDeviceCollaborator->setAttribute("collaborator_id", $row->EMAIL);
        $nodeDeviceCollaborator->setAttribute("collaborator_id", $row->MOBILENR);
        $nodeDeviceCollaborator->setAttribute("collaborator_id", $row->COST);
        $nodeDeviceCollaborator->setAttribute("collaborator_id", $row->PICTURE_URL);
        $nodeDeviceCollaborator->setAttribute("collaborator_id", $row->APP_ADMIN);
    }
    echo $dom->saveXML();
*/    
 ?> 
