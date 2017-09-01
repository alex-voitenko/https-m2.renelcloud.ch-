/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var CenterControl = (function () {
    var CenterControl = function (document, map, center) {
        console.log('Enter CenterControl() Constructor...');
        this.document = document || null;
        this.map = map || null;
        this.center = center || null;
        this.controlDIV = null;
        this.controlUI = null;
        this.controlText = null;
        this.htmlElement = null;
        this.objectId = null;
        this.centerControlEvent = new CustomEvent("CenterControl", {
            detail: {
                    center: null,
                    time: new Date()
            },
            bubbles: true,
            cancelable: false
        });
        this.initialize();
        console.log('Exit CenterControl() Constructor...');
    };
    
    CenterControl.prototype = {
        initialize: function() {
//	console.log('Enter CenterControl.initialize() ...');
            if(this.document!=null){
                // Set <DIV> to hold the Control
                this.controlDIV = this.document.createElement("div");
                this.controlDIV.setAttribute("id", "centerControlDIV");
                this.controlDIV.setAttribute("class", "ControlDIV");
                
                // Set CSS for the control border.
                this.controlUI = this.document.createElement("div");
                this.controlUI.setAttribute("id", "centerControlUI");
                this.controlUI.setAttribute("class", "ControlUI");
                this.controlUI.title = 'Click to CENTER the map';
                this.controlDIV.appendChild(this.controlUI);
                
                // Set CSS for the control interior.
                this.controlText = this.document.createElement('div');
                this.controlText.setAttribute("id", "centerControlText");
                this.controlText.setAttribute("class", "ControlTXT");
                this.controlText.innerHTML = 'Centrer la carte';
                this.controlUI.appendChild(this.controlText);

                if(this.map!=null) {
                var thisCenterControl = this;
                    // Setup the click Event listener
                    this.controlUI.addEventListener('click', function() {
                        // We simply redirect Event to RenelMapFull Object 
                        // which is responsible for managing the map.
                        console.log("CenterControl Button Clicked");
                        thisCenterControl.fireEvent();
                    });
                    this.map.addControl(this);
                }
                else {
                    console.log("CenterControl.initialize - Invalid or undefined RenelMap parameter")
                }
            }
            else {
                console.log('CenterControl.initialize - Invalid or undefined document parameter')
            }
        },
        setCenter: function(center) {
            this.center = center;
        },
        addEventListener: function(name, handler, capture) {
	console.log('Enter CenterControl.addEventListener() ...');
            if (!this.events) this.events = {};
            if (!this.events[name]) this.events[name] = [];
            this.events[name].push(handler);
        },
	removeEventListener: function(name, handler) {
	console.log('Enter CenterControl.removeEventListener() ...');
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
	console.log('Executing CenterControl.dispatchEvent(...)');
	var name = event.type;
            for (var i= 0; i<this.events[name].length; i++) {
	        this[this.events[name][i]](event);
	    }
	    return !event.defaultPrevented;		
	},
	assignEvent: function(element) {
//	console.log('Enter CenterControl.AssignEvent');
            if (element!==null && typeof element==='object') {
//		console.log('It is an Object');
                this.objectId = new Object();
                this.objectId = element;
		this.objectId.addEventListener('CenterControl', 'onCenterControl', false);
            }
            else {
//		console.log('It is an HTML Element');
		this.htmlElement = element;
		document.getElementById(this.htmlElement).addEventListener("CenterControl", onCenterControl, false);
            }
	},
	fireEvent: function() {
//	console.log('CenterControl.FireEvent');
            this.centerControlEvent.detail.center = this.center;
            if (this.objectId!=null){
//		console.log('CenterControl Event fired to an Object');
		this.objectId.dispatchEvent(this.centerControlEvent);
            }
            if(this.htmlElement!=null) {
//		console.log('Event fired to an HTML Element');
		document.getElementById(this.htmlElement).dispatchEvent(this.centerControlEvent);
            }
	}
    };
    return CenterControl;
})();

var ResetControl = (function () {
    var ResetControl = function (document, map) {
        console.log('Enter ResetControl() Constructor...');
        this.document = document || null;
        this.map = map || null;
        this.controlDIV = null;
        this.controlUI = null;
        this.controlText = null;
        this.htmlElement = null;
        this.objectId = null;
        this.resetControlEvent = new CustomEvent("ResetControl", {
            detail: {
                    action: 'RESET',
                    time: new Date()
            },
            bubbles: true,
            cancelable: false
        });
        this.initialize();
        console.log('Exit ResetControl() Constructor...');
    };
    
    ResetControl.prototype = {
        initialize: function() {
//	console.log('Enter ResetControl.initialize() ...');
            if(this.document!=null){
                // Set <DIV> to hold the Control
                this.controlDIV = this.document.createElement("div");
                this.controlDIV.setAttribute("id", "resetControlDIV");
                this.controlDIV.setAttribute("class", "ControlDIV");
                
                // Set CSS for the control border.
                this.controlUI = this.document.createElement("div");
                this.controlUI.setAttribute("id", "resetControlUI");
                this.controlUI.setAttribute("class", "ControlUI");
                this.controlUI.title = 'Click to RESET the map';
                this.controlDIV.appendChild(this.controlUI);
                
                // Set CSS for the control interior.
                this.controlText = this.document.createElement('div');
                this.controlText.setAttribute("id", "resetControlText");
                this.controlText.setAttribute("class", "ControlTXT");
                this.controlText.innerHTML = 'Reset Map';
                this.controlUI.appendChild(this.controlText);

                if(this.map!=null) {
                var thisResetControl = this;
                    // Setup the click Event listener
                    this.controlUI.addEventListener('click', function() {
                        // We simply redirect Event to RenelMapFull Object 
                        // which is responsible for managing the map.
                        console.log("ResetControl Button Clicked");
                        thisResetControl.fireEvent();
                    });
                    this.map.addControl(this);
                }
                else {
                    console.log("ResetControl.initialize - Invalid or undefined RenelMap parameter")
                }
            }
            else {
                console.log('ResetControl.initialize - Invalid or undefined document parameter')
            }
        },
        addEventListener: function(name, handler, capture) {
	console.log('Enter ResetControl.addEventListener() ...');
            if (!this.events) this.events = {};
            if (!this.events[name]) this.events[name] = [];
            this.events[name].push(handler);
        },
	removeEventListener: function(name, handler) {
	console.log('Enter ResetControl.removeEventListener() ...');
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
	console.log('Executing ResetControl.dispatchEvent(...)');
	var name = event.type;
            for (var i= 0; i<this.events[name].length; i++) {
	        this[this.events[name][i]](event);
	    }
	    return !event.defaultPrevented;		
	},
	assignEvent: function(element) {
//	console.log('Enter ResetControl.AssignEvent');
            if (element!==null && typeof element==='object') {
//		console.log('It is an Object');
                this.objectId = new Object();
                this.objectId = element;
		this.objectId.addEventListener('ResetControl', 'onResetControl', false);
            }
            else {
//		console.log('It is an HTML Element');
		this.htmlElement = element;
		document.getElementById(this.htmlElement).addEventListener("ResetControl", onResetControl, false);
            }
	},
	fireEvent: function() {
//	console.log('ResetControl.FireEvent');
            if (this.objectId!=null){
//		console.log('ResetControl Event fired to an Object');
		this.objectId.dispatchEvent(this.resetControlEvent);
            }
            if(this.htmlElement!=null) {
//		console.log('Event fired to an HTML Element');
		document.getElementById(this.htmlElement).dispatchEvent(this.resetControlEvent);
            }
	}
    };
    return ResetControl;
})();

