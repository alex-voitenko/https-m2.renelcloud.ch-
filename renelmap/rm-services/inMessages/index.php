<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/renelmap/config.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/renelmap/LogFile.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/renelmap/MySqlDB.php';

//set_time_limit(180);
/*
 * Global Variables
 */
$contentType;
$clientId;
$action;
$locationData;
$dbMySQL;

/* 
 * Helpers 
 */

/**
 * checkRequestHeader()
 * @return boolean
 */

function checkRequestHeader() {
logToFile(logfile(), 'checkRequestHeader()');

/* Logs all available headers to logfile */
foreach (getallheaders() as $name => $value) {
	logToFile(logfile(),  "$name: $value\n");
}

$GLOBALS['contentType'] = getallheaders()['Content-Type'];
$GLOBALS['clientId'] = getallheaders()['clientId'];
$GLOBALS['action'] = getallheaders()['action']; 
$retCode = true;

    // FOR TESTING ONLY We bypass checking
//    logToFile(logfile(), 'ERROR: '.$GLOBALS['contentType'].' - Wrong Content-Type Header Parameter.');
//    logToFile(logfile(), 'ERROR: '.$GLOBALS['clientId'].' - Wrong ClientId Header Parameter.');
//    return retCode;
    
    if(strstr($GLOBALS['contentType'], 'application/json')==FALSE) {
        logToFile(logfile(), 'ERROR: '.$GLOBALS['contentType'].' - Wrong Content-Type Header Parameter.');
        $retCode = false;
    }
    else {
//        logToFile(logfile(), 'ContentType Header Parameter is correct');
        if(strstr($GLOBALS['clientId'], 'renelmap')==FALSE) {
            logToFile(logfile(), 'ERROR: '.$GLOBALS['clientId'].' - Wrong clientId Header Parameter');
            $retCode = false;
        }
        else {
            if((strstr($GLOBALS['action'], 'tracking')==FALSE) && (strstr($GLOBALS['action'], 'register')==FALSE)) {
                logToFile(logfile(), 'ERROR: '.$GLOBALS['clientId'].' - Wrong clientId Header Parameter');
                $retCode = false;
            }
            else {
//                logToFile(logfile(), 'action Header Parameter is correct');
            }
        }
    }
    return $retCode;
}

function checkRequestParameters() {
logToFile(logfile(), 'checkRequestParameters()');
$retCode = true;    
    $request = file_get_contents('php://input');
    $message = json_decode($request, true);
    if($message==null) {
        logToFile(logfile(), 'INVALID Message !!!');
        $retcode = false;
    }
    else {
        logToFile(logfile(), 'VALID Message ...');
        $GLOBALS['locationData'] = $message["message"];
        if($GLOBALS['locationData']==null) {
            logToFile(logfile(), 'INVALID Data ...');
            $retcode = false;
        }
        else {
            logToFile(logfile(), 'VALID Data ...');
        }
    }
    return $retCode;
}

function storeLocation() {
$retCode = true;

	debugShowDBParams();

    $GLOBALS['dbMySQL'] = new MySqlDB();
    if($GLOBALS['dbMySQL']->isConnected()) {
        logToFile(logfile(), 'DB Connection SUCCESS');
        $timestamp = date('Y-m-d H:i:s', strtotime($GLOBALS['locationData']["timestamp"]));
        $latitude = ($GLOBALS['locationData']["latitude"]==null) ? 0.000000000 : $GLOBALS['locationData']["latitude"];
        $longitude = ($GLOBALS['locationData']["longitude"]==null) ? 0.000000000 : $GLOBALS['locationData']["longitude"];
        $altitude = ($GLOBALS['locationData']["altitude"]==null) ? 0.000000000 : $GLOBALS['locationData']["altitude"];
        $bearing = ($GLOBALS['locationData']["bearing"]==null) ? 0.00 : $GLOBALS['locationData']["bearing"];
        $speed = ($GLOBALS['locationData']["speed"]==null) ? 0 : $GLOBALS['locationData']["speed"];
        $address = ($GLOBALS['locationData']["address"]==null) ? 0 : $GLOBALS['locationData']["address"]["formatted_address"];
        logToFile(logfile(), '---- '.$timestamp);

        $deleteLocation = "DELETE FROM DEVICE_LOCATION WHERE IMEI = ".$GLOBALS['locationData']["imei"]; 
        $GLOBALS['dbMySQL']->dbconnection()->query("SET NAMES utf8");
        if ($GLOBALS['dbMySQL']->dbconnection()->query($deleteLocation) === TRUE) {
            logToFile(logfile(), 'Location Data successfully deleted from DB');
            $insertLocation = "REPLACE INTO DEVICE_LOCATION (IMEI, TIMESTAMP, TYPE, STATUS, LATITUDE, LONGITUDE, ALTITUDE, BEARING, SPEED, ADDRESS) " .
                              "VALUES (".$GLOBALS['locationData']["imei"].", '".$timestamp."', '".$GLOBALS['locationData']["type"]."','".$GLOBALS['locationData']["engineStatus"]."',".$latitude.",".$longitude.", ".$altitude.", ".$bearing.", ".$speed.", '".$address."')"; 
            logToFile(logfile(), $insertLocation);

            $GLOBALS['dbMySQL']->dbconnection()->query("SET NAMES utf8");
            if ($GLOBALS['dbMySQL']->dbconnection()->query($insertLocation) === TRUE) {
                logToFile(logfile(), 'Location Data successfully inserted into DB');
            } 
            else {
                logToFile(logfile(), 'Failed to insert Location Data into DB: ' . $GLOBALS['dbMySQL']->dbconnection()->error);
                $retCode = false;
            }
        } 
        else {
            logToFile(logfile(), 'Failed to update Location Data in DB: ' . $GLOBALS['dbMySQL']->dbconnection()->error);
            $retCode = false;
        }
    }
    else {
        logToFile(logfile(), 'DB Connection ERROR');
        $retCode = false;
    }
    return $retCode;
}

