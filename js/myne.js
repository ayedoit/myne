jQuery.fn.myne_api = function(options) {	
	options["jsonrpc"] = "2.0";
	options["id"] = "1";
	
	var response = $.ajax({
		url: "/api/request",
		type: "post",
		data: options,
		dataType: "json",
		async: false,
		success: function(data) {
			return data;
		} 
	});
	
	return response;
	
};
$(document).ready(function() {
	$('.toggle_on').click(function() {
		$(this).myne_api({
		  method: "toggle",
		  params: {"model": "devices/device", "opts":{"type":$(this).data('type'),"name":$(this).data('name'),"status":"on"}}
		});
	});
	
	$('.toggle_off').click(function() {
		$(this).myne_api({
		  method: "toggle",
		  params: {"model": "devices/device", "opts":{"type":$(this).data('type'),"name":$(this).data('name'),"status":"off"}}
		});
	});
	
	//~ // Device Edit
	//~ $('.device_data tr').hover(
		//~ function() {
			//~ $(this).find('.edit_device').toggleClass('hide');
		//~ }
	//~ );
	
	$('.editable').editable();
});


