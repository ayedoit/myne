  </body>
</html>
<script>
$(document).ready(function() {
	$('.toggle_on').click(function() {
		$(this).myne_api({
		  method: "toggle",
		  params: {"model": "devices/device", "api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "opts":{"type":$(this).data('type'),"name":$(this).data('name'),"status":"on"}}
		});
	});
	
	$('.toggle_off').click(function() {
		$(this).myne_api({
		  method: "toggle",
		  params: {"model": "devices/device", "api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "opts":{"type":$(this).data('type'),"name":$(this).data('name'),"status":"off"}}
		});
	});	
	$('.editable').editable();
});
</script>