<div class="row-fluid">
	<div class="span4">
		<h3>Geräteinformationen</h3>
		<table class="table table-striped device_data">
			<?php
			// Get Name
			if (isset($device->clear_name) && trim($device->clear_name) != '') {
				?>
				<tr>
					<td><b>Name</b></td>
					<td><a class="editable" id="<?= $device->name ?>-clear_name" data-type="text" data-pk="clear_name" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Name"><?= $device->clear_name ?></a></td>
				</tr>
		    <?php
			}
			?>
			<tr>
				<?php
				// Get description
				?>
				<td><b>Beschreibung</b></td>
				<td><a class="editable" id="<?= $device->name ?>-description" data-type="text" data-pk="description" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Beschreibung"><?= $device->description ?></a></td>
			</tr>
			<tr>
				<?php
				// Get Type-Data
				$this->load->model('device');
				$type = $this->device->getTypeByID($device->type);
				?>
				<td><b>Typ</b></td>
				<td><a class="editable-select" id="<?= $device->name ?>-type" data-type="select" data-curr="<?= $type->id ?>" data-pk="type" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Typ"><?= $type->clear_name ?></a></td>
			
				<script>
					$(function(){
						$('#<?= $device->name ?>-type').editable({
							value: $(this).data('curr'),
							source: function() {
								var gateways = $(this).myne_api({
								  method: "getDeviceTypes",
								  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "devices/device", "opts":[""]}
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
			</tr>
		
		    <tr>
				<?php
				// Get Vendor-Data
				$this->load->model('devices/vendor');
				$vendor = $this->vendor->getVendorByID($device->vendor);
				?>
				<td><b>Hersteller</b></td>
				<td><a class="editable-select" id="<?= $device->name ?>-vendor" data-type="select" data-curr="<?= $vendor->id ?>" data-pk="vendor" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Hersteller"><?= $vendor->clear_name ?></a></td>
		    
				<script>
					$(function(){
						var type = $('#<?= $device->name ?>-type').data('curr');
						$('#<?= $device->name ?>-vendor').editable({
							value: $(this).data('curr'),
							source: function() {
								var gateways = $(this).myne_api({
								  method: "getVendorsByType",
								  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "devices/vendor", "opts":[type]}
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
		    </tr>
		    
		    <tr>
				<?php
				// Get Model-Data
				$this->load->model('model');
				$model = $this->model->getModelByID($device->model);
				?>
				<td><b>Modell</b></td>
				<td><a class="editable-select" id="<?= $device->name ?>-model" data-type="select" data-curr="<?= $model->id ?>" data-pk="model" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Modell"><?= $model->clear_name ?></a></td>
		    
				<script>
					$(function(){
						//var vendor = $('#<?= $device->name ?>-vendor').data('curr');
						var response = $(this).myne_api({
						  method: "getDeviceByName",
						  params: {"model": "devices/device", "api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "opts":["<?= $device->name; ?>"]}
						});

						var vendor = jQuery.parseJSON(response.responseText);
						console.log(vendor);
						console.log(vendor.result);
						console.log(vendor["result"]);

						$('#<?= $device->name ?>-model').editable({
							value: $(this).data('curr'),
							source: function() {
								var gateways = $(this).myne_api({
								  method: "getModelsByVendor",
								  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "devices/model", "opts":[vendor]}
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
		    </tr>
		    
		    <?php
			// Get Room
			if (isset($device->room) && trim($device->room) != '' && $device->room != "9999") {
				if ($device->room == 0) {
				?>
					<tr>
						<td><b>Raum</b></td>
						<td><a class="editable-select" id="<?= $device->name ?>-room" data-type="select" data-curr="0" data-pk="room" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Raum">Raum wählen</a></td>
					</tr>
				<?php
				}
				else {
				?>
					<tr>
						<td><b>Raum</b></td>
						<?php
							$this->load->model('room');
							$room = $this->room->getRoomByID($device->room);
						?>
						<td><a class="editable-select" id="<?= $device->name ?>-room" data-type="select" data-curr="<?= $room->id ?>" data-pk="room" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Raum"><?= $room->clear_name ?></a> <a href="<?= base_url('rooms/show/'.$room->name) ?>"><i class="icon-share-alt"></i></a></td>
					
						<script>
							$(function(){
								$('#<?= $device->name ?>-room').editable({
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
					</tr>
				<?php
				}
			}
			?> 
		    		    
		    <tr>
				<td><b>Gruppe</b></td>
				<td>
					<li class="dropdown group_dropdown">
					<?php
						$this->load->model('devices/device');
						$device_groups = $this->device->getGroupsByDevice($device->id);
						$group_count = sizeof($device_groups);
						
						$groups = $this->device->getGroups();
					?>
					<a class="dropdown-toggle" data-toggle="dropdown"><span class="group_count"><?= $group_count ?></span> Gruppe(n) <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="nav-header">Gruppen</li>
							<?php
								foreach ($groups as $group) {
									// Check if device already has this group
									if ($this->device->deviceHasGroup($group->id,$device->id)) {
										echo '<li><a id="group-'.$group->id.'" data-device="'.$device->id.'" data-id="'.$group->id.'" class="remove_group"><i class="indicator icon-ok"></i> '.$group->clear_name.'</a></li>';
									}
									else {
										echo '<li><a id="group-'.$group->id.'" data-device="'.$device->id.'" data-id="'.$group->id.'" class="add_group"><i class="indicator"></i> '.$group->clear_name.'</a></li>';
									}
								}
							?>
							<li class="divider"></li>
							<li class="nav-header">Verwaltung</li>
							<li><a href="<?= base_url('devices/addgroup/new') ?>"><i class='icon-plus'></i> Gruppe anlegen</a></li>
						</ul>
					</li>
				</td>

				<script>
					$(document).ready(function() {
						$('.remove_group').click(function() {
							var response = $(this).myne_api({
							  method: "removeGroupMember",
							  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "devices/device", "opts":{"group_id":$(this).data('id'),"device_id":$(this).data('device')}}
							});
							$('#group-'+$(this).data('id')+' i.indicator').toggleClass('icon-ok');
							var value = parseInt($('.group_count').text());
							$('.group_count').text(value-1);

							var r_value = jQuery.parseJSON(response.responseText);
							if (r_value.hasOwnProperty('error')) {
								$(this).myne_notify({
									"text":r_value.error.message,
									"class":"error"
								});
							}
							else {
								$(this).myne_notify({
									"text":"Einstellungen gespeichert",
									"class":"success"
								});
							}
						});
						
						$('.add_group').click(function() {
							var response = $(this).myne_api({
							  method: "addGroupMember",
							  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "devices/device", "opts":{"group_id":$(this).data('id'),"device_id":$(this).data('device')}}
							});
							$('#group-'+$(this).data('id')+' i.indicator').toggleClass('icon-ok');
							var value = parseInt($('.group_count').text());
							$('.group_count').text(value+1);

							var r_value = jQuery.parseJSON(response.responseText);
							if (r_value.hasOwnProperty('error')) {
								$(this).myne_notify({
									"text":r_value.error.message,
									"class":"error"
								});
							}
							else {
								$(this).myne_notify({
									"text":"Einstellungen gespeichert",
									"class":"success"
								});
							}
						});
					});
				</script>
			</tr>
			
			<?php
			// Get Gateway
			if (isset($device->gateway) && trim($device->gateway) != '' && $device->gateway != "9999") {
				if ($device->gateway == 0) {
				?>
					<tr>
						<td><b>Gateway</b></td>
						<td><a class="editable-select" id="<?= $device->name ?>-gateway" data-type="select" data-curr="0" data-pk="gateway" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Gateway">Gateway wählen</a></td>
					</tr>
				<?php
				}
				else {
				?>
					<tr>
						<td><b>Gateway</b></td>
						<?php
							$this->load->model('gateways/gateway');
							$gateway = $this->gateway->getGatewayByID($device->gateway);
						?>
						<td><a class="editable-select" id="<?= $device->name ?>-gateway" data-type="select" data-curr="<?= $gateway->id ?>" data-pk="gateway" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Gateway"><?= $gateway->clear_name ?></a> <a href="<?= base_url('gateways/show/'.$gateway->name) ?>"><i class="icon-share-alt"></i></a></td>
					
						<script>
							$(function(){
								$('#<?= $device->name ?>-gateway').editable({
									value: $(this).data('curr'),
									source: function() {
										var gateways = $(this).myne_api({
										  method: "getGateways",
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
					</tr>
				<?php
				}
			}
			?>
		    
		    <?php
			// Get Master DIP
			if (isset($device->masterdip) && trim($device->masterdip) != '') {
				?>
				<tr>
					<td><b>Master DIP</b></td>
					<td><a class="masterdip-editable" id="<?= $device->name ?>-masterdip" data-type="text" data-pk="masterdip" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Master DIP"><?= $device->masterdip ?></a></td>
				</tr>
		    <?php
			}
			?>
		    
		    <?php
			// Get Slave DIP
			if (isset($device->slavedip) && trim($device->slavedip) != '') {
				?>
				<tr>
					<td><b>Slave DIP</b></td>
					<td><a class="slavedip-editable" id="<?= $device->name ?>-slavedip" data-type="text" data-pk="slavedip" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Slave DIP"><?= $device->slavedip ?></a></td>
					
					<script>
						$(document).ready(function() {
							$('.slavedip-editable').editable({
							    mode: 'popup',
							    validate: function(value) {
							    	var slavedip = value;
							    	var masterdip = $('.masterdip-editable').text();
								    var request = {"jsonrpc": "2.0", "method": "dipIsUnique", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"devices/device","opts":[masterdip,slavedip]}, "id": 1};
									$.ajax({
										url: "<?= base_url('api/request'); ?>",
										type: "post",
										data: JSON.stringify(request),
										dataType: "json",
										async: false,
										success: function(data) {
											response = data;
										} 
									});	
									if (response.result=="true") {
										return "";
									}
									else {
										return "Diese Master DIP / Slave DIP Kombination existiert bereits!";
									}
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
							$('.masterdip-editable').editable({
							    mode: 'popup',
							    validate: function(value) {
							    	var slavedip = $('.slavedip-editable').text();
							    	var masterdip = value;
								    var request = {"jsonrpc": "2.0", "method": "dipIsUnique", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"devices/device","opts":[masterdip,slavedip]}, "id": 1};
									$.ajax({
										url: "<?= base_url('api/request'); ?>",
										type: "post",
										data: JSON.stringify(request),
										dataType: "json",
										async: false,
										success: function(data) {
											response = data;
										} 
									});	
									if (response.result=="true") {
										return "";
									}
									else {
										return "Diese Master DIP / Slave DIP Kombination existiert bereits!";
									}
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
				</tr>
		    <?php
			}
			?>
			
			<?php
			// Get Address
			if (isset($device->address) && trim($device->address) != '') {
				?>
				<tr>
					<td><b>Adresse</b></td>
					<td><a class="editable" id="<?= $device->name ?>-address" data-type="text" data-pk="address" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Adresse"><?= $device->address ?></a></td>
				</tr>
		    <?php
			}
			?>
			
			<?php
			// Get Port
			if (isset($device->port) && trim($device->port) != '') {
				?>
				<tr>
					<td><b>Port</b></td>
					<td><a class="editable" id="<?= $device->name ?>-port" data-type="text" data-pk="port" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Port"><?= $device->port ?></a></td>
				</tr>
		    <?php
			}
			?>
			
			<?php
			// Get User
			if (isset($device->user) && trim($device->user) != '') {
				?>
				<tr>
					<td><b>User</b></td>
					<td><a class="editable" id="<?= $device->name ?>-user" data-type="text" data-pk="user" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="User"><?= $device->user ?></a></td>
				</tr>
		    <?php
			}
			?>
			
			<?php
			// Get Password
			if (isset($device->password) && trim($device->password) != '') {
				?>
				<tr>
					<td><b>Passwort</b></td>
					<td><a class="editable" id="<?= $device->name ?>-password" data-type="text" data-pk="password" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Password"><?= $device->password ?></a></td>
				</tr>
		    <?php
			}
			?>
		</table>
	</div>
	<?php
		$this->load->view('tasks/tasks',array('device_type' => 'device','target' => $device));	
	?>
</div>