function debugShowDBParams() {
	logToFile(logfile(), "MYSQL DB params:");
	logToFile(logfile(), "DBHost:" . constant("HOST"));
	logToFile(logfile(), "DBName: ". constant("MYSQL_DBNAME"));	
	logToFile(logfile(), "DBUser: ". constant("MYSQL_USR"));
}

/*
 * Action Starts Here ...
 */

if(checkRequestHeader()) {
    logToFile(logfile(), 'HELL WITH' . $GLOBALS['action']);
    // Tracking Information Received
    if(strstr($GLOBALS['action'], 'tracking')==TRUE) {
        
        if(checkRequestParameters()) {
            $GLOBALS['locationData']["address"] = getLocationData($GLOBALS['locationData']["latitude"], $GLOBALS['locationData']["longitude"]);
			
            if(storeLocation()) {
                logToFile(logfile(), 'Data stored SUCCESSFULLY');
                return http_response_code(200);
            }
            else {
                logToFile(logfile(), 'FAILED to store Data');
                return http_response_code(500);
            }
        }
        else {
            logToFile(logfile(), 'Invalid Request Parameters');
            return http_response_code(500);
        }
    }
    // Registration Information Received
    else if(strstr($GLOBALS['action'], 'register')==TRUE) {
      
    }
    else  {
        logToFile(logfile(), 'Invalid Request Action: ' . $GLOBALS['action']);
        return http_response_code(500);
    }
}
else {
    logToFile(logfile(), 'Invalid Request Header');
    return http_response_code(500);
}

/*
 * GoogleMap Helpers
 * This set of functions lets us retrieve Address information according to Latitude/Longitude 
 */

function getLocationData($lat, $lng) {

    $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false";

    // Make the HTTP request
    $data = @file_get_contents($url);
    // Parse the json response
    $jsondata = json_decode($data,true);

    // If the json data is invalid, return empty array
    if (!check_status($jsondata))   return array();

    $address = array(
        'country' => google_getCountry($jsondata),
        'province' => google_getProvince($jsondata),
        'city' => google_getCity($jsondata),
        'street' => google_getStreet($jsondata),
        'postal_code' => google_getPostalCode($jsondata),
        'country_code' => google_getCountryCode($jsondata),
        'formatted_address' => google_getAddress($jsondata),
    );

    return $address;
}

/* 
* Check if the json data from Google Geo is valid 
*/

function check_status($jsondata) {
    if ($jsondata["status"] == "OK") return true;
    return false;
}

/*
* Given Google Geocode json, return the value in the specified element of the array
*/

function google_getCountry($jsondata) {
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"]);
}
function google_getProvince($jsondata) {
    return Find_Long_Name_Given_Type("administrative_area_level_1", $jsondata["results"][0]["address_components"], true);
}
function google_getCity($jsondata) {
    return Find_Long_Name_Given_Type("locality", $jsondata["results"][0]["address_components"]);
}
function google_getStreet($jsondata) {
    return Find_Long_Name_Given_Type("street_number", $jsondata["results"][0]["address_components"]) . ' ' . Find_Long_Name_Given_Type("route", $jsondata["results"][0]["address_components"]);
}
function google_getPostalCode($jsondata) {
    return Find_Long_Name_Given_Type("postal_code", $jsondata["results"][0]["address_components"]);
}
function google_getCountryCode($jsondata) {
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"], true);
}
function google_getAddress($jsondata) {
    return $jsondata["results"][0]["formatted_address"];
}

/*
* Searching in Google Geo json, return the long name given the type. 
* (If short_name is true, return short name)
*/

function Find_Long_Name_Given_Type($type, $array, $short_name = false) {
    foreach( $array as $value) {
        if (in_array($type, $value["types"])) {
            if ($short_name)    
                return $value["short_name"];
            return $value["long_name"];
        }
    }
}

?> 
