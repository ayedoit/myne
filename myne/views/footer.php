  </body>
</html>
<script>
$(document).ready(function() {
	$('.toggle_on').click(function() {
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
				"class":"info"
			});
		}
	});
	
	$('.toggle_off').click(function() {
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
				"class":"info"
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
});
</script>