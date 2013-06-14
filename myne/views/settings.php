<div class="row-fluid">
	<div class="span4">
		<table class="table device_data">
			<tr>
				<td><b>Login</b></td>
				<td>
				  <a class="editable-select" id="settings-login" data-type="select" data-pk="login" data-url="<?php echo base_url(); ?>settings/update" data-original-title="Login">
				  		<?php 
				  			$login = $this->tools->getSettingByName('login');
				  			if ($login == "true") {
				  				echo "Aktiv";
				  			}
				  			else {
				  				echo "Inaktiv";
				  			}
				  		?>
				  </a>
				</td>
			</tr>

			<tr>
				<td><b>API</b></td>
				<td>
				  <a class="editable-select" id="settings-api" data-type="select" data-pk="api" data-url="<?php echo base_url(); ?>settings/update" data-original-title="API">
				  		<?php 
				  			$api = $this->tools->getSettingByName('api');
				  			if ($api == "true") {
				  				echo "Aktiv";
				  			}
				  			else {
				  				echo "Inaktiv";
				  			}
				  		?>
				  </a>
				</td>
			</tr>

			<tr>
				<td><b>API Key</b></td>
				<td>
				  	<a class="editable" id="settings-api_key" data-type="text" data-pk="api_key" data-url="<?php echo base_url(); ?>settings/update" data-original-title="API Key"><?= $this->tools->getSettingByName('api_key'); ?></a>
				</td>
			</tr>

			<tr>
				<td><b>Cronjob</b></td>
				<td>
				  <?php
				  if ($this->tools->cronIsSet()) {
				  	echo "<btn class='btn btn-success btn-medium disabled'>Cron aktiv</btn>";
				  }
				  else {
				  	echo "<btn class='btn btn-primary btn-medium enable_cron'>Cron aktivieren</btn>";
				  }
				  ?>
				</td>
			</tr>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(function(){
			$('#settings-login').editable({
				source: [
					{value: "true", text: "Aktiv"}, 
					{value: "false", text: "Inaktiv"}
				],
				success: function(response, newValue) {
				    $(this).myne_notify({
						"text":"Einstellungen gespeichert",
						"class":"success"
					});
				}
			});
		});

		$(function(){
			$('#settings-api').editable({
				source: [
					{value: "true", text: "Aktiv"}, 
					{value: "false", text: "Inaktiv"}
				],
				success: function(response, newValue) {
				    $(this).myne_notify({
						"text":"Einstellungen gespeichert",
						"class":"success"
					});
				}
			});
		});
	});
</script>