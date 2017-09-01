
var ActiveDeviceCollection = (function () {
	
	var ActiveDeviceCollection = function () {
		console.log('Enter ActiveDeviceCollection() Constructor...');
                this.xmlLoadScriptName = "active_devicesXML.php";
                this.xmlResetScriptName = "reset_active_devices.php";
		this.count = 0;
		this.collection = [];
		this.htmlElement = null;
		this.objectId = null;
                this.ActiveDeviceCollectionEvent = new CustomEvent("ActiveDeviceCollection", {
				detail: {
                                    count: 0,
                                    devices: undefined,
                                    time: new Date()
				},
				bubbles: true,
				cancelable: false
		});
                this.initialize();
	};

	ActiveDeviceCollection.prototype = {
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
            reset: function() {
                this.resetDevices(this.xmlResetScriptName, function(data) {
                    
                });
            },
            load: function() {
            var thisActiveDeviceCollection = this;
                this.downloadDevices(this.xmlLoadScriptName, function(data) {
                    var xml = data.responseXML;
                    var devices = xml.documentElement.getElementsByTagName("device");
                    for (var i = 0; i < devices.length; i++) {
                        var imei = devices[i].getAttribute("imei");
                        var collaborator_id = devices[i].getAttribute("collaborator_id");
                        var name = devices[i].getAttribute("name");
                        var model = devices[i].getAttribute("model");
                        var manufacturer = devices[i].getAttribute("manufacturer");
                        var os = devices[i].getAttribute("os");
                        var version = devices[i].getAttribute("version");
                        var location = devices[i].getElementsByTagName("location");
                        var timestamp = location[0].getAttribute("timestamp");
                        var type = location[0].getAttribute("type");
                        var status = location[0].getAttribute("status");
                        var lat = location[0].getAttribute("lat");
                        var lng = location[0].getAttribute("lng");
                        var alt = location[0].getAttribute("alt");
                        var bearing = location[0].getAttribute("bearing");
                        var speed = location[0].getAttribute("speed");
                        var address = location[0].getAttribute("address");
                        /*
                        var collaborator = devices[i].getElementsByTagName("collaborator");
                        var collaborator_id = collaborator[0].getAttribute("collaborator_id");
                        var gender_id = collaborator[0].getAttribute("gender_id");
                        var manager_id = collaborator[0].getAttribute("manager_id");
                        var address_id = collaborator[0].getAttribute("address_id");
                        var collaborator_type_id = collaborator[0].getAttribute("collaborator_type_id");
                        var lastname = collaborator[0].getAttribute("lastname");
                        var firstname = collaborator[0].getAttribute("firstname");
                        var email = collaborator[0].getAttribute("email");
                        var mobilenr = collaborator[0].getAttribute("mobilenr");
                        var cost = collaborator[0].getAttribute("cost");
                        var picture_url = collaborator[0].getAttribute("picture_url");
                        var app_admin = collaborator[0].getAttribute("app_admin");
                        var collaborator_id = collaborator[0].getAttribute("collaborator_id");
                        */
                        var item = new Device(imei, collaborator_id, name, model, manufacturer, os, version);
                        item.currentLocation = new DeviceLocation(imei, timestamp, type, status, lat, lng, alt, bearing, speed, address);
                        /*
                        item.collaborator = new DeviceCollaborator(collaborator_id, gender_id, manager_id, address_id, collaborator_type_id, lastname, firstname, email, mobilenr, cost, picture_url, app_admin);
                        */
                        thisActiveDeviceCollection.add(item);
                    }
                    thisActiveDeviceCollection.fireEvent();
                });
            },
            downloadDevices: function(url, callback) {
            console.log("Executing ActiveDeviceCollection.downloadLocations(..)...");
            var thisActiveDeviceCollection = this;
            var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;
                request.onreadystatechange = function() {
                    if (request.readyState == 4) {
                        request.onreadystatechange = thisActiveDeviceCollection.doNothing();
                        callback(request, request.status);
                    }
                };

                request.open('GET', url, true);
                request.send(null);
            },
            resetDevices: function(url, callback) {
            console.log("Executing ActiveDeviceCollection.resetActiveDevices(..)...");
            var thisActiveDeviceCollection = this;
            var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;
                request.onreadystatechange = function() {
                    if (request.readyState == 4) {
                        request.onreadystatechange = thisActiveDeviceCollection.doNothing();
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
            removeById: function(imei) {
            var result  = this.collection.filter(function(o){return o.imei == imei;} );
                result ? this.collection.splice(this.collection.indexOf(result[0]), 1) : alert('Item not found ...');
            },
            exist: function(item) {
		if($.grep(this.collection, function(e) { return e.imei == item.imei; }).length===0) {
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
            itemById: function(imei) {
            var result  = this.collection.filter(function(o){return o.imei == imei;} );
		return result ? result[0] : null; // or undefined			
            },
            count: function() {
		return this.count;
            },
            assignEvent: function(element) {
		if (element!==null && typeof element==='object') {
                    this.objectId = new Object();
                    this.objectId = element;
                    this.objectId.addEventListener('ActiveDeviceCollection', 'onActiveDeviceCollection', false);
		}
		else {
                    this.htmlElement = element;
                    document.getElementById(this.htmlElement).addEventListener("ActiveDeviceCollection", onActiveDeviceCollection, false);
		}
            },
            fireEvent: function() {
		this.ActiveDeviceCollectionEvent.detail.count = this.count;
		this.ActiveDeviceCollectionEvent.detail.devices = this.collection;
		if (this.objectId!=null){
                    this.objectId.dispatchEvent(this.ActiveDeviceCollectionEvent);
		}
		if(this.htmlElement!=null) {
                    document.getElementById(this.htmlElement).dispatchEvent(this.ActiveDeviceCollectionEvent);
		}
            },
	};
	return ActiveDeviceCollection;
	
})();

var RegisteredDeviceCollection = (function () {
	
	var RegisteredDeviceCollection = function () {
		console.log('Enter RegisteredDeviceCollection() Constructor...');
                this.xmlLoadScriptName = "registered_devicesXML.php";
                this.xmlResetScriptName = "reset_registered_devices.php";
		this.count = 0;
		this.collection = [];
		this.htmlElement = null;
		this.objectId = null;
                this.RegisteredDeviceCollectionEvent = new CustomEvent("RegisteredDeviceCollection", {
				detail: {
                                    count: 0,
                                    devices: undefined,
                                    time: new Date()
				},
				bubbles: true,
				cancelable: false
		});
                this.initialize();
	};

	RegisteredDeviceCollection.prototype = {
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
            reset: function() {
                this.resetDevices(this.xmlResetScriptName, function(data) {
                    
                });
            },
            load: function() {
            var thisRegisteredDeviceCollection = this;
                this.downloadDevices(this.xmlLoadScriptName, function(data) {
                    var xml = data.responseXML;
                    var devices = xml.documentElement.getElementsByTagName("device");
                    for (var i = 0; i < devices.length; i++) {
                        var imei = devices[i].getAttribute("imei");
                        var collaborator_id = devices[i].getAttribute("collaborator_id");
                        var name = devices[i].getAttribute("name");
                        var model = devices[i].getAttribute("model");
                        var manufacturer = devices[i].getAttribute("manufacturer");
                        var os = devices[i].getAttribute("os");
                        var version = devices[i].getAttribute("version");
                        /*
                        var location = devices[i].getElementsByTagName("location");
                        var timestamp = location[0].getAttribute("timestamp");
                        var type = location[0].getAttribute("type");
                        var status = location[0].getAttribute("status");
                        var lat = location[0].getAttribute("lat");
                        var lng = location[0].getAttribute("lng");
                        var alt = location[0].getAttribute("alt");
                        var bearing = location[0].getAttribute("bearing");
                        var speed = location[0].getAttribute("speed");
                        var address = location[0].getAttribute("address");
                        */
                        var item = new Device(imei, collaborator_id, name, model, manufacturer, os, version);
                        /*
                        item.currentLocation = new DeviceLocation(imei, timestamp, type, status, lat, lng, alt, bearing, speed, address);
                        */
                        thisRegisteredDeviceCollection.add(item);
                    }
                    thisRegisteredDeviceCollection.fireEvent();
                });
            },
            downloadDevices: function(url, callback) {
            console.log("Executing RegisteredDeviceCollection.downloadLocations(..)...");
            var thisRegisteredDeviceCollection = this;
            var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;
                request.onreadystatechange = function() {
                    if (request.readyState == 4) {
                        request.onreadystatechange = thisRegisteredDeviceCollection.doNothing();
                        callback(request, request.status);
                    }
                };

                request.open('GET', url, true);
                request.send(null);
            },
            resetDevices: function(url, callback) {
            console.log("Executing RegisteredDeviceCollection.resetActiveDevices(..)...");
            var thisRegisteredDeviceCollection = this;
            var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;
                request.onreadystatechange = function() {
                    if (request.readyState == 4) {
                        request.onreadystatechange = thisRegisteredDeviceCollection.doNothing();
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
            removeById: function(imei) {
            var result  = this.collection.filter(function(o){return o.imei == imei;} );
                result ? this.collection.splice(this.collection.indexOf(result[0]), 1) : alert('Item not found ...');
            },
            exist: function(item) {
		if($.grep(this.collection, function(e) { return e.imei == item.imei; }).length===0) {
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
            itemById: function(imei) {
            var result  = this.collection.filter(function(o){return o.imei == imei;} );
		return result ? result[0] : null; // or undefined			
            },
            count: function() {
		return this.count;
            },
            assignEvent: function(element) {
		if (element!==null && typeof element==='object') {
                    this.objectId = new Object();
                    this.objectId = element;
                    this.objectId.addEventListener('RegisteredDeviceCollection', 'onRegisteredDeviceCollection', false);
		}
		else {
                    this.htmlElement = element;
                    document.getElementById(this.htmlElement).addEventListener("RegisteredDeviceCollection", onRegisteredDeviceCollection, false);
		}
            },
            fireEvent: function() {
		this.RegisteredDeviceCollectionEvent.detail.count = this.count;
		this.RegisteredDeviceCollectionEvent.detail.devices = this.collection;
		if (this.objectId!=null){
                    this.objectId.dispatchEvent(this.RegisteredDeviceCollectionEvent);
		}
		if(this.htmlElement!=null) {
                    document.getElementById(this.htmlElement).dispatchEvent(this.RegisteredDeviceCollectionEvent);
		}
            },
	};
	return RegisteredDeviceCollection;
	
})();



/**
 *  DeviceCollection Class Helpers used to derived new Class from base Class DeviceCollection
 *
Function.prototype.subclass= function(base) {
var c= Function.prototype.subclass.nonconstructor;
    c.prototype= base.prototype;
    this.prototype= new c();
};

Function.prototype.subclass.nonconstructor= function() {};

 *
 * ActiveDeviceCollection Class derived from DeviceCollection
 *

function ActiveDeviceCollection() {
    console.log('Enter ActiveDeviceCollection() Constructor...');
    this.xmlLoadScriptName = "active_devicesXML.php";
    this.xmlResetScriptName = "reset_active_devices.php";
    this.ActiveDeviceCollectionEvent = new CustomEvent("ActiveDeviceCollection", {
                    detail: {
                        count: 0,
                        devices: undefined,
                        time: new Date()
                    },
                    bubbles: true,
                    cancelable: false
    });
    DeviceCollection.prototype.initialize.call(this);
};

ActiveDeviceCollection.subclass(DeviceCollection);

ActiveDeviceCollection.prototype = {
    load: function() {
        DeviceCollection.prototype.load.call(this);
    },
    downloadDevices: function(url, callback) {
        DeviceCollection.prototype.downloadDevices.call(this, url, callback);
    },
    assignEvent: function(element) {
        DeviceCollection.prototype.assignEvent.call(this, element);
    },
    doNothing: function() {
        DeviceCollection.prototype.doNothing.call(this);
    },
    add: function(item) {
        DeviceCollection.prototype.add.call(this, item);
    },
    remove: function(idx) {
        DeviceCollection.prototype.remove.call(this, idx);
    },
    removeById: function(imei) {
        DeviceCollection.prototype.removeById.call(this, imei);
    },
    exist: function(item) {
        DeviceCollection.prototype.exist.call(this, item);
    },
    item: function(idx) {
        DeviceCollection.prototype.item.call(this, idx);
    },
    itemById: function(imei) {
        DeviceCollection.prototype.itemById.call(this, imei);
    },
    count: function() {
        DeviceCollection.prototype.count.call(this);
    },
    assignEvent: function(element) {
        if (element!==null && typeof element==='object') {
            this.objectId = new Object();
            this.objectId = element;
            this.objectId.addEventListener('ActiveDeviceCollection', 'onActiveDeviceCollection', false);
        }
        else {
            this.htmlElement = element;
            document.getElementById(this.htmlElement).addEventListener("ActiveDeviceCollection", onActiveDeviceCollection, false);
        }
    },
    fireEvent: function() {
        this.ActiveDeviceCollectionEvent.detail.count = this.count;
        this.ActiveDeviceCollectionEvent.detail.devices = this.collection;
        if (this.objectId!=null){
            this.objectId.dispatchEvent(this.ActiveDeviceCollectionEvent);
        }
        if(this.htmlElement!=null) {
            document.getElementById(this.htmlElement).dispatchEvent(this.ActiveDeviceCollectionEvent);
        }
    }
};

*/