<div class="row-fluid">
	<div class="span4">
		<h3>Geräteinformationen</h3>
		<table class="table table-striped">
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
		    
		    <tr>
				<?php
				// Get Room
				$this->load->model('room');
				$room = $this->room->getRoomByID($device->room);
				?>
				<td><b>Raum</b></td>
				<td><a href="<?= base_url('rooms/show/'.$room->name) ?>" title="<?= $room->clear_name ?>"><?= $room->clear_name ?></a></td>
		    </tr>
		    
			<?php
			// Get Group
			if (isset($device->group) && trim($device->group) != '' && $device->group != 0) {
				$group = $this->device->getGroupByID($device->group);
				?>
				<tr>
					<td><b>Gruppe</b></td>
					<td><a href="<?= base_url('devices/groups/'.$group->name) ?>" title="<?= $group->clear_name ?>"><?= $group->clear_name ?></a></td>
				</tr>
		    <?php
			}
			?>
			
			<?php
			// Get Gateway
			if (isset($device->gateway) && trim($device->gateway) != '' && $device->gateway != 0) {
				?>
				<tr>
					<td><b>Gateway</b></td>
					<?php
						$this->load->model('gateways/gateway');
						$gateway = $this->gateway->getGatewayByID($device->gateway);
					?>
					<td><a href="<?= base_url('gateways/show/'.$gateway->name) ?>"><?= $gateway->clear_name ?></a></td>
				</tr>
		    <?php
			}
			?>
		    
		    
		    <?php
			// Get Master DIP
			if (isset($device->masterdip) && trim($device->masterdip) != '') {
				?>
				<tr>
					<td><b>Master DIP</b></td>
					<td><?= $device->masterdip ?></td>
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
					<td><?= $device->slavedip ?></td>
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
					<td><?= $device->address ?></td>
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
					<td><?= $device->port ?></td>
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
					<td><?= $device->user ?></td>
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
					<td><?= $device->password ?></td>
				</tr>
		    <?php
			}
			?>
		</table>
	</div>
	<?php
		$this->load->model('task');
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
								$this->load->model('timer');

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
									
									echo ' <i class="icon-time"></i> <span id="timer-'.$event->id.'" style="cursor: pointer;" data-what="time" data-content="'.$event->time.'" data-id="'.$event->id.'" class="timer_update_time label label-primary">'.$event->time.'</span>';
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
							$(this).myne_api({
							  method: "updateTimer",
							  params: {"model": "timer", "opts":{"id":$(this).data('id'),"what":$(this).data('what'),"new_value":"0"}}
							});
						}
						else {
							$(this).addClass('active');
							$(this).myne_api({
							  method: "updateTimer",
							  params: {"model": "timer", "opts":{"id":$(this).data('id'),"what":$(this).data('what'),"new_value":"1"}}
							});
						}
					});
					
					$('.timer_update_time').on('click',function() {
						$('.timer_update_time').popover({
							'title':"Zeit ändern",
							'trigger':'manual',
							'html':'true',
							'placement':'right',
							'content':'<form class="form-inline"><input type="text" class="input-small" name="timer_time" /> <button type="button" value="'+$(this).data('content')+'" data-id="'+$(this).data('id')+'" class="btn btn-primary timer_submit" type="submit">OK</button> <button type="button" class="btn timer_cancel" type="reset">Cancel</button></form>'
						});
						
						$(this).popover('toggle');
						
						$('.timer_submit').click(function() {
							var timer_id = $(this).data('id');
							var new_time = $(this).prevAll('.input-small').val();
							
							if (new_time.match(/^([01][0-9]|2[0-3]):[0-5][0-9]$/)) {
								$(this).myne_api({
								  method: "updateTimer",
								  params: {"model": "timer", "opts":{"id":timer_id,"what":"time","new_value":new_time}}
								});
								
								$('#timer-'+timer_id).text(new_time);
								$('.timer_update_time').popover('hide');
							}
							else {
								alert("Falsches Format. HH:MM");
							}
						});
						
						$('.timer_cancel').click(function() {
							$('.timer_update_time').popover('hide');
						});
					});
					
					$('.toggle_task_action').click(function() {
						$(this).myne_api({
						  method: "updateTask",
						  params: {"model": "task", "opts":{"name":$(this).data('name'),"what":"action_opt","new_value":$(this).data('value')}}
						});
						
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
						$(this).myne_api({
						  method: "updateTask",
						  params: {"model": "task", "opts":{"name":$(this).data('name'),"what":"active","new_value":$(this).data('value')}}
						});
						
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
						  params: {"model": "task", "opts":{"name":$(this).data('name')}}
						});
						
						$('#task-single-'+$(this).data('name')).fadeOut();
					});
					
				});
			</script>
		<?php
		}
		?>
</div>
