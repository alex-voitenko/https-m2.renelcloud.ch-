/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var panelDevicesOpened = false;


function slideTrackingPanel() {
    if(panelDevicesOpened==false) {
            showDevicesList();
    }
    else {
            hideDevicesList();
    }
}

function showDevicesList() {
    $( ".panelDevices" ).animate({
        top: "+=510px"
        }, 700, function() {
        // Animation complete.
    });
    $(this).html('&laquo;').removeClass('show').addClass('hide');
    panelDevicesOpened = true;  
}

function hideDevicesList() {	
    $( ".panelDevices" ).animate({
        top: "-=510px"
        }, 700, function() {
        // Animation complete.
    });
    $(this).html('&raquo;').removeClass('hide').addClass('show');
    panelDevicesOpened = false;
}

function setTrackingDevicesList(activeDevices, selectedDevice) {
var list = $('#list-list1'); //lookup <ul>
//lookup number of listItems from home screen; convert to number
var itemCnt = 15;
var description = '';

    //remove current list items
    list.empty();
    //build list 
    for (var idx=0; idx < activeDevices.count; idx++) {
        if(((selectedDevice!=null) && (selectedDevice>=0)) && (selectedDevice==idx)) {
            list.append('<li id="' + activeDevices.item(idx).imei + '" class="panelDevices-list-listItem" style="color: #333;" onclick="setActiveDevice(' + activeDevices.item(idx).imei + ')">' +
                        '<div id="list-listItemImg' + idx + '" class="panelDevices-list-listItemImg">' +
                        '	<img style="margin:5px 10px 10px;" src="images/pin_active1.png" /> ' +
                        '</div>' +
                        '<div id="list-listItem' + idx + '-inner-div" class="panelDevices-list-listItem-inner-div">' +
                        '	<div id="list-listItem' + idx + '-inner-div-name" class="panelDevices-list-listItem-inner-div-name">' + activeDevices.item(idx).name + '</div>' +
                        '	<div id="list-listItem' + idx + '-inner-div-imei" class="panelDevices-list-listItem-inner-div-imei">IMEI: ' + activeDevices.item(idx).imei + '</div>' + 
                        '</div>' + 
                        '</li>');
            }
            else {
            list.append('<li id="' + activeDevices.item(idx).imei + '" class="panelDevices-list-listItem" style="background-color: transparent;" onclick="setActiveDevice(' + activeDevices.item(idx).imei + ')">' +
                        '<div id="list-listItemImg' + idx + '" class="panelDevices-list-listItemImg">' +
                        '	<img style="margin:5px 10px 10px;" src="images/pin_inactive.png" />' +
                        '</div>' +
                        '<div id="list-listItem' + idx + '-inner-div" class="panelDevices-list-listItem-inner-div">' +
                        '	<div id="list-listItem' + idx + '-inner-div-name" class="panelDevices-list-listItem-inner-div-name">' + activeDevices.item(idx).name + '</div>' +
                        '	<div id="list-listItem' + idx + '-inner-div-imei" class="panelDevices-list-listItem-inner-div-imei">IMEI: ' + activeDevices.item(idx).imei + '</div>' + 
                        '</div>' + 
                        '</li>');
            }
    }
}

/*
function setActiveDevice(imei) {
    alert("Active Device: " + imei);
}
*/
