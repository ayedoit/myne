<div class="row-fluid">
	<div class="span6">
		<?php
			$actions_defined = true;
			// Check if Cronjob for tasks is set. If not, alert.
			if (!$this->tools->cronIsSet()) {
				echo '<div class="alert">';
				  echo '<strong>Achtung!</strong> Der Task-Cronjob ist nicht aktiv! Klicke <a href="'.base_url('settings').'">hier</a> um ihn zu setzen.';
				echo '</div>';
			}

			// Check if current device has any action
			if (isset($device_name) && trim($device_name) != '') {
				if (isset($device_type) && trim($device_type) != '') {
					if ($device_type == 'device') {
						$this->load->model('action');
						$this->load->model('devices/device');

						$device = $this->device->getDeviceByName($device_name);
						$actions = $this->action->getActionsByDevice($device->id);

						if (sizeof($actions) == 0) {
							$actions_defined = false;
							echo '<div class="alert">';
							  echo '<strong>Achtung!</strong> Für dieses Gerät sind keine Aktionen möglich.';
							echo '</div>';
						}
					}
					elseif ($device_type == 'group') {
						$this->load->model('action');
						$this->load->model('devices/device');

						$group = $this->device->getGroupByName($device_name);
						$actions = $this->action->getActionsByGroup($group->id);

						if (sizeof($actions) == 0) {
							$actions_defined = false;
							echo '<div class="alert">';
							  echo '<strong>Achtung!</strong> Für dieser Gruppe sind keine Aktionen möglich.';
							echo '</div>';
						}
					}
				}
			}
			
		?>
		<?php
		$this->load->helper('form');
		$attributes = array('class' => 'form-horizontal', 'id' => 'add_task');
		echo form_open('tasks/add/validate',$attributes);
		?>
		<fieldset>
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Ziel-Typ', 'tasks_target_type',$attributes);
				?>
				<div class="controls">
					<?php			
						$options = array(
							"device" => "Gerät",
							"room" => "Raum",
							"type" => "Gerätetyp",
							"gateway" => "Gateway",
							"group" => "Gruppe"
						);
						
						if (isset($device_type) && trim($device_type) != '') {
							$selected = $device_type;
						}
						else {
							$selected = 'device';
						}
						
						$data = 'id="tasks_target_type"';
						echo form_dropdown('tasks_target_type', $options,$selected,$data); 
					?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Ziel', 'tasks_target_name',$attributes);
				?>
				<div class="controls">
					<?php		
						if (isset($device_type) && trim($device_type) != '') {
							switch($device_type) {
								case 'device': $this->load->model('devices/device');$items = $this->device->getDevices(); break;
								case 'room': $this->load->model('room');$items = $this->room->getRooms(); break;
								case 'type': $this->load->model('devices/device');$items = $this->device->getDeviceTypes(); break;
								case 'gateway': $this->load->model('gateways/gateway');$items = $this->gateway->getGateways(); break;
								case 'group': $this->load->model('devices/device');$items = $this->device->getGroups(); break;
								default: $this->load->model('devices/device');$items = $this->device->getDevices(); break;
							}
							
							if (isset($device_name) && trim($device_name) != '') {
								$selected = $device_name;
							}
							else {
								$selected = "1";
							}
						}
						else {
							$this->load->model('devices/device');
							$items = $this->device->getDevices();
						}

						$options = array();
						foreach ($items as $item) {
							$options[$item->id] = $item->clear_name;
						}
						$data = 'id="tasks_target_name"';
						echo form_dropdown('tasks_target_name', $options,$selected,$data); 
					?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Event', 'tasks_event',$attributes);
				?>
				<div class="controls">
					<?php
						$this->load->model('events/event');
						$events = $this->event->getEventTypes();
						
						$options = array();
						foreach ($events as $event) {
							$options[$event->id] = $event->clear_name;
						}
						$data = 'id="tasks_event"';
						echo form_dropdown('tasks_event', $options,"1",$data); 
					?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div id="event_space">
				<?php
					$this->load->view('events/timer-add');
				?>	
			</div>
			 
			<div id="action_space">
				<div class="control-group">
					<?php 
						$attributes = array(
							'class' => 'control-label'
						);
						echo form_label('Aktion', 'tasks_action',$attributes);
					?>
					<div class="controls">
						<?php
							$this->load->model('action');
							if ($actions_defined) {
								if (isset($device_name) && trim($device_name) != '') {

									if (isset($device_type) && trim($device_type) != '') {
										if ($device_type == 'device') {
											$this->load->model('devices/device');

											$device = $this->device->getDeviceByName($device_name);
											$actions = $this->action->getActionsByDevice($device->id);
										}
										elseif ($device_type == 'group') {
											$this->load->model('devices/device');

											$group = $this->device->getGroupByName($device_name);
											$actions = $this->action->getActionsByGroup($group->id);
										}
									}
								}
								else {
									$actions = $this->action->getActions();
								}
								$options = array();
								foreach ($actions as $action) {
									$options[$action->id] = $action->clear_name;
								}
								$data = 'id="tasks_action"';
								echo form_dropdown('tasks_action', $options,"1",$data);
							}
							else {
								$options = array(
									'0' => "Keine Aktion möglich"
								);
								$data = 'id="tasks_action" disabled';
								echo form_dropdown('tasks_action', $options,"0",$data);
							}	 
						?>
					  <span class="validation_space"></span>
					</div>
				</div>
				
				<div id="action_space">
					<div class="control-group">
						<?php 
							$attributes = array(
								'class' => 'control-label'
							);
							echo form_label('Status', 'tasks_action_opt',$attributes);
						?>
						<div class="controls">
							<?php
								if ($actions_defined) {
									$options = array("on" => "An", "off" => "Aus");
									$data = 'id="tasks_action_opt"';
									echo form_dropdown('tasks_action_opt', $options,"on",$data); 
								}
								else {
									$options = array(0 => "Keine Aktion möglich");
									$data = 'id="tasks_action_opt" disabled';
									echo form_dropdown('tasks_action_opt', $options,"0",$data); 
								}
								
							?>
						  <span class="validation_space"></span>
						</div>
					</div>
				</div>
			</div>
						
			 <div class="control-group">
				<div class="controls">
				  <?php 
					$data = array(
					  'form' => '1'
					);		
					echo form_hidden($data);	
					
					if (!$actions_defined) {
						$submit = array(
							"class" => "btn btn-primary btn-medium",
							"name" => "tasks_submit",
							"id" => "tasks_submit",
							"value" => "Anlegen",
							"disabled" => true
						);
					}
					else {
						$submit = array(
							"class" => "btn btn-primary btn-medium",
							"name" => "tasks_submit",
							"id" => "tasks_submit",
							"value" => "Anlegen"
						);
					}
					
					echo form_submit($submit);	
				?>
				</div>
			</div>

		</fieldset>
		<?php form_close(); ?>
	</div>
	
	<div class="span6 well">
		<dl>
			<dt>Ziel-Typ</dt>
			<dd>Bezieht sich der Task auf ein einzelnes Gerät, einen Raum, einen Gerätetyp, alle Geräte eines Gateways oder eine Gerätegruppe?</dd>
			<dt>Ziel</dt>
			<dd>Das konkrete Ziel des Tasks.</dd>
			<dt>Event</dt>
			<dd>Welches Event soll die Aktion des Tasks auslösen (z.B. Timer)?</dd>
			<dt>Aktion</dt>
			<dd>Welche Aktion soll ausgeführt werden?</dd>
			<dt>Status</dt>
			<dd>Status des Gerätes den der Task setzen soll.</dd>	
		</dl>	
	</div>
