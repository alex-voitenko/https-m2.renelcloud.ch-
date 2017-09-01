var DeviceHistory = (function () {
	
	var DeviceHistory = function (imei, startdate, enddate) {
//		alert('Enter DeviceHistory() Constructor...');
                this.imei = imei || null;
                this.startDate = startdate || null;
                this.endDate = enddate || null;
		this.count = 0;
		this.collection = [];
		this.htmlElement = null;
		this.objectId = null;
                this.DeviceHistoryEvent = new CustomEvent("DeviceHistory", {
				detail: {
                                    count: 0,
                                    steps: undefined,
                                    time: new Date()
				},
				bubbles: true,
				cancelable: false
		});
                this.initialize();
	};

	DeviceHistory.prototype = {
            clear: function() {
                this.collection.splice(0, this.collection.length);
                this.count = this.collection.length; 
            },
            initialize: function() {
                this.load();
            },
            refresh: function() {
                this.clear();
                this.load();
            },
            load: function() {
            var thisDeviceHistory = this;
                this.downloadHistory("device_historyXML.php?imei="+this.imei+"&startdate="+this.startDate+"&enddate="+this.endDate, function(data) {
                    var xml = data.responseXML;
                    var locations = xml.documentElement.getElementsByTagName("location");
                    for (var i = 0; i < locations.length; i++) {
                        var imei = locations[i].getAttribute("imei");
                        var timestamp = locations[i].getAttribute("timestamp");
                        var type = locations[i].getAttribute("type");
                        var status = locations[i].getAttribute("status");
                        var lat = locations[i].getAttribute("lat");
                        var lng = locations[i].getAttribute("lng");
                        var alt = locations[i].getAttribute("alt");
                        var bearing = locations[i].getAttribute("bearing");
                        var speed = locations[i].getAttribute("speed");
                        var item = new DeviceLocation(imei, timestamp, type, status, lat, lng, alt, bearing, speed);
                        thisDeviceHistory.add(item);
                    }
                    thisDeviceHistory.fireEvent();
                });
            },
            downloadHistory: function(url, callback) {
            console.log("Executing DeviceHistory.downloadHistory(..)...");
            var thisDeviceHistory = this;
            var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;
                request.onreadystatechange = function() {
                    if (request.readyState == 4) {
                        request.onreadystatechange = thisDeviceHistory.doNothing();
                        callback(request, request.status);
                    }
                };

                request.open('GET', url, true);
                request.send(null);
            },
            doNothing: function() {
            },
            add: function(item) {
                if(!this.exist(item)) {
                        this.collection.push(item);
                        this.count = this.collection.length;
                }
            },
            remove: function(idx) {
                if(this.collection[idx]!=undefined) {
                        this.collection.splice(idx, 1);
                        this.count = this.collection.length;
                }
            },
            /*
            removeById: function(imei) {
            var result  = this.collection.filter(function(o){return o.imei == imei;} );
                result ? this.collection.splice(this.collection.indexOf(result[0]), 1) : alert('Item not found ...');
            },
            */
            exist: function(item) {
		if($.grep(this.collection, function(e) { return e.timestamp == item.timestamp; }).length===0) {
                    return false;
                }
		else {
                    return true;
		}
            },
            item: function(idx) {
		if(this.collection[idx]!=undefined) {
                    return this.collection[idx];
		}
		return undefined;
            },
            /*
            itemById: function(imei) {
            var result  = this.collection.filter(function(o){return o.imei == imei;} );
		return result ? result[0] : null; // or undefined			
            },
            */
            count: function() {
		return this.count;
            },
            assignEvent: function(element) {
		if (element!==null && typeof element==='object') {
                    this.objectId = new Object();
                    this.objectId = element;
                    this.objectId.addEventListener('DeviceHistory', 'onDeviceHistory', false);
		}
		else {
                    this.htmlElement = element;
                    document.getElementById(this.htmlElement).addEventListener("DeviceHistory", onDeviceHistory, false);
		}
            },
            fireEvent: function() {
		this.DeviceHistoryEvent.detail.count = this.count;
		this.DeviceHistoryEvent.detail.devices = this.collection;
		if (this.objectId!=null){
                    this.objectId.dispatchEvent(this.DeviceHistoryEvent);
		}
		if(this.htmlElement!=null) {
                    document.getElementById(this.htmlElement).dispatchEvent(this.DeviceHistoryEvent);
		}
            },
	};
	return DeviceHistory;
	
})();
