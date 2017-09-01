<?php 


include_once $_SERVER['DOCUMENT_ROOT'].'/renelmap/config.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/renelmap/LogFile.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/renelmap/MySqlDB.php';

?>

<!DOCTYPE html >
<html>
  <head>
    <title>Renelco MAP Mobile Tracking</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <META http-equiv="Content-Style-Type" content="text/css">
    
    <style media="screen" type="text/css">
        * {
            margin:0;
        }        
        
        div#content {
            display: block; 
            width:100%; 
            min-height: 100%; 
            float:right;
            background-color: transparent;
            border: none;
            padding-bottom: 15000px;
            margin-bottom: -15000px;
        }

        iframe#area {
            width: 100%; 
            height:100vh;
            border: none;
            background-color: transparent;
        }
    </style>

    <script type="text/javascript">
    //<![CDATA[
    
    var map;
    var client;
    
    function load() {
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            client = "Mobile";
        }
        else {
            client = "PC";
        }
    }
    
    function frameLoad() {
        map = document.getElementById("area").contentWindow.map;
    }
    
    //]]>

  </script>
  </head>
  <body onload="load()" style="overflow: hidden;">
      <!-- h1>Hello Brave New World</h1 -->
     <!-- div id="body" -->
        <div id="content">
            <iframe id="area" src="gmap.php" onload="javascript:frameLoad();"/>
        </div>
    <!-- /div -->
  </body>
