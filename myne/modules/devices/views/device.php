<div class="row-fluid">
	<div class="span4">
		<h3>Geräteinformationen</h3>
		<table class="table table-striped device_data">
			<tr>
				<?php
				// Get description
				?>
				<td><b>Beschreibung</b></td>
				<td><a class="editable" id="<?= $device->name ?>-description" data-type="text" data-pk="description" data-url="<?php echo base_url(); ?>devices/update/device/<?= $device->name ?>" data-original-title="Description"><?= $device->description ?></a></td>
			</tr>
			<tr>
				<?php
				// Get Type-Data
				$this->load->model('device');
				$type = $this->device->getTypeByID($device->type);
				?>
				<td><b>Typ</b></td>
				<td><?= $type->clear_name ?></td>
			</tr>
		    <tr>
				<?php
				// Get Vendor-Data
				$this->load->model('devices/vendor');
				$vendor = $this->vendor->getVendorByID($device->vendor);
				?>
				<td><b>Hersteller</b></td>
				<td><?= $vendor->clear_name ?></td>
		    </tr>
		    <tr>
				<?php
				// Get Model-Data
				$this->load->model('model');
				$model = $this->model->getModelByID($device->model);
				?>
				<td><b>Modell</b></td>
				<td><?= $model->clear_name ?></td>
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
					</tr>
				<?php
				}
			}
			?>
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
			</tr>
			<script>
				$(document).ready(function() {
					$('.remove_group').click(function() {
						$(this).myne_api({
						  method: "removeGroupMember",
						  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "devices/device", "opts":{"group_id":$(this).data('id'),"device_id":$(this).data('device')}}
						});
						$('#group-'+$(this).data('id')+' i.indicator').toggleClass('icon-ok');
						var value = parseInt($('.group_count').text());
						$('.group_count').text(value-1);
					});
					
					$('.add_group').click(function() {
						$(this).myne_api({
						  method: "addGroupMember",
						  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "devices/device", "opts":{"group_id":$(this).data('id'),"device_id":$(this).data('device')}}
						});
						$('#group-'+$(this).data('id')+' i.indicator').toggleClass('icon-ok');
						var value = parseInt($('.group_count').text());
						$('.group_count').text(value+1);
					});
				});
			</script>
			
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
					</tr>
				<?php
				}
			}
			?>
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
				</tr>
		    <?php
			}
			?>
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
		$this->load->model('tasks/task');
		$tasks = $this->task->getTasksByDevice($device->name,'device');
		
		if (sizeof($tasks) != 0) {
		?>
			<div class="span5">
				<h3>Tasks</h3>
				<table class="table">
					<thead>
						<tr>
							<th>Event</th>
							<th>Action</th>
							<th>Aktiv</th>
							<th>Löschen</th>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach($tasks as $task) {
							echo "<tr id='task-single-".$task->name."'>";
							$this->load->model('event');
							$event_type = $this->event->getEventByID($task->event);
							
							if ($event_type->name == 'timer') {
								$this->load->model('timers/timer');

								$event = $this->timer->getTimerByID($task->event_opt);
								echo "<td><i class='icon-calendar'></i> ";
									echo '<div class="btn-group">';
									?>
									  <button data-what="mon" data-id="<?php echo $event->id; ?>" class="timer_update btn <?php echo ($event->mon) ? " active":""; ?>">M</button>
									  <button data-what="tue" data-id="<?php echo $event->id; ?>" class="timer_update btn <?php echo ($event->tue) ? " active":""; ?>">D</button>
									  <button data-what="wed" data-id="<?php echo $event->id; ?>" class="timer_update btn <?php echo ($event->wed) ? " active":""; ?>">M</button>
									  <button data-what="thu" data-id="<?php echo $event->id; ?>" class="timer_update btn <?php echo ($event->thu) ? " active":""; ?>">D</button>
									  <button data-what="fri" data-id="<?php echo $event->id; ?>" class="timer_update btn <?php echo ($event->fri) ? " active":""; ?>">F</button>
									  <button data-what="sat" data-id="<?php echo $event->id; ?>" class="timer_update btn <?php echo ($event->sat) ? " active":""; ?>">S</button>
									  <button data-what="sun" data-id="<?php echo $event->id; ?>" class="timer_update btn <?php echo ($event->sun) ? " active":""; ?>">S</button>
									<?php
									echo '</div>';
									
									echo ' <i class="icon-time"></i> <span id="'.$event->id.'" style="cursor: pointer;" data-type="text" data-pk="time"  data-url="'.base_url().'tasks/update/timer/'.$event->id.'" data-original-title="Zeit" class="label label-primary editable">'.$event->time.'</span>';
								echo "</td>";
								echo "<td>";
									echo '<div class="btn-group">';
										// Get Action
										$action = $this->device->getOptionByID($task->action);
										if ($action->name == 'toggle') {
											if ($task->action_opt == 'on') {
												echo "<button data-type='device' id='button-task-".$task->name."' data-name='".$device->name."' class='toggle_on btn btn-success' title='".$device->clear_name." anschalten.' ><i class='icon-ok icon-white'></i></button>";
												
												// Change
												echo '<button class="btn dropdown-toggle" data-toggle="dropdown">';
													echo '<span class="caret"></span>';
												echo '</button>';
												echo '<ul class="dropdown-menu" id="change-task-'.$task->name.'">';
													echo '<li><a style="cursor:pointer;" data-name="'.$task->name.'" data-value="off" class="toggle_task_action">Ändere zu "Aus"</a></li>';
												echo '</ul>';
											}
											else {
												echo "<button data-type='device' id='button-task-".$task->name."' data-name='".$device->name."' class='toggle_off btn btn-danger' title='".$device->clear_name." anschalten.' ><i class='icon-off icon-white'></i></button>";
												// Change
												echo '<button class="btn dropdown-toggle" data-toggle="dropdown">';
													echo '<span class="caret"></span>';
												echo '</button>';
												echo '<ul class="dropdown-menu" id="change-task-'.$task->name.'">';
													echo '<li><a style="cursor:pointer;" data-name="'.$task->name.'" data-value="on" class="toggle_task_action">Ändere zu "An"</a></li>';
												echo '</ul>';

											}
										}
									echo '</div>';
								echo "</td>";

								echo "<td>";
									if ($task->active) {
										echo '<a style="cursor: pointer;" id="active-task-'.$task->name.'" data-value="0" data-name="'.$task->name.'" class="toggle_task_active"><i class="icon-ok-circle active-indicator"></i></a>';
									}
									else {
										echo '<a style="cursor: pointer;" id="active-task-'.$task->name.'" data-value="1" data-name="'.$task->name.'" class="toggle_task_active"><i class="icon-ban-circle active-indicator"></i></a>';
									}
								echo "</td>";
								
								// Delete
								echo "<td>";
									echo '<a class="btn btn-danger delete_task" data-name="'.$task->name.'"><i class="icon-trash icon-white"></i></a>';
								echo "</td>";
							}
							echo "</tr>";
						}
					?>
					</tbody>
				</table>
			</div>
			<script>
				$(document).ready(function() {
					$('.timer_update').click(function() {
						if ($(this).hasClass('active')) {
							$(this).removeClass('active');
							var response = $(this).myne_api({
							  method: "updateTimer",
							  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "timers/timer", "opts":{"id":$(this).data('id'),"what":$(this).data('what'),"new_value":"0"}}
							});
						}
						else {
							$(this).addClass('active');
							var response = $(this).myne_api({
							  method: "updateTimer",
							  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "timers/timer", "opts":{"id":$(this).data('id'),"what":$(this).data('what'),"new_value":"1"}}
							});
						}
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
					
					$('.toggle_task_action').click(function() {
						var response = $(this).myne_api({
						  method: "updateTask",
						  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "tasks/task", "opts":{"name":$(this).data('name'),"what":"action_opt","new_value":$(this).data('value')}}
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
								"text":"Einstellungen gespeichert",
								"class":"success"
							});
						}
						
						if ($(this).data('value') == 'on') {
							// Update button
							$('#button-task-'+$(this).data('name')).removeClass('btn-danger').addClass('btn-success');
							$('#button-task-'+$(this).data('name')+' i.icon-white').removeClass('icon-off').addClass('icon-ok');
							
							// Update Change Link
							$('#change-task-'+$(this).data('name')+' a.toggle_task_action').data('value','off').text('Ändere zu "Aus"');
						}
						else if ($(this).data('value') == 'off') {
							// Update button
							$('#button-task-'+$(this).data('name')).removeClass('btn-success').addClass('btn-danger');
							$('#button-task-'+$(this).data('name')+' i.icon-white').removeClass('icon-ok').addClass('icon-off');
							
							// Update Change Link
							$('#change-task-'+$(this).data('name')+' a.toggle_task_action').data('value','on').text('Ändere zu "An"');
						}
					});
					
					$('.toggle_task_active').click(function() {
						var response = $(this).myne_api({
						  method: "updateTask",
						  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "tasks/task", "opts":{"name":$(this).data('name'),"what":"active","new_value":$(this).data('value')}}
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
								"text":"Einstellungen gespeichert",
								"class":"success"
							});
						}
						
						if ($(this).data('value') == '0') {
							// Update icon
							$('#active-task-'+$(this).data('name')+' i.active-indicator').removeClass('icon-ok-circle').addClass('icon-ban-circle');
							$('#active-task-'+$(this).data('name')).data('value','1');
						}
						else if ($(this).data('value') == '1') {
							// Update icon
							$('#active-task-'+$(this).data('name')+' i.active-indicator').removeClass('icon-ban-circle').addClass('icon-ok-circle');
							$('#active-task-'+$(this).data('name')).data('value','0');
						}
					});
					
					$('.delete_task').click(function() {
						$(this).myne_api({
						  method: "deleteTask",
						  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "tasks/task", "opts":{"name":$(this).data('name')}}
						});
						
						$('#task-single-'+$(this).data('name')).fadeOut();
					});
					
				});
			</script>
		<?php
		}
		?>
</div>
