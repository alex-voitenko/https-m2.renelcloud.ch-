/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var RenelMapMarkers = (function () {
        
	var RenelMapMarkers = function() {
        this.customIcons = {
            OFF: {icon: 'images/pin_inactive.png'},
            ON: {icon: 'images/pin_active.png'},
            INVISIBLE: {icon: 'images/pin_invisible.png'}
        };
        
        
        
           console.log("Executing RenelMapMarkers() Constructor...");
	};
	
	RenelMapMarkers.prototype = {
            initialize: function() {
                console.log("Executing RenelMapMarkers.initialize()...");
            }
	};		
	return RenelMapMarkers;
})();



