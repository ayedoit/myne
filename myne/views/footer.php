  </body>
</html>
<script>
$(document).ready(function() {
	$(document).on('click', '.toggle_on', function() {
	    var response = $(this).myne_api({
		  method: "toggle",
		  params: {"model": "devices/device", "api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "opts":{"type":$(this).data('type'),"name":$(this).data('name'),"status":"on"}}
		});

		var r_value = jQuery.parseJSON(response.responseText);

		if (r_value.hasOwnProperty('error')) {
			$(this).myne_notify({
				"text":r_value.error.message,
				"class":"error"
			});
		}
		else {
			$(this).myne_notify({
				"text":$(this).data('name')+" angeschaltet",
				"class":"success"
			});
		}
	});
	$(document).on('click', '.toggle_off', function() {
		var response = $(this).myne_api({
		  method: "toggle",
		  params: {"model": "devices/device", "api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "opts":{"type":$(this).data('type'),"name":$(this).data('name'),"status":"off"}}
		});

		var r_value = jQuery.parseJSON(response.responseText);

		if (r_value.hasOwnProperty('error')) {
			$(this).myne_notify({
				"text":r_value.error.message,
				"class":"error"
			});
		}
		else {
			$(this).myne_notify({
				"text":$(this).data('name')+" ausgeschaltet",
				"class":"success"
			});
		}
	});

	var type = "";
    var name = "";


    $(".set_status").on('taphold', {"duration":500},function() {
    	var type = $(this).data('type');
    	var name = $(this).data('name');

	    var response = $(this).myne_api({
		  method: "set_status",
		  params: {"model": "devices/device", "api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "opts":{"type":type,"name":name,"status":"off"}}
		});

		var r_value = jQuery.parseJSON(response.responseText);

		if (r_value.hasOwnProperty('error')) {
			$(this).myne_notify({
				"text":r_value.error.message,
				"class":"error"
			});
		}
		else {
			$(this).myne_notify({
				"text":$(this).data('name')+" ausgeschaltet",
				"class":"success"
			});
		}
	}).on('click', function (data) {
	    var response = $(this).myne_api({
		  method: "set_status",
		  params: {"model": "devices/device", "api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "opts":{"type":data.data('type'),"name":data.data('name'),"status":"on"}}
		});

		var r_value = jQuery.parseJSON(response.responseText);

		if (r_value.hasOwnProperty('error')) {
			$(this).myne_notify({
				"text":r_value.error.message,
				"class":"error"
			});
		}
		else {
			$(this).myne_notify({
				"text":data.data('name')+" angeschaltet",
				"class":"success"
			});
		}
	});

	$(document).on('click', '.dim_incr', function() {
	    var response = $(this).myne_api({
		  method: "dim",
		  params: {"model": "devices/device", "api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "opts":{"type":$(this).data('type'),"name":$(this).data('name'),"status":"incr"}}
		});

		var r_value = jQuery.parseJSON(response.responseText);

		if (r_value.hasOwnProperty('error')) {
			$(this).myne_notify({
				"text":r_value.error.message,
				"class":"error"
			});
		}
		else {
			$(this).myne_notify({
				"text":$(this).data('name')+" gedimmt",
				"class":"success"
			});
		}
	});

	$(document).on('click', '.dim_decr', function() {
	    var response = $(this).myne_api({
		  method: "dim",
		  params: {"model": "devices/device", "api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "opts":{"type":$(this).data('type'),"name":$(this).data('name'),"status":"decr"}}
		});

		var r_value = jQuery.parseJSON(response.responseText);

		if (r_value.hasOwnProperty('error')) {
			$(this).myne_notify({
				"text":r_value.error.message,
				"class":"error"
			});
		}
		else {
			$(this).myne_notify({
				"text":$(this).data('name')+" gedimmt",
				"class":"success"
			});
		}
	});

	$('.editable').editable({
	    mode: 'popup',
	    success: function(response, newValue) {
		    $(this).myne_notify({
				"text":"Einstellungen gespeichert",
				"class":"success"
			});
		},
		error: function(response, newValue) {
		    $(this).myne_notify({
				"text":"Einstellungen nicht gespeichert",
				"class":"error"
			});
		}
	});
	$("#time").simpleClock();
});
</script>