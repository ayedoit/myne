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
		},
		fail: function(data) { 
			alert(data); 
		} 
	});
	
	return response;
	
};
jQuery.fn.myne_notify = function(options) {
	$('#myne_notify').removeClass('notify-info').addClass('notify-'+options.class).clearQueue().stop(true,false).text(options.text).fadeIn('fast', 'linear', function() {
		$(this).delay(2500).fadeOut('400');
	});
};
