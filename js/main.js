function alertMessage(message, options=null) {
	
	var div = $('<div></div>').attr('id', 'messageDialog');
	div.appendTo('body');

	var settings = $.extend({
        cancel  : null,
        ok	: null,
    }, options);
	
	var messageDialog = $("#messageDialog").kendoWindow({

        title: false,
        visible: false,
        animation: false,
        modal: true,
        width: 400,
        height: 110,
        resizable: false,
        draggable: true,
        close: function() { div.remove(); },
    
	}).data("kendoWindow");
	
	messageDialog.content('<p align="center">'+message+'</p><hr/><div align="center"><button class="k-button" id="messageDialogCancel">ຍົກເລີກ</button> <button class="k-button k-primary" id="messageDialogOk">ຕົກລົງ</button> </div>');
	
	$("#messageDialogCancel").click(function(e){
		e.preventDefault(); 
		messageDialog.close();
		if ( $.isFunction( settings.cancel ) ) {
			settings.cancel.call( this );
		} 
		
		return false;
	});
	
	$("#messageDialogOk").click(function(e){
		e.preventDefault(); 
		messageDialog.close();
		if ( $.isFunction( settings.ok ) ) {
			settings.ok.call( this );
		}
		
		return true;
	});
	

	$("#messageDialog").bind("keypress", function (e) {
	    if (e.keyCode == 13) {
	    	$("#messageDialogOk").click();
	    }
	});
	
	messageDialog.center().open();
}