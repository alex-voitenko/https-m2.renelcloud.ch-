var DeviceCollaborator = (function () {
	var DeviceCollaborator = function (collaborator_id, gender_id, manager_id, address_id, collaborator_type_id, lastname, firstname, email, mobilenr, cost, picture_url, app_admin) {
//		alert('Enter DeviceCollaborator() Constructor...');
                this.collaborator_id = collaborator_id || -1;
                this.gender_id = gender_id || -1;
                this.manager_id = manager_id || -1;
                this.address_id = address_id || -1;
                this.collaborator_type_id = collaborator_type_id || -1; 
                this.lastname = lastname || null;
                this.firstname = firstname || null;
                this.email = email || null;
                this.mobilenr = mobilenr || null;
                this.cost = cost || 0.00;
                this.picture_url = picture_url || null;
                this.app_admin = app_admin || 0;
		this.htmlElement = null;
		this.objectId = null;
                this.DeviceCollaboratorEvent = new CustomEvent("DeviceCollaborator", {
				detail: {
                                    collaborator_id: -1,
                                    gender_id: -1,
                                    manager_id: -1,
                                    address_id: -1,
                                    collaborator_type_id: -1,
                                    lastname: null,
                                    firstname: null,
                                    email: null,
                                    mobilenr: null,
                                    cost: 0.00,
                                    picture_url: null,
                                    app_admin: 0,
                                    time: new Date()
				},
				bubbles: true,
				cancelable: false
                });
//		alert('Exit DeviceCollaborator Constructor...');
	};

	DeviceCollaborator.prototype = {
            show: function() {
                alert('Device Collaborator Data:\n' +
                      'COLLABORATOR ID:      ' + this.collaborator_id + '\n' +
                      'GENDER ID:            ' + this.gender_id + '\n' +
                      'MANAGER ID:           ' + this.manager_id + '\n' + 
                      'ADDRESS ID:           ' + this.address_id + '\n' +
                      'COLLABORATOR TYPE ID: ' + this.collaborator_type_id + '\n' +
                      'LAST NAME:            ' + this.lastname + '\n' +
                      'FIRST NAME:           ' + this.firstname + '\n' +
                      'EMAIL:                ' + this.email + '\n' + 
                      'MOBILE NR.:           ' + this.mobilenr + '\n' +
                      'COST/HOUR:            ' + this.cost + '\n' +
                      'PICTURE URL:          ' + this.picture_url + '\n' + 
                      'IS ADMIN:             ' + this.app_admin + '\n');
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
//		alert('Executing DeviceCollaborator.dispatchEvent(' + JSON.stringify(event) + ') ...');
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
                    this.objectId.addEventListener('DeviceCollaborator', 'onDeviceCollaborator', false);
                }
                else {
                    this.htmlElement = element;
                    document.getElementById(this.htmlElement).addEventListener("DeviceCollaborator", onDeviceCollaborator, false);
                }
            },
            fireEvent: function() {
                if (this.objectId!=null){
                    this.objectId.dispatchEvent(this.DeviceCollaboratorEvent);
                }
            	if(this.htmlElement!=null) {
                    document.getElementById(this.htmlElement).dispatchEvent(this.DeviceCollaboratorEvent);
		}
            }
	};
	return DeviceCollaborator;
})();

