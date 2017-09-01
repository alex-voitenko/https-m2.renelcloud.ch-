var Device = (function () {
	var Device = function (imei, collaborator_id, name, model, manufacturer, os, version) {
//		alert('Enter Device() Constructor...');
		this.imei = imei || null;
                this.collaborator_id = collaborator_id || null;
		this.name = name || '';
		this.model = model || '';
		this.manufacturer = manufacturer || '';
		this.os = os || '';
		this.version = version || '';
                this.currentLocation = null;
                this.collaborator = null;
		this.htmlElement = null;
		this.objectId = null;
                this.DeviceEvent = new CustomEvent("Device", {
				detail: {
					imei: 0,
                                        collaborator_id: null,
					name: '',
					model: '',
                                        manufacturer: '',
                                        os: '',
                                        version: '',
					time: new Date()
				},
				bubbles: true,
				cancelable: false
                });
//		alert('Exit Device Constructor...');
	};

	Device.prototype = {
		show: function() {
                    alert('Device Data:\n' +
                            'IMEI:            ' + this.imei + '\n' +	
                            'Collaborator Id: ' + (this.collaborator_id!=null) ? this.collaborator_id : 'Undefined' + '\n' + 
                            'Name:            ' + this.name + '\n' +	
                            'Model:           ' + this.model + '\n' +	
                            'Manufacturer:    ' + this.manufacturer + '\n' +	
                            'OS:              ' + this.os + '\n' +	
                            'OS Version:      ' + this.version + '\n');
		},
		addEventListener: function(name, handler, capture) {
//		alert('Enter Gender.addEventListener() ...');
			if (!this.events) this.events = {};
			if (!this.events[name]) this.events[name] = [];
			this.events[name].push(handler);
//			alert(JSON.stringify(this.events));
		},
		removeEventListener: function(name, handler) {
//		alert('Enter Gender.removeEventListener() ...');
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
//		    alert(JSON.stringify(this.events));
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
//		alert('Gender.AssignEvent');
		var thisGender = this;
			if (element!==null && typeof element==='object') {
//				alert('It is an Object');
				thisGender.objectId = new Object();
				thisGender.objectId = element;
				thisGender.objectId.addEventListener('Gender', 'onGender', false);
			}
			else {
//				alert('It is an HTML Element');
				thisGender.htmlElement = element;
				document.getElementById(thisGender.htmlElement).addEventListener("Gender", onGender, false);
			}
		},
		fireEvent: function() {
//		alert('Gender.FireEvent');
		var thisGender = this;
			if (thisGender.objectId!=null){
//				alert('Event fired to an Object');
				thisGender.objectId.dispatchEvent(thisGender.GenderEvent);
			}
			if(thisGender.htmlElement!=null) {
//				alert('Event fired to an HTML Element');
				document.getElementById(thisGender.htmlElement).dispatchEvent(thisGender.GenderEvent);
			}
		}
	};
	return Device;
})();

