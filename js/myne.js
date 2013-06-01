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

