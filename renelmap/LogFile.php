<?php
//include_once 'config.php';
 
//set_time_limit(180);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
function logToFile($filename, $msg) { 
    // Check if DEBUG Mode 
    if(debug()) {
        // open file
        $fd = fopen($filename, "a");
        // append date/time to message
        $str = "[" . date("Y/m/d h:i:s", mktime()) . "] " . $msg; 
        // write string
        fwrite($fd, $str . "\n");
        // close file
        fclose($fd);
   }
}