<div class="row-fluid">
	<div class="span6">
		<?php
			// Check if Cronjob for tasks is set. If not, alert.
			if (!$this->tools->cronIsSet()) {
				echo '<div class="alert">';
				  echo '<strong>Achtung!</strong> Der Task-Cronjob ist nicht aktiv! Klicke <a href="'.base_url('settings').'">hier</a> um ihn zu setzen.';
				echo '</div>';
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
							$options[$item->name] = $item->clear_name;
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
					echo form_label('Task-ID', 'tasks_name',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'tasks_name',
					  'id'          => 'tasks_name',
					  'placeholder' => 'Task-ID'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Task Name', 'tasks_clear_name',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'tasks_clear_name',
					  'id'          => 'tasks_clear_name',
					  'placeholder' => 'Task Name'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Task Beschreibung', 'tasks_description',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'tasks_description',
					  'id'          => 'tasks_description',
					  'placeholder' => 'Task Beschreibung'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Aktiv', 'tasks_active',$attributes);
				?>
				<div class="controls">
					<?php						
						$options = array(0 => "Nein","1" => "Ja");
						$data = 'id="tasks_active"';
						echo form_dropdown('tasks_active', $options,"1",$data); 
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
						$this->load->model('event');
						$events = $this->event->getEvents();
						
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
				<div class="control-group">
					<?php 
						$attributes = array(
							'class' => 'control-label'
						);
						echo form_label('Tage', 'timer_days',$attributes);
					?>
					<div class="controls">
						<div class="btn-group" data-toggle="buttons-checkbox">
						<?php
							// Mon
								echo '<button type="button" data-day="timer_mon" class="btn btn-medium timer_day">M</button>';
								echo form_hidden('timer_mon', '0');
							// Tue
								echo '<button type="button" data-day="timer_tue" class="btn btn-medium timer_day">D</button>';
								echo form_hidden('timer_tue', '0');
							// Wed
								echo '<button type="button" data-day="timer_wed" class="btn btn-medium timer_day">M</button>';
								echo form_hidden('timer_wed', '0');
							// Thu
								echo '<button type="button" data-day="timer_thu" class="btn btn-medium timer_day">D</button>';
								echo form_hidden('timer_thu', '0');
							// Fri
								echo '<button type="button" data-day="timer_fri" class="btn btn-medium timer_day">F</button>';
								echo form_hidden('timer_fri', '0');
							// Sat
								echo '<button type="button" data-day="timer_sat" class="btn btn-medium timer_day">S</button>';
								echo form_hidden('timer_sat', '0');
							// Sun
								echo form_hidden('timer_sun', '0');
								echo '<button type="button" data-day="timer_sun" class="btn btn-medium timer_day">S</button>';
								
						?>
						</div>
						
						<script>
							$(document).ready(function() { 
								$('.timer_day').click(function() {
									
									var day = $(this).data('day');
									if ($('input[name="'+day+'"]').val() == "0") {
										$('input[name="'+day+'"]').val("1");
									}
									else {
										$('input[name="'+day+'"]').val("0");
									}
								});
							});
						</script>
					</div>
				</div>

				<div class="control-group">
					<?php 
						$attributes = array(
							'class' => 'control-label'
						);
						echo form_label('Uhrzeit', 'timer_time',$attributes);
					?>
					<div class="controls">
						
						<div id="timer_time" class="input-append date">
						  <input name="timer_time" type="text"></input>
						  <span class="add-on">
							<i data-time-icon="icon-time"></i>
						  </span>
						</div>
						
						<script type="text/javascript">
							$('#timer_time').datetimepicker({
								format: 'hh:mm',
								language: 'de-DE',
								pickDate: false,
								pickSeconds: false
							});
						</script>
					</div>
				</div>
			 </div>
			 
			 <div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Aktion', 'tasks_action',$attributes);
				?>
				<div class="controls">
					<?php
						$this->load->model('devices/device');
						$actions = $this->device->getOptions();
						
						$options = array();
						foreach ($actions as $action) {
							$options[$action->id] = $action->clear_name;
						}
						$data = 'id="tasks_action"';
						echo form_dropdown('tasks_action', $options,"1",$data); 
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
							$this->load->model('devices/device');
							$actions = $this->device->getOptions();
							
							$options = array("off" => "Aus", "on" => "An");
							$data = 'id="tasks_action_opt"';
							echo form_dropdown('tasks_action_opt', $options,"1",$data); 
						?>
					  <span class="validation_space"></span>
					</div>
				</div>
			</div>
						
			 <div class="control-group">
				<div class="controls">
				  <?php 
					$data = array(
					  'add_event'  => '1',
					  'add_timer'  => '1',
					  'form' => '1'
					);		
					echo form_hidden($data);	
					
					$submit = array(
						"class" => "btn btn-primary btn-medium",
						"name" => "tasks_submit",
						"value" => "Anlegen"
					);
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
			<dt>Task-ID</dt>
			<dd>Eindeutige Gerätebezeichnung. Nur Kleinbuchstaben, Zahlen sowie "<b>-</b>" und "<b>_</b>" als Sonderzeichen.</dd>
			<dt>Task Name</dt>
			<dd>Klarname des Tasks für die Darstellung im Frontend.</dd>
			<dt>Task Beschreibung</dt>
			<dd>Beschreibung des Tasks.</dd>
			<dt>Aktiv</dt>
			<dd>Ist der Task aktiv?</dd>
			<dt>Event</dt>
			<dd>Welches Event soll die Aktion des Tasks auslösen (z.B. Timer)?</dd>
			<dt>Tage</dt>
			<dd>Timer: An welchen Wochentagen soll der Timer auslösen?</dd>
			<dt>Uhrzeit</dt>
			<dd>Timer: Zu welcher Uhrzeit soll der Timer auslösen?</dd>
			<dt>Aktion</dt>
			<dd>Welche Aktion soll ausgeführt werden?</dd>
			<dt>Status</dt>
			<dd>Status des Gerätes den der Task setzen soll.</dd>	
		</dl>
			<h3>Beispiel</h3>
			<p>Ein möglicher Task könnte zum Beispiel so aussehen:</p>
			<ul>
				<li><b>Ziel-Typ</b>: Gerät</li>
				<li><b>Ziel</b>: Lampe im Bücherregal</li>
				<li><b>Task-ID</b>: lampe_books_on</li>
				<li><b>Task Name</b>: Lampe Bücherregal an</li>
				<li><b>Task Beschreibung</b>: Schaltet die Lampe im Bücherregal jeden Tag um 19 Uhr an.</li>
				<li><b>Aktiv</b>: Ja</li>
				<li><b>Event</b>: Timer</li>
				<li><b>Tage</b>: M,D,M,D,F,S,S</li>
				<li><b>Uhrzeit</b>: 19:00</li>
				<li><b>Aktion</b>: Schalten</li>
				<li><b>Status</b>: An</li>
			</ul>	
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
				//response = jQuery.parseJSON(data);
				console.log(data);
				
				$("#tasks_target option").each(function() {
					$(this).remove();
				});
				
				// Udate vendors
				$.each(response.result, function (key,val) {
					$('#tasks_target')
					 .append($("<option></option>")
					 .attr("value",val.id)
					 .text(val.clear_name)); 
				});
				
				$('#tasks_target').trigger('change');
			});	
		});
		  		
		// Validator
		$.validator.addMethod(
			"regex",
			function(value, element, regexp) {
				var check = false;
				var re = new RegExp(regexp);
				return this.optional(element) || re.test(value);
			},
			"Nur Kleinbuchstaben und Zahlen sowie '-' und '_' erlaubt."
		);
		
		$.validator.addMethod(
			"unique",
			function(value, element, id_type) {
				var response = null;
				// Check ID against API
				var request = {"jsonrpc": "2.0", "method": "idIsUnique", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"tools","opts":[value,id_type]}, "id": 1};
				$.ajax({
					url: "<?= base_url('api/request'); ?>",
					type: "post",
					data: JSON.stringify(request),
					dataType: "json",
					async: false,
					success: function(data) {
						response = data;
						console.log(response.result);
					} 
				});	
				if (response.result=="true") {
					return true;
				}
				else {
					return false;
				}
			},
			"Diese ID existiert bereits. Die ID muss eindeutig sein."
		);
		
		$('#add_task').validate(
		{
		rules: {
			tasks_name: {
			  minlength: 3,
			  maxlength: 200,
			  required: true,
			  regex: /^[a-z\d_-]+$/,
			  unique: "tasks"
			},
			tasks_clear_name: {
			  required: true,
			  maxlength: 200
			},
			tasks_description: {
			  required: true,
			  maxlength: 200
			},
			timer_time: {
			  required: true
			}
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
