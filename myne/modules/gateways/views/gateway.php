<div class="row-fluid">
	<div class="span4">
		<h3>Gatewayinformationen</h3>
		<table class="table table-striped">
			<?php
			// Get Name
			if (isset($gateway->clear_name) && trim($gateway->clear_name) != '') {
				?>
				<tr>
					<td><b>Name</b></td>
					<td><a class="editable" id="<?= $gateway->name ?>-clear_name" data-type="text" data-pk="clear_name" data-url="<?php echo base_url(); ?>gateways/update/<?= $gateway->name ?>" data-original-title="Name"><?= $gateway->clear_name ?></a></td>
				</tr>
		    <?php
			}
			?>
			<tr>
				<?php
				// Get Type-Data
				$this->load->model('gateway');
				$type = $this->gateway->getGatewayTypeByID($gateway->type);
				?>
				<td><b>Typ</b></td>
				<td><a class="editable-select" id="<?= $gateway->name ?>-type" data-type="select" data-curr="<?= $type->id ?>" data-pk="type" data-url="<?php echo base_url(); ?>gateways/update/<?= $gateway->name ?>" data-original-title="Typ"><?= $type->clear_name ?></a>
			</tr>
			<?php
			// Get Room
			if (isset($gateway->room) && trim($gateway->room) != '' && $gateway->room != "9999") {
				if ($gateway->room == 0) {
				?>
					<tr>
						<td><b>Raum</b></td>
						<td><a class="editable-select" id="<?= $gateway->name ?>-room" data-type="select" data-curr="0" data-pk="room" data-url="<?php echo base_url(); ?>gateways/update/<?= $gateway->name ?>" data-original-title="Raum">Raum wählen</a></td>
					</tr>
				<?php
				}
				else {
				?>
					<tr>
						<td><b>Raum</b></td>
						<?php
							$this->load->model('room');
							$room = $this->room->getRoomByID($gateway->room);
						?>
						<td><a class="editable-select" id="<?= $gateway->name ?>-room" data-type="select" data-curr="<?= $room->id ?>" data-pk="room" data-url="<?php echo base_url(); ?>gateways/update/<?= $gateway->name ?>" data-original-title="Raum"><?= $room->clear_name ?></a> <a href="<?= base_url('rooms/show/'.$room->name) ?>"><i class="icon-share-alt"></i></a></td>
					</tr>
				<?php
				}
			}
			?>
		    <script>
				$(function(){
					$('#<?= $gateway->name ?>-room').editable({
						value: $(this).data('curr'),
						source: function() {
							var gateways = $(this).myne_api({
							  method: "getRooms",
							  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "room", "opts":[""]}
							});
							response = jQuery.parseJSON(gateways.responseText);
							
							var data = [];
							$.each(response.result, function (key,value) {
								var values = {};
								values['value'] = value.id;
								values['text'] = value.clear_name;
								
								data.push(values);
							});
							
							return data;
						},
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
		    		    
			<?php
			//~ // Get Group
			//~ if (isset($device->group) && trim($device->group) != '' && $device->group != 0) {
				//~ $group = $this->device->getGroupByID($device->group);
				//~ ?>
<!--
				<tr>
					<td><b>Gruppe</b></td>
					<td><a href="<?= base_url('devices/groups/'.$group->name) ?>" title="<?= $group->clear_name ?>"><?= $group->clear_name ?></a></td>
				</tr>
-->
		    <?php
			//~ }
			//~ ?>
		    
			<?php
			// Get Description
			if (isset($gateway->description) && trim($gateway->description) != '') {
				?>
				<tr>
					<td><b>Beschreibung</b></td>
					<td><a class="editable" id="<?= $gateway->name ?>-description" data-type="text" data-pk="description" data-url="<?php echo base_url(); ?>gateways/update/<?= $gateway->name ?>" data-original-title="Beschreibung"><?= $gateway->description ?></a></td>
				</tr>
		    <?php
			}
			?>

			<?php
			// Get Address
			if (isset($gateway->address) && trim($gateway->address) != '') {
				?>
				<tr>
					<td><b>Adresse</b></td>
					<td><a class="editable" id="<?= $gateway->name ?>-address" data-type="text" data-pk="address" data-url="<?php echo base_url(); ?>gateways/update/<?= $gateway->name ?>" data-original-title="Adresse"><?= $gateway->address ?></a></td>
				</tr>
		    <?php
			}
			?>
			
			<?php
			// Get Port
			if (isset($gateway->port) && trim($gateway->port) != '') {
				?>
				<tr>
					<td><b>Port</b></td>
					<td><a class="editable" id="<?= $gateway->name ?>-port" data-type="text" data-pk="port" data-url="<?php echo base_url(); ?>gateways/update/<?= $gateway->name ?>" data-original-title="Port"><?= $gateway->port ?></a></td>
				</tr>
		    <?php
			}
			?>
		</table>
	</div>
	
	<div class="span6">
		<?php
			$this->load->view('devices/devices_by_gateway',array('gateway' => $gateway));
		?>
	</div>
</div>

<div class="row-fluid">
	<?php
		$this->load->view('tasks/tasks',array('target_type' => 'gateway', 'target' => $gateway));	
	?>
</div>

<div class="row-fluid">
	<?php
	echo "<ul class='inline'>";
		echo "<li><a class='btn btn-danger' href='".base_url('gateways/delete/'.$gateway->name.'/confirm')."' title='Löschen'><i class='icon-remove-circle icon-white'></i> Löschen</a></li>";
		echo "<li><a class='btn btn-primary' href='".base_url('tasks/add/new/gateway/'.$gateway->name)."' title='Neuer Task'><i class='icon-plus icon-white'></i> Task</a></li>";
	echo "</ul>";
	?>
</div>
<script>
	$(function(){
		$('#<?= $gateway->name ?>-room').editable({
			value: $(this).data('curr'),
			source: function() {
				var gateways = $(this).myne_api({
				  method: "getRooms",
				  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "room", "opts":[""]}
				});
				response = jQuery.parseJSON(gateways.responseText);
				
				var data = [];
				$.each(response.result, function (key,value) {
					var values = {};
					values['value'] = value.id;
					values['text'] = value.clear_name;
					
					data.push(values);
				});
				
				return data;
			}
		});
	});

	$(function(){
		$('#<?= $gateway->name ?>-type').editable({
			value: $(this).data('curr'),
			source: function() {
				var gateways = $(this).myne_api({
				  method: "getGatewayTypes",
				  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "gateways/gateway", "opts":[""]}
				});
				response = jQuery.parseJSON(gateways.responseText);
				
				var data = [];
				$.each(response.result, function (key,value) {
					var values = {};
					values['value'] = value.id;
					values['text'] = value.clear_name;
					
					data.push(values);
				});
				
				return data;
			}
		});
	});
</script>
