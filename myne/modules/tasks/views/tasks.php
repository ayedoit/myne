<?php
$this->load->model('tasks/task');
$tasks = $this->task->getTasksByDevice($target->name,$device_type);

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
								$this->load->model('action');
								$action = $this->device->getActionByID($task->action);
								if ($action->name == 'set_status') {
									if ($task->action_opt == 'on') {
										echo "<button data-type='".$device_type."' id='button-task-".$task->name."' data-name='".$target->name."' class='toggle_on btn btn-success' title='".$target->clear_name." anschalten.' ><i class='icon-ok icon-white'></i></button>";
										
										// Change
										echo '<button class="btn dropdown-toggle" data-toggle="dropdown">';
											echo '<span class="caret"></span>';
										echo '</button>';
										echo '<ul class="dropdown-menu" id="change-task-'.$task->name.'">';
											echo '<li><a style="cursor:pointer;" data-name="'.$task->name.'" data-value="off" class="toggle_task_action">Ändere zu "Aus"</a></li>';
										echo '</ul>';
									}
									else {
										echo "<button data-type='".$device_type."' id='button-task-".$task->name."' data-name='".$target->name."' class='toggle_off btn btn-danger' title='".$target->clear_name." anschalten.' ><i class='icon-off icon-white'></i></button>";
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