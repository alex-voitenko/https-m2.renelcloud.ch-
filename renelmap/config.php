<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//define("HOST", "127.0.0.1");        	// Deltalis renelcloud.ch
//define("HOST", "192.168.18.17");      // Deltalis RDS1: We use the Intranet Address
define("HOST", "192.168.18.117");       // Deltalis RDS2: We use the Intranet Address

//RENELCO_BMA_DEV db parameters
session_start();
 if(!isset($_SESSION["costumer"])){
  $_SESSION["costumer"]=array();
  $_SESSION["costumer"]["name"]=array();
  $_SESSION["costumer"]["bdd"]=array();
  $_SESSION["costumer"]["pass"]=array();
}
 
/*
// Fetch DB connectivity params from session:
define("MYSQL_USR", $_SESSION["costumer"]["name"][0]);
define("MYSQL_PWD", $_SESSION["costumer"]["pass"][0]);
define("MYSQL_DBNAME", $_SESSION["costumer"]["bdd"][0]);
define("MYSQL_DBPORT", ":3306");
*/

// FIXME: HARDCODED Parameters. DO NOT USE; new versions should obtain this from the session!
define("MYSQL_USR", "franco");
define("MYSQL_PWD", "Fr4nc0_R3nE1c0");
define("MYSQL_DBNAME", "RENELCO_BMA_DEV");
define("MYSQL_DBPORT", ":3306");
 
define("PHP_SELF", "<?php echo {$_SERVER['PHP_SELF']}; ?>");
define("DEBUG", true);
define("LOGFILE", $_SERVER['DOCUMENT_ROOT']."/renelmap/main.log");

function mysqlHost() {
    return constant("HOST");
}

function mysqlDBPort() {
    return constant("MYSQL_DBPORT");
}

function mysqlDBName() {
    return constant("MYSQL_DBNAME");
}

function mysqlUsr() {
    return constant("MYSQL_USR");
}

function mysqlPwd() {
    return constant("MYSQL_PWD");
}

function php_self() {
    return constant("PHP_SELF");
}

function debug() {
    return constant("DEBUG");
}

function logfile() {
    return constant("LOGFILE");
}