</div>
<script>
	$(document).ready(function() { 
		$('#tasks_target_type').change(function() {
			var value = $('#tasks_target_type').val();
			var response = "";
			
			// Get entries for selected type
			if (value == 'group') {
				var request = {"jsonrpc": "2.0", "method": "getGroups", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"devices/device","opts":[""]}, "id": 2};
			}
			else if (value == 'device') {
				var request = {"jsonrpc": "2.0", "method": "getDevices", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"devices/device","opts":[""]}, "id": 2};
			}
			else if (value == 'room') {
				var request = {"jsonrpc": "2.0", "method": "getRooms", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"room","opts":[""]}, "id": 2};
			}
			else if (value == 'type') {
				var request = {"jsonrpc": "2.0", "method": "getDeviceTypes", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"devices/device","opts":[""]}, "id": 2};
			}
			else if (value == 'gateway') {
				var request = {"jsonrpc": "2.0", "method": "getGateways", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"gateways/gateway","opts":[""]}, "id": 2};
			}

			$.post("<?= base_url('api/request'); ?>", JSON.stringify(request), function(data) {				
				$("#tasks_target_name option").each(function() {
					$(this).remove();
				});
				
				// Udate targets
				$.each(data.result, function (key,val) {
					$('#tasks_target_name')
					 .append($("<option></option>")
					 .attr("value",val.id)
					 .text(val.clear_name)); 
				});
				
				$('#tasks_target_name').trigger('change');
			});	
		});

		$('#tasks_target_name').on('change',function() {
			$('#tasks_submit').removeAttr('disabled');

			var value = $('#tasks_target_name').val();
			var target_type = $('#tasks_target_type').val();
			var response = "";
			
			// Get entries for selected type
			if (target_type == 'group') {
				var request = {"jsonrpc": "2.0", "method": "getActionsByGroup", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"action","opts":[value]}, "id": 2};
			}
			else if (target_type == 'device') {
				var request = {"jsonrpc": "2.0", "method": "getActionsByDevice", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"action","opts":[value]}, "id": 2};
			}
			else if (target_type == 'room') {
				var request = {"jsonrpc": "2.0", "method": "getActions", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"action","opts":[value]}, "id": 2};
			}
			else if (target_type == 'gateway') {
				var request = {"jsonrpc": "2.0", "method": "getActions", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"action","opts":[value]}, "id": 2};
			}
			else if (target_type == 'type') {
				var request = {"jsonrpc": "2.0", "method": "getActionsByDeviceType", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"action","opts":[value]}, "id": 2};
			}

			$.post("<?= base_url('api/request'); ?>", JSON.stringify(request), function(data) {				
				$("#tasks_action option").each(function() {
					$(this).remove();
				});
				if (data.result.length === 0) {
					// No actions defined for device
					$('#tasks_submit').attr('disabled',true);
					$('#tasks_action')
						 .attr('disabled','disabled')
						 .append($("<option></option>")
						 .attr("value","0")
						 .text("Keine Aktion möglich"));
				}
				else {
					// Udate targets
					$.each(data.result, function (key,val) {
						$('#tasks_action')
						 .removeAttr('disabled')
						 .append($("<option></option>")
						 .attr("value",val.id)
						 .text(val.clear_name)); 
					});
				}
				
				$('#tasks_action_opt').trigger('change');
			});	
		});

		$('#tasks_action_opt').on('change',function() {
			var value = $('#tasks_target_name').val();
			var tasks_action = $('#tasks_action').val();
			var response = "";

			$("#tasks_action_opt option").each(function() {
				$(this).remove();
			});
			
			if (tasks_action == "0") {
				$(this)
				 .attr('disabled','disabled')
				 .append($("<option></option>")
				 .attr("value","0")
				 .text("Keine Aktion möglich"));
			}
			else {
				if (tasks_action == "1") {
					// If "set_status"
					var status_values = {
						0: {
							"clear_name": "An",
							"item_value": "on"
						},
						1: {
							"clear_name": "Aus",
							"item_value": "off"
						}
					};
					$.each(status_values, function (key,val) {
						$('#tasks_action_opt')
						 .removeAttr('disabled')
						 .append($("<option></option>")
						 .attr("value",val.item_value)
						 .text(val.clear_name)); 
					});
				}
			}
		});
		
		$('#add_task').validate(
		{
		rules: {
			time: {
			  required: true
			},
			data: {
			  required: true
			},
			dom: {
			  required: true
			},
			mon: {
			  required: true
			},
			minute: {
			  required: true
			},
		},
		highlight: function(element) {
			$(element).closest('.control-group').removeClass('success').addClass('error');
		},
		success: function(element) {
			element
			.html('<i class="icon-ok-circle"></i>').addClass('valid')
			.closest('.control-group').removeClass('error').addClass('success');
		}
		});
		
	} ); 
</script>
