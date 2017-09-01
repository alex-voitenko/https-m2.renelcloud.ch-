var historyPanelOpened = false;
   
function setHistoryDeviceList(registeredDevices, selectedDevice) {
    $('#registered_devices').empty();
    for(var idx=0; idx<registeredDevices.count; idx++) {
        
          $('#registered_devices').append( $('<option class="history"></option>').val(registeredDevices.item(idx).imei).html(registeredDevices.item(idx).name));
    }
    if((selectedDevice!=null) && (selectedDevice>=0)) {
        document.getElementById('registered_devices').selectedIndex = selectedDevice;
    }
}


function showHistoryPanel() {
//function showPanel() {
    $( ".panelHistory" ).animate({
          left: "0px"
	}, 700, function() {
            // Animation complete.
    });
    $(this).html('&laquo;').removeClass('show').addClass('hide');
    historyPanelOpened = true;  
}

function hideHistoryPanel() {	
    $( ".panelHistory" ).animate({
            left: "-=500px"
        }, 700, function() {
        // Animation complete.
    });
    $(this).html('&raquo;').removeClass('hide').addClass('show');
    historyPanelOpened = false;
}

function slideHistoryPanel() {
    if(historyPanelOpened==false) {
        showHistoryPanel();
    }
    else {
        hideHistoryPanel();
    }
}