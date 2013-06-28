<div class="row-fluid span6">
	<?php
		if (isset($type) && !empty($type)) {
			echo '<div class="span12 group">';
				echo '<span class="groupname">';	
					echo '<li class="dropdown">';
						$this->load->model('action');
						if ($this->action->deviceTypeHasAction($type->name,'set_status')) {	
							echo '<a class="dropdown-toggle" role="button" data-toggle="dropdown">'.$type->clear_name.' <b class="caret"></b></a>';
							echo '<ul class="dropdown-menu">';
								echo "<li><a data-type='type' data-name='".$type->name."' class='toggle_on' title='An'><i class='icon-ok'></i> An</a></li>";
								echo "<li><a data-type='type' data-name='".$type->name."' class='toggle_off' title='Aus'><i class='icon-off'></i> Aus</a></li>";
							echo '</ul>';
						}
						else {
							echo $type->clear_name;
						}
					echo '</li>';
				echo '</span>';
				
				echo '<ul class="unstyled devicelist">';
					$this->load->model('devices/device');
					$devices = $this->device->getDevicesByType($type->id);
					if (sizeof($devices) > 0) {
						foreach ($devices as $device) {
							echo "<li class='clearfix'>";
								$type = $this->device->getTypeByID($device->type);
								echo "<img width='20' height='20' src='".base_url('img/type_icons/'.$device->icon)."' class='pull-left devicelist-icon' /> <a class='pull-left' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
								echo "<div class='pull-right'>";	
									// Options
									// Check if there are more actions than just "set_status" since we will need a button group then
									$actions = $this->action->getActionsByDevice($device->id);

									if (sizeof($actions) != 0) {	
										echo '<div class="btn-group">';	
										foreach($actions as $action) {
											// Check which action it is
											if ($action->name == 'set_status') {
												// We only need one button with tapclick
												echo "<a data-type='device' data-name='".$device->name."' class='set_status btn btn-mini btn-info' title='".$device->clear_name."' ><i class='icon-off icon-white'></i></a>";
											}
											elseif($action->name == 'dim') {
												// We need a button group
												  echo "<a data-type='device' data-action='dim' data-status='incr' data-name='".$device->name."' class='trigger_action btn btn-mini btn-success' title='".$device->clear_name."' ><i class='icon-plus icon-white'></i></a>";
												  echo "<a data-type='device' data-action='dim' data-status='decr' data-name='".$device->name."' class='trigger_action btn btn-mini btn-danger' title='".$device->clear_name."' ><i class='icon-minus icon-white'></i></a>";
											}
										}
										echo '</div>';
									}
								echo "</div>";
							echo "</li>";
						}
					} 
					else {
						echo "<p>Keine Geräte gefunden</p>";
					}
				echo '</ul>';
			echo "</div>";
		}
		else {
			// All Rooms
			echo "<h4>Gerätetypen</h4>";
			$this->load->model('devices/device');
			$types = $this->device->getDeviceTypes();
			
			if (sizeof($types) > 0) {
				foreach ($types as $type) {
					echo '<div class="span5 group">';
						echo '<span class="groupname">';
							echo '<li class="dropdown">';
								$this->load->model('action');
								if ($this->action->deviceTypeHasAction($type->name,'set_status')) {	
									echo '<a class="dropdown-toggle" role="button" data-toggle="dropdown">'.$type->clear_name.' <b class="caret"></b></a>';
									echo '<ul class="dropdown-menu">';
										echo "<li><a data-type='type' data-name='".$type->name."' class='toggle_on' title='An'><i class='icon-ok'></i> An</a></li>";
										echo "<li><a data-type='type' data-name='".$type->name."' class='toggle_off' title='Aus'><i class='icon-off'></i> Aus</a></li>";
									echo '</ul>';
								}
								else {
									echo $type->clear_name;
								}
							echo '</li>';
						echo '</span>';
						
						echo '<ul class="unstyled devicelist">';
							// Get group members
							$this->load->model('devices/device');
							$devices = $this->device->getDevicesByType($type->id);
							if (sizeof($devices) > 0) {
								foreach ($devices as $device) {
									echo "<li class='clearfix'>";
										$type = $this->device->getTypeByID($device->type);
										echo "<img width='20' height='20' src='".base_url('img/type_icons/'.$device->icon)."' class='pull-left devicelist-icon' /> <a class='pull-left' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
										echo "<div class='pull-right'>";	
											// Options
											// Check if there are more actions than just "set_status" since we will need a button group then
											$actions = $this->action->getActionsByDevice($device->id);

											if (sizeof($actions) != 0) {	
												echo '<div class="btn-group">';	
												foreach($actions as $action) {
													// Check which action it is
													if ($action->name == 'set_status') {
														// We only need one button with tapclick
														echo "<a data-type='device' data-name='".$device->name."' class='set_status btn btn-mini btn-info' title='".$device->clear_name."' ><i class='icon-off icon-white'></i></a>";
													}
													elseif($action->name == 'dim') {
														// We need a button group
														  echo "<a data-type='device' data-action='dim' data-status='incr' data-name='".$device->name."' class='trigger_action btn btn-mini btn-success' title='".$device->clear_name."' ><i class='icon-plus icon-white'></i></a>";
														  echo "<a data-type='device' data-action='dim' data-status='decr' data-name='".$device->name."' class='trigger_action btn btn-mini btn-danger' title='".$device->clear_name."' ><i class='icon-minus icon-white'></i></a>";
													}
												}
												echo '</div>';
											}
										echo "</div>";
									echo "</li>";
								}
							} 
							else {
								echo "<p>Keine Geräte gefunden</p>";
							}
						echo '</ul>';
					echo "</div>";
				}
			}
			else {
				echo "<div class='span3'><p>Keine Gerätetypen angelegt</p></div>";
			}
		}
	?>
</div>
