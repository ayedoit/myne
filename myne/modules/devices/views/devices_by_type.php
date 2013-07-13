<div class="row-fluid span6">
	<?php
		$this->load->model('action');
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
								echo '<div class="btn-group">';

									$type = $this->device->getTypeByID($device->type);
		
									// Options
									// Check if there are more actions than just "set_status" since we will need a button group then
									$actions = $this->action->getActionsByDevice($device->id);

									if (sizeof($actions) != 0) {
										$i = 0;	
										foreach($actions as $action) {
											// Check which action it is
											if ($action->name == 'set_status') {
												echo "<a title='Klicken für AN, halten für AUS' data-type='device' data-name='".$device->name."' class='set_status btn' title='".$device->clear_name."' ><img width='20' height='20' class='pull-left ' src='".base_url('img/type_icons/'.$device->icon)."' /></a>";
											}
											
											if ($i == 0) {
												echo "<a class='btn' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
											}
											$i++;

											if($action->name == 'dim') {
												// We need a button group
												  echo "<a data-type='device' data-action='dim' data-status='incr' data-name='".$device->name."' class='trigger_action btn btn-success' title='".$device->clear_name."' ><i class='icon-plus icon-white'></i></a>";
												  echo "<a data-type='device' data-action='dim' data-status='decr' data-name='".$device->name."' class='trigger_action btn btn-danger' title='".$device->clear_name."' ><i class='icon-minus icon-white'></i></a>";
											}
										}
									}
									else {
										echo "<a disabled data-type='device' data-name='".$device->name."' class='btn' title='".$device->clear_name."' ><img width='20' height='20' class='pull-left ' src='".base_url('img/type_icons/'.$device->icon)."' /></a>";
										echo "<a class='btn' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
									}
								echo '</div>';
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
										echo '<div class="btn-group">';

											$type = $this->device->getTypeByID($device->type);
				
											// Options
											// Check if there are more actions than just "set_status" since we will need a button group then
											$actions = $this->action->getActionsByDevice($device->id);

											if (sizeof($actions) != 0) {
												$i = 0;	
												foreach($actions as $action) {
													// Check which action it is
													if ($action->name == 'set_status') {
														echo "<a title='Klicken für AN, halten für AUS' data-type='device' data-name='".$device->name."' class='set_status btn' title='".$device->clear_name."' ><img width='20' height='20' class='pull-left ' src='".base_url('img/type_icons/'.$device->icon)."' /></a>";
													}
													
													if ($i == 0) {
														echo "<a class='btn' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
													}
													$i++;

													if($action->name == 'dim') {
														// We need a button group
														  echo "<a data-type='device' data-action='dim' data-status='incr' data-name='".$device->name."' class='trigger_action btn btn-success' title='".$device->clear_name."' ><i class='icon-plus icon-white'></i></a>";
														  echo "<a data-type='device' data-action='dim' data-status='decr' data-name='".$device->name."' class='trigger_action btn btn-danger' title='".$device->clear_name."' ><i class='icon-minus icon-white'></i></a>";
													}
												}
											}
											else {
												echo "<a disabled data-type='device' data-name='".$device->name."' class='btn' title='".$device->clear_name."' ><img width='20' height='20' class='pull-left ' src='".base_url('img/type_icons/'.$device->icon)."' /></a>";
												echo "<a class='btn' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
											}
										echo '</div>';
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
