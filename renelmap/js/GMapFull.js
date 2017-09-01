//////////////////////////////////////////////////
// Define RenelMapFull Class
//////////////////////////////////////////////////

/** RenelMapFull 
 * This class encapsulates the High-Level Map functionnalities supplied by Google Map.
 * It's a merge of Files RenelMap.js & RenelMapHistory.js
 * It takes in charge both Tracking & History functionnalities. 
 */	
/**
 * @author Hell
 */
/**
 *  RenelMapFull Class Definition 
 */
var RenelMapFull = (function () {
        
	var RenelMapFull = function(mapId, type) {
            console.log("Executing RenelMapFull() Constructor...");
            // Definition of the Icon used to display the Markers
            this.customIcons = {
              OFF: {
                icon: 'images/pin_inactive.png'  
              },
              ON: {
                icon: 'images/pin_active1.png'
              },
              INVISIBLE: {
                icon: 'images/pin_invisible.png'
              },
              START: {
                icon: 'images/flag_green.png'
              },
              END: {
                icon: 'images/flag_red.png'
              },
              POS: {
                icon: 'images/pin-yellow.png'
              },
              POS_OK: {
                icon: 'images/pin-green.png'
              },
              POS_NOK: {
                icon: 'images/pin-red.png'
              },
                
            };
            this.mapId = mapId;             // Id of the HTML Element holding the Map
            this.map = null;                // Google Map Object instance
            this.type = (type!=null) ? type : this.RENELMAP_TYPE.TRACKING;
            this.client = ""                // PC or Mobile Device
            
            this.center = new google.maps.LatLng(46.541100900, 6.582000600);
            this.zoom = 10;
            this.mapProperties = null;
            this.mapTypeId = google.maps.MapTypeId.ROADMAP;
            
            this.activeDevices = null;              // List of currently Active Devices
            this.activeDevice = null;               // Active Device currently selected
            this.activeDeviceAddress = "undefined"; // The Address related to the Position of the selected Active Device;
            this.trackingSelectedDevice = -1;       // Index (in List) of the Active Device currently selected
            this.currentInfoWindow = null;
            
            this.registeredDevices = null;      // List of currently Registered Devices
            this.historySelectedDevice = -1;    // Index (in Dropdown List) of the Registered Device currently selected
            
            this.deviceHistory = null;          // Device History
            this.deviceLocations = [];          // This Array holds the Google Map Markers for the active Devices
            this.deviceHistoryLocations = [];   // This Array holds the Google Map Markers for the current Device History   
            this.historyDataReady = false;
            
            this.refreshRate = 5000;        // Frequency of the Markers Refresh //5000
            this.timerId = null;            // Timer used for Markers Refresh
            this.running = false;           // This Flag is set to true once everything has started
                                            // It is used within onDeviceLocation Event Handler
                                            
            this.routeOnly = false;         // Draw the Route based upon Start & End Position of the History
            this.pathOnly =  false;         // Draw the Path according to all the Positions of the History
            
            this.directionsDisplay = null;  // Google Map Resource used for Route processing
            this.directionsService = null;  // Google Map Resource used for Route processing
            this.flightPath = null;         // Holds Google Map current PolyLine 
            
            this.geocoder = null;
            
            this.initialize();
	};

	RenelMapFull.prototype = {
            RENELMAP_TYPE: {TRACKING: 'TRACKING', HISTORY: 'HISTORY'},
            sayHello: function() {
              alert(this.RENELMAP_TYPE.TRACKING);  
            },
            initialize: function() {
                console.log("Executing RenelMapFull.initialize()...");
                if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                    this.client = "Mobile";
                }
                else {
                    this.client = "PC";
                }
                // Initialize Map Base Properties
                this.mapProperties = {
                    mapTypeControlOptions: {
                        mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID, google.maps.MapTypeId.TERRAIN],
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                        position: google.maps.ControlPosition.RIGHT_TOP
                    },
                    zoomControl: true,
                    zoomControlOptions: {
                        position: google.maps.ControlPosition.RIGHT_CENTER
                    },
                    scaleControl: true,
                    streetViewControl: true,
                    streetViewControlOptions: {
                        position: google.maps.ControlPosition.RIGHT_BOTTOM
                    },
                    fullscreenControl: true,
                    fullscreenControlOptions: {
                        position: google.maps.ControlPosition.RIGHT_CENTER
                    },
                    mapTypeId: this.mapTypeId,
                    center: this.center,
                    zoom: this.zoom,
                };

                // Initialize Google Map Object and additional Resources
                this.map = new google.maps.Map(this.mapId, this.mapProperties);
                
                if(this.type==this.RENELMAP_TYPE.TRACKING) {
                    // Initialize the List of currently Active Devices
                    this.activeDevices = new ActiveDeviceCollection();
                    this.activeDevices.assignEvent(this);
                }
                // Initialize the List of currently Registered Devices
                this.registeredDevices = new RegisteredDeviceCollection();
                this.registeredDevices.assignEvent(this);
                this.registeredDevices.refresh();
            },
            addControl: function(ctrl) {
                if(this.map!=null) {
                    if(ctrl instanceof CenterControl) {
                        this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(ctrl.controlDIV);
                    }
                    if(ctrl instanceof ResetControl) {
                        this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(ctrl.controlDIV);
                    }
                    ctrl.assignEvent(this);
                }
                else {
                    console.log('Can\'t add Additionnal Control to a NULL map');
                }
            },
            start: function() {
            var thisRenelMapFull = this;
            
                if(this.type==this.RENELMAP_TYPE.TRACKING) {
                    // Effectively starts Localization ...
                    this.timerId = setInterval(function() {
                        // Refresh the List of currently Active Devices
                        thisRenelMapFull.activeDevices.refresh();
                        // Set Flag "running" used within ActiveDeviceCollection Event Handler
                        thisRenelMapFull.running = true;
                    }, this.refreshRate);
                }
            },
            stop: function() {
                if(this.type==this.RENELMAP_TYPE.TRACKING) {
                    if(this.timerId!=null) {
                        clearInterval(this.timerId);
                    }
                }
            },
            reset: function() {
            var thisRenelMapFull = this;
                thisRenelMapFull.activeDevices.reset();
                clearActiveDeviceInfo();
            },
            setActiveDeviceLocations: function() {
            console.log("Executing RenelMapFull.setActiveDeviceLocations()...");
            var thisRenelMapFull = this;
            var infoWindow = new google.maps.InfoWindow({pixelOffset: new google.maps.Size(0, 0)});
                for(var idx=0; idx<this.activeDevices.count; idx++) {
                    var device = this.activeDevices.item(idx);
                    var name = device.name;
                    var imei = device.imei;
                    var timestamp = device.currentLocation.timestamp;
                    var status = device.currentLocation.status;
                    var type = device.currentLocation.type;
                    var htmlBgClr = (status==="OFF") ? "#0000ff" : "#ffa500";
                    var point = new google.maps.LatLng(
                                parseFloat(device.currentLocation.lat),
                                parseFloat(device.currentLocation.lng));
                    var address = (device.currentLocation.address===null) ? 'undef.' : device.currentLocation.address;
                    var username = (device.collaborator_id===null) ? 'undef.' : 'Collaborator Name';
                    var icon = (thisRenelMapFull.activeDevice!==null) ? ((thisRenelMapFull.activeDevice.imei===device.imei) ? thisRenelMapFull.customIcons["ON"] : thisRenelMapFull.customIcons["OFF"]) : thisRenelMapFull.customIcons["OFF"];
                    var marker = new MarkerWithLabel({
                        device: device,
                        map: thisRenelMapFull.map,
                        position: point,
                        altitude: device.currentLocation.alt,
                        bearing: device.currentLocation.bearing,
                        speed: device.currentLocation.speed,
                        icon: icon.icon,
                        labelContent: device.name,
                        labelAnchor: new google.maps.Point(50, 60),
                        labelClass: "googleLabels", // the CSS class for the label
                        labelInBackground: true,
                        animation: null
                    });
                    marker.addListener('click', function() {
//                        thisRenelMapFull.setActiveDevice(this.device);
                    });
                   var html =  '    <div id="info-window" style="background-color: #fff; color:#000; width:200px !important;top:500px; left: 500px;border-radius: 5px; border-top: 1px solid #ccc;border-right: 1px solid #ccc; overflow: hidden !important;">' +
                               '        <div style="overflow: hidden !important">' +
                               '            <div style="display: block; background-color:#ea5a23; margin-bottom: 5px; padding: 15px 15px 10px;">' +
                               '                <div>' +
                               '                    <img src="images/android-24.png" style="padding: 5px 0 5px 0; margin-right:10px;vertical-align: middle; float: left;"/>' +
                               '                    <div>' +
                               '                        <p style="font-size:16px;margin-top:0;">' + device.name + '<br/>' +
                               '                        <span style="color:#ffffff;">Status: inactive</span></p>' +
                               '                    </div>' +
                               '                </div>' +
                               '           </div>' +
                               '        </div>' +
                               '        <div style="padding:5px 20px;">' +
                               '            <div style="width:100%;float:left;margin:10px 0;">' +
                               '                <img src="images/clock-4-16-orange.png" style="float:left;width:18px;margin-right:10px;"/>' +
                               '                <p style="color:#E95A22;width:80%;float:left;margin-top:0;font-size:16px;">' + timestamp + '</p>' +
                               '            </div>' +
                               '            <div style="width:100%;float:left;margin:10px 0;">' +
                               '                <img src="images/marker-16.png" style="float:left;width:18px;margin-right:10px;"/>' +
                               '                <p style="color:#747272;width:80%;float:left;margin-top:0;font-size:16px;">' + address + '</p>' +
                               '            </div>' +
                               '            <div style="width:100%;float:left;margin:10px 0;">' +
                               '                <img src="images/speedometer-16-red.png" style="float:left;width:18px;margin-right:10px;"/>' +
                               '                <p style="color:#E95A22;width:80%;float:left;margin-top:0;font-size:16px;">' + Number((device.currentLocation.speed * 3.6).toFixed(2)) + ' km/h</p>' +
                               '            </div>' +
                               '        </div><hr style="clear:both;visibility:hidden;"/></div>';

                    thisRenelMapFull.bindInfoWindow(marker, thisRenelMapFull.map, infoWindow, html);
                    thisRenelMapFull.deviceLocations.push(marker);
                    if((thisRenelMapFull.activeDevice!==null) && (thisRenelMapFull.activeDevice.imei===device.imei)) {
                        infoWindow.setContent(html);
                        google.maps.event.addListener(infoWindow, 'closeclick', function(){
                            thisRenelMapFull.resetActiveDevice();
                        });
                        infoWindow.open(thisRenelMapFull.map, marker);
                        thisRenelMapFull.currentInfoWindow = infoWindow;
                        this.center = new google.maps.LatLng(device.currentLocation.lat, device.currentLocation.lng);
                        this.map.panTo(this.center);
                    }
                }
            },
            refreshActiveDeviceLocations: function() {
            console.log("Executing RenelMapFull.refreshActiveDeviceLocations()...");
    
                this.historyDataReady = false;
                
                // Loop through Markers and set Map to null for each
                for (var i=0; i<this.deviceLocations.length; i++) {
                    this.deviceLocations[i].setMap(null);
                }

                // Reset the Markers array
                this.deviceLocations = [];

                // Call set Markers to re-add Markers
                this.setActiveDeviceLocations();   
            },
            setActiveDevice: function(device) {
                this.activeDevice = device;
            },
            resetActiveDevice: function() {
              this.activeDevice = null;
              this.trackingSelectedDevice = -1;
              setTrackingDevicesList(this.activeDevices, null);
            },
            getAddress: function(position) {
                this.geocoder = new google.maps.Geocoder;                         
                this.geocoder.geocode({'location': position}, function(results, status) {
                var address;
                    if (status === google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            address = results[1].formatted_address;
                        } 
                        else {
                            address = 'Not found.<br/>';
                        }
                    } 
                    else {
                        address = 'Failed to find.';
                    }
                    return address;
                });    
            },
            closeInfoWindow: function(marker) {
                alert('Fuck U');
                if(marker!=null) {
                    marker.infoWindow.close();
                }
            },
            getDeviceHistory: function(imei, startdate, enddate, routeOnly, pathOnly) {
                this.routeOnly = routeOnly;
                this.pathOnly = pathOnly;
                this.deviceHistory = new DeviceHistory(imei, startdate.replace(' ', '%20'), enddate.replace(' ', '%20'));
                this.deviceHistory.assignEvent(this);
                this.deviceHistory.load();
            },
            setDeviceHistoryLocations: function() {
            console.log("Executing RenelMapHistory.setDeviceHistoryLocations()...");
            var thisRenelMapFull = this;
            var infoWindow = new google.maps.InfoWindow;
                for(var idx=0; idx<this.deviceHistory.count; idx++) {
                    var historyLocation = this.deviceHistory.item(idx);
                    var imei = historyLocation.imei;
                    var timestamp = historyLocation.timestamp;
                    var status = historyLocation.status;
                    var type = historyLocation.type;
                    var point = new google.maps.LatLng(
                                    parseFloat(historyLocation.lat),
                                    parseFloat(historyLocation.lng));
                    var speed = (historyLocation.speed*3600)/1000;
                    var htmlBgClr = (speed>120) ? "#ff0000" : "#ffffff";
                    var html = '<body style="padding: 0px; margin: 0px"><div style="background-color:'+ htmlBgClr +'; width:100%;"><b>' + name + '</b> <br/>' + imei + '</b> <br/>' + parseInt(speed).toString() + 'km/h <br/>' + timestamp + '</div></body>';
                    switch(idx) {
                        case 0:
                            var icon = thisRenelMapFull.customIcons['START'] || {};
                            break;
                        case this.deviceHistory.count-1:
                            var icon = thisRenelMapFull.customIcons['END'] || {};
                            break;
                        default:
                            if(speed>120) {
                                var icon = thisRenelMapFull.customIcons['POS_NOK'] || {};
                            }
                            if((speed>=50) && (speed<=120)) {
                                var icon = thisRenelMapFull.customIcons['POS_OK'] || {};
                            }
                            if(speed<50) {
                                var icon = thisRenelMapFull.customIcons['POS'] || {};
                            }
                            break;
                    }
                    var marker = new MarkerWithLabel({
                                    map: thisRenelMapFull.map,
                                    position: point,
                                    labelContent: device.name,
                                    labelAnchor: new google.maps.Point(50, 60),
                                    labelClass: "googleLabels", // the CSS class for the label
                                    labelInBackground: true,                                 
                                    icon: icon.icon});
                    thisRenelMapFull.bindInfoWindow(marker, thisRenelMapFull.map, infoWindow, html);
                    thisRenelMapFull.deviceHistoryLocations.push(marker);
                }
                thisRenelMapFull.historyDataReady = true;
            },
            refreshDeviceHistoryLocations: function() {
            console.log("Executing thisRenelMapFull.refreshDeviceHistoryLocations()...COUCOU");
                // Loop through markers and set map to null for each
                this.hideMarkers();
                // Reset the markers array
                this.deviceHistoryLocations = [];
                // Call set markers to re-add markers
                this.setDeviceHistoryLocations();        
            },
            drawHistoryRoutes: function() {
                if(this.routeOnly==true) {
                    this.traceRoute();
                }
                if(this.pathOnly==true) {
                    this.tracePolyLine();
                }
            },
            traceRoute: function() {
            var thisRenelMapFull = this;
            var org;
            var dest;
            
                thisRenelMapFull.clearRoute();
                
                if(this.deviceHistoryLocations.length>0) {
                    org = this.deviceHistoryLocations[0];
                    dest = this.deviceHistoryLocations[this.deviceHistoryLocations.length-1];
                    var request = {
                        origin: new google.maps.LatLng(org.getPosition().lat(), org.getPosition().lng()),
                        destination: new google.maps.LatLng(dest.getPosition().lat(), dest.getPosition().lng()),
                        travelMode: google.maps.TravelMode.DRIVING
                    };
                    this.directionsService.route(request, function(result, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            thisRenelMapFull.directionsDisplay.setDirections(result);
                        } else {
                            alert("couldn't get directions:" + status);
                        }
                    });
                }
                else {
                    alert("No History Data. Can't trace Route ...")
                }
            },
            clearHistory: function() {
                this.resetPolyLine();
            },
            clearRoute: function() {
            var thisRenelMapFull = this;
//                if(thisRenelMapFull.directionsDisplay!=null) {
//                    thisRenelMapFull.directionsDisplay.setDirections({routes: []});
//                }
                thisRenelMapFull.directionsDisplay = new google.maps.DirectionsRenderer({
                    polylineOptions: { 
                        strokeColor: "#0000ff" 
                    },
                    suppressMarkers: true
                });
                this.hideMarkers();
                this.directionsDisplay.setMap(this.map);
                this.directionsService = new google.maps.DirectionsService();
            },
            showMarkers: function() {
                for (var idx=1; idx<this.deviceHistoryLocations.length-1; idx++) {
                    this.deviceHistoryLocations[idx].setMap(this.map);
                }
            },
            hideMarkers: function() {
                for (var idx=1; idx<this.deviceHistoryLocations.length-1; idx++) {
                    this.deviceHistoryLocations[idx].setMap(null);
                }
            },
            resetMarkers: function() {
                for (var idx=0; idx<this.deviceHistoryLocations.length; idx++) {
                    this.deviceHistoryLocations[idx].setMap(null);
                }
                this.deviceHistoryLocations.length = 0;  
            },
            tracePolyLine: function() {
            var thisRenelMapFull = this;
            var flightPathCoordinates  = [];
            
                thisRenelMapFull.clearPolyLine();
                
                if(this.deviceHistoryLocations.length>0) {
                    for(var i=0; i<this.deviceHistoryLocations.length-1; i++) {
                        var pt = this.deviceHistoryLocations[i];
                        flightPathCoordinates.push({lat: pt.position.lat(), lng: pt.position.lng()});
                    }
                    thisRenelMapFull.flightPath = new google.maps.Polyline({
                                                geodesic: true,
                                                path: flightPathCoordinates,
                                                strokeColor: '#f16530',
                                                strokeOpacity: 1.0,
                                                strokeWeight: 5
                                            });
                    thisRenelMapFull.flightPath.setMap(this.map);
                }
                else {
                    alert("No History Data. Can't trace PolyLine...")
                }
            },
            resetPolyLine: function() {
                if(this.flightPath!=null) {
                    this.flightPath.setMap(null);
                }
                this.resetMarkers();
            },
            clearPolyLine: function() {
                if(this.flightPath!=null) {
                    this.flightPath.setMap(null);
                }
                this.showMarkers();
            },
            bindInfoWindow: function(marker, map, infoWindow, html) {
                google.maps.event.addListener(marker, 'click', function() {
                    infoWindow.setContent(html);
                    infoWindow.open(map, marker);
                });
            },
            setHistory: function() {
                
            },
            refreshHistoryInfo: function() {
            var thisRenelMapFull = this;
//                alert('--- ' + this.activeDevice.imei);
                if(this.deviceHistory!=null) {
                    $('#txt-imei').text(this.deviceHistory.imei);
                    $('#txt-startdate').text(this.deviceHistory.startDate.replace('%20', ' '));
                    $('#txt-enddate').text(this.deviceHistory.endDate.replace('%20', ' '));
                }
                else {
                    this.clearHistoryInfo();
                }
            },
            clearHistoryInfoInfo: function() {
                $('#txt-imei').text('- - - - - - - - - - - - - - -');
                $('#txt-startdate').text('- - - -.- -.- -    - -:- -');
                $('#txt-enddate').text('- - - -.- -.- -   - -:- -');
            },
            addEventListener: function(name, handler, capture) {
                if (!this.events) this.events = {};
		if (!this.events[name]) this.events[name] = [];
                    this.events[name].push(handler);
            },
            removeEventListener: function(name, handler) {
                if (!this.events) return;
		if (!this.events[name]) return;
		for (var i = this.events[name].length - 1; i >= 0; i--) {
		    if (this.events[name][i] == handler) {
		        this.events[name].splice(i, 1);
		        if(!this.events[name].length) {
                            delete this.events[name];
		        }
                        else {
		        }
		    }
		}
            },
            dispatchEvent: function(event) {
		var name = event.type;
                for (var i= 0; i<this.events[name].length; i++) {
                    this[this.events[name][i]](event);
		}
		return !event.defaultPrevented;		
            },
            onActiveDeviceCollection: function(event) {
            console.log("onActiveDeviceLocation Event fired ...");
                if(!this.running) {
                    this.start();       // Let's start Localization Process
                }
                else {
                    this.refreshActiveDeviceLocations();    // Refresh Device Localization
                }
            },
            onRegisteredDeviceCollection: function(event) {
            console.log("onRegisteredDeviceCollection Event fired ...");
            },
            onDeviceHistory: function(event) {
            console.log("onDeviceHistory Event fired ...");
                this.refreshDeviceHistoryLocations();
                this.drawHistoryRoutes();
                this.refreshHistoryInfo();
            } ,
            onCenterControl: function(event) {
                console.log('Event received from CenterControl Object');
                this.map.setCenter(event.detail.center);
            },
            onResetControl: function(event) {
                console.log('Event received from ResetControl Object');
                this.clearHistory();
                this.clearPolyLine();
                this.clearRoute();
            },
            onHistoryControl: function(event) {
                console.log('Event received from HistoryControl Object');
                open_history_dlg();
            }
        };		
	return RenelMapFull;
})();
