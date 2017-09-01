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
     
    <link rel="stylesheet" type="text/css" href="css/history_style.css">
    <link rel="stylesheet" type="text/css" href="css/tracking_style.css">
    <link rel="stylesheet" type="text/css" href="css/gmapcontrols_style.css">
    <link rel="stylesheet" type="text/css" href="css/gmap_style.css">
    
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
    
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.20&key=AIzaSyAiWsOnG-AKWdyr3lwW1X2Y8QDhPETXC9I&libraries=drawing"></script>
    
    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

    <script type="text/javascript" src="js/Device.js"></script>
    <script type="text/javascript" src="js/DeviceLocation.js"></script>
    <script type="text/javascript" src="js/DeviceCollection.js"></script>
    <script type="text/javascript" src="js/DeviceHistory.js"></script>
    
    <script type="text/javascript" src="js/tracking.js"></script>
    <script type="text/javascript" src="js/history.js"></script>
    
    <script  type="text/javascript" src="js/jquery.datetimepicker.full.js"></script>
    <script type="text/javascript" src="js/gmaps-markerwithlabel-1.9.1.js"></script>
    <script type="text/javascript" src="js/GMapControls.js"></script>
    <script type="text/javascript" src="js/GMapFull.js"></script>

    <script type="text/javascript">
    //<![CDATA[
    
    /**
     * VARIABLES Declaration
     */
    var mapTracking;
    var mapHistory;
    
    var mapCenterCtrl;
    var mapResetCtrl;
    var mapHistoryCtrl;
    
    var client;
    
    
    /**
     * PAGE Initialization
     */
    function load() {
        // Check current Client/Device
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            client = "Mobile";
        }
        else {
            client = "PC";
        }
        // Initialize Tracking Map Object
        mapTracking = new RenelMapFull(document.getElementById("mapTracking"), RenelMapFull.prototype.RENELMAP_TYPE.TRACKING);
        var mapCenterCtrl = new CenterControl(document, mapTracking, new google.maps.LatLng(46.541100900, 6.582000600));
        // Initialize History Map Object
        mapHistory = new RenelMapFull(document.getElementById("mapHistory"), RenelMapFull.prototype.RENELMAP_TYPE.HISTORY);
        var mapResetControl = new ResetControl(document, mapHistory);
        
        // Set Tracking as default View
        showTracking();
    }
    
    /**
     * TRACKING related Operations
     */
    function open_devices_list() {
        showTracking();
        $('#history').css('pointer-events', 'none');
        $('#devices-list').css('pointer-events', 'none');
        $('#form-history').css('pointer-events', 'none');
        slideTrackingPanel();
    }
    
    function close_devices_list() {
        $('#history').css('pointer-events', 'auto');
        $('#devices-list').css('pointer-events', 'auto');
        $('#form-history').css('pointer-events', 'auto');
        slideTrackingPanel();
    }

    function setActiveDevice(imei) {
        mapTracking.trackingSelectedDevice = $( "li" ).index(document.getElementById(imei));
        mapTracking.activeDevice = mapTracking.activeDevices.itemById(imei);
        close_devices_list();
    }
        
    function showTracking() {
        $('#mapTracking').css('z-index', '10');
        $('#tracking').css('background-color', '#fff');
        $('#mapHistory').css('z-index', '-10');
        $('#history').css('background-color', 'transparent');
        setTrackingDevicesList(mapTracking.activeDevices, mapTracking.trackingSelectedDevice);
    }   
    
    /**
     * HISTORY related Operations
     */
    function open_history_dlg() {
        showHistory();
        $('#tracking').css('pointer-events', 'none');
        $('#devices-list').css('pointer-events', 'none');
        $('#form-history').css('pointer-events', 'none');
        slideHistoryPanel();
    }

    function close_history_dlg() {
        $('#tracking').css('pointer-events', 'auto');
        $('#devices-list').css('pointer-events', 'auto');
        $('#form-history').css('pointer-events', 'auto');
        slideHistoryPanel();
     }

    function getHistory() {
    var imei = $('#registered_devices :selected').val();
    mapHistory.historySelectedDevice = $('#registered_devices :selected').index();
    var startDate = $('#start_date').val();
    var endDate = $('#end_date').val();
    var routeOnly = $('#route_only').attr('checked')=='checked';
    var pathOnly = $('#path_only').attr('checked')==='checked';
        alert("imei: " + imei + "\n" + "Start Date: " + startDate + "\n" + "End Date: " + endDate)
        mapHistory.getDeviceHistory(imei, startDate, endDate, routeOnly, pathOnly);
        close_history_dlg();
    }
    
    function showHistory() {
        $('#mapTracking').css('z-index', '-10');
        $('#tracking').css('background-color', 'transparent');
        $('#mapHistory').css('z-index', '10');
        $('#history').css('background-color', '#fff');
        setHistoryDeviceList(mapHistory.registeredDevices, mapHistory.historySelectedDevice);
    }
    
    //]]>

  </script>
  </head>
  <body onload="load()" style="min-width: 640px; min-height: 480px; overflow:hidden">
      
    
    <div id="wrapper">
        <!-- Navigation Left SideBar -->
        <div id="nav-sidebar">  
            <img id="tracking" src="images/carte.png" onclick="javascript: showTracking();"/>
            <img id="history" src="images/route.png" onclick="javascript: showHistory();"/>
            <!-- a href="info.php" ><img id="info" src="images/info.png"/></a -->
        </div>

            <!-- Navigation Header Bar -->
            <div id="nav-header">  
                <img id="devices-list" src="images/liste.png" onclick="javascript: open_devices_list();"/>
                <img id="form-history" src="images/path.png" onclick="javascript: open_history_dlg();"/>
            </div>

        <div id="content">
            <!-- Map Area for both Tracking & History -->
            
            <div id="panelMap">
                
                <!-- History Slide Panel -->
                <div class="panelHistory">
                    <!-- History Form -->
                    <form action="#" class="formHistory" method="post">
                        <div id="close-panel-history" class="history">
                            <img id="close-panel" class="history" src="images/arrow-89-128_Left.png" onclick ="close_history_dlg()">
                        </div>
                        <h2 class="history">History Parameters</h2>
                        <select id="registered_devices" class="history" name="devices" >
                        </select>
                        <input type="text" class="history" value="" id="start_date" placeholder="Start Date" onfocus="javascript:blur();" onclick="$('#datetimepicker').datetimepicker()">
                        <input type="text" class="history" value="" id="end_date" placeholder="End Date" onfocus="javascript:blur();" onclick="$('#datetimepicker').datetimepicker()">
                        <div id="RoutePathSelection" style="text-align: center;">
                            <label class="chkbox_label"><input id="route_only" class="history" type="checkbox" name="route_path" />Route </label>
                            <label class="chkbox_label"><input id="path_only" class="history" type="checkbox" name="route_path" />Path </label>
                        </div>
                        <a href="javascript:getHistory()" id="submit">Set</a>
                    </form>
                </div>
                <!-- History Slide Panel Ends Here -->
                
                <!-- Devices List Slide Panel -->
                <div class="panelDevices">
                    <div id="close-panel-history" class="history" style="margin-top:3em;">
                        <img id="close-list" class="collabo" src="images/arrow-89-128_Up.png" onclick="javascript: close_devices_list();"/>
                        </div>
                    <div id="list-header" class="panelDevices-list-header">
                        <h2>Active Devices</h2>
                    </div>
                    <div id="list-body" class="panelDevices-list-body">
                        <ul id="list-list1" class="panelDevices-list">
                        </ul>
                    </div>
                    <div id="list-footer">
                    </div>
                </div>
                <!-- Devices List Slide Panel Ends Here -->    
                
                <!-- Maps Divs -->
                <div id="mapTracking"></div>
                <div id="mapHistory"></div>
                <!-- End of Maps Divs -->
                
            </div>
        </div>
    </div>
  </body>

  <!-- DateTimePicker Script -->
  <script>
    /* DateTimePicker helpers */ 
    $.datetimepicker.setLocale('en');
    
    $('#start_date').datetimepicker({
        theme:'dark',    
        format:'Y-m-d H:i:00',
        //mask:'9999-19-39 29:59',
        dayOfWeekStart : 1,
        step: 10,
        lang:'en',
        value: new Date()
    });

    $('#end_date').datetimepicker({
        theme:'dark',    
        format:'Y-m-d H:i:00',
        //mask:'9999-19-39 29:59',
        dayOfWeekStart : 1,
        step: 10,
        lang:'en',
        value: new Date()
    });
   
   </script>
  
</html>