var DeviceLocation = (function () {
	var DeviceLocation = function (imei, timestamp, type, status, lat, lng, alt, bearing, speed, address) {
//		alert('Enter DeviceLocation() Constructor...');
		this.imei = imei || null;
                this.timestamp = timestamp || null;
                this.type = type || null;
		this.status = status || null;
		this.lat = lat || 0.000000000;
		this.lng = lng || 0.000000000;
		this.alt = alt || 0.000000000;
		this.bearing = bearing || 0.00;
                this.speed = speed || 0;
                this.address = address || null;
//                this.currentLocation = null;
		this.htmlElement = null;
		this.objectId = null;
                this.DeviceLocationEvent = new CustomEvent("DeviceLocation", {
				detail: {
                                    imei: null,
                                    timestamp: null,
                                    type: null,
                                    status: null,
                                    lat: 0.000000000,
                                    lng: 0.000000000,
                                    alt: 0.000000000,
                                    bearing: 0.00,
                                    speed: 0,
                                    address: null,
                                    time: new Date()
				},
				bubbles: true,
				cancelable: false
                });
//		alert('Exit DeviceLocation Constructor...');
	};

	DeviceLocation.prototype = {
            show: function() {
                alert('Device Location Data:\n' +
                        'IMEI:      ' + this.imei + '\n' +	
                        'Timestamp: ' + (this.timestamp!=null) ? this.timestamp : 'undefined' + '\n' + 
                        'Type:      ' + (this.type!=null) ? this.type : 'undefined' + '\n' + 
                        'Status:    ' + (this.status!=null) ? this.status : 'undefined' + '\n' + 
                        'Latitude:  ' + this.lat + '\n' +	
                        'Longitude: ' + this.lng + '\n' +	
                        'Altitude:  ' + this.alt + '\n' +	
                        'Bearing:   ' + this.bearing + '\n' +	
                        'Speed:     ' + this.speed + '\n' +
                        'Address:   ' + this.address + '\n');
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
//		            	alert('No more Events');
                            delete this.events[name];
                        }
                        else {
//			            alert('Nb of Events: ' + this.events[name].length);
                        }
                    }
                }
            },
            dispatchEvent: function(event) {
//		alert('Executing Gender.dispatchEvent(' + JSON.stringify(event) + ') ...');
//		alert('Registered Events: ' + JSON.stringify(this.events[event.type]));
                    var name = event.type;
                for (var i= 0; i<this.events[name].length; i++) {
//		   		alert('Indexed Event: ' + this.events[name][i]);
                    this[this.events[name][i]](event);
                }
                return !event.defaultPrevented;		
            },
            assignEvent: function(element) {
                if (element!==null && typeof element==='object') {
                    this.objectId = new Object();
                    this.objectId = element;
                    this.objectId.addEventListener('DeviceLocation', 'onDeviceLocation', false);
                }
                else {
                    this.htmlElement = element;
                    document.getElementById(this.htmlElement).addEventListener("DeviceLocation", onDeviceLocation, false);
                }
            },
            fireEvent: function() {
                if (this.objectId!=null){
                    this.objectId.dispatchEvent(this.DeviceLocationEvent);
                }
            	if(this.htmlElement!=null) {
                    document.getElementById(this.htmlElement).dispatchEvent(this.DeviceLocationEvent);
		}
            }
	};
	return DeviceLocation;
})();

