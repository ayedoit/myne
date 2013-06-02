<div class="row-fluid">
	<?php
		if (isset($type) && !empty($type)) {
			echo '<div class="span6 group">';
				echo '<span class="groupname">';	
					echo '<li class="dropdown">';
						echo '<a class="dropdown-toggle" role="button" data-toggle="dropdown">'.$type->clear_name.' <b class="caret"></b></a>';
						echo '<ul class="dropdown-menu">';
							echo "<li><a data-type='type' data-name='".$type->name."' class='toggle_on' title='An'><i class='icon-ok'></i> An</a></li>";
							echo "<li><a data-type='type' data-name='".$type->name."' class='toggle_off' title='Aus'><i class='icon-off'></i> Aus</a></li>";
						echo '</ul>';
					echo '</li>';
				echo '</span>';
				
				echo '<ul class="unstyled devicelist">';
					$this->load->model('devices/device');
					$devices = $this->device->getDevicesByType($type->id);
					if (sizeof($devices) > 0) {
						foreach ($devices as $device) {
							echo "<li class='clearfix'>";
								$type = $this->device->getTypeByID($device->type);
								echo "<img width='20' height='20' src='".base_url('img/type_icons/'.$type->icon)."' class='pull-left devicelist-icon' /> <a class='pull-left' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
								echo "<div class='pull-right'>";	
									// Options
									if ($this->device->deviceHasOption($device->name,"toggle")) {
									  echo "<a data-type='device' data-name='".$device->name."' class='toggle_on btn btn-mini btn-success' title='".$device->clear_name." anschalten.' ><i class='icon-ok icon-white'></i></a>";
									  echo " <a data-type='device' data-name='".$device->name."' class='toggle_off btn btn-mini btn-danger' title='".$device->clear_name." ausschalten.' ><i class='icon-off icon-white'></i></a>";
									}
								echo "</div>";
							echo "</li>";
						}
					} 
					else {
						echo "<p class='lead'>Keine Geräte gefunden</p>";
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
					echo '<div class="span3 group">';
						echo '<span class="groupname">';
							echo '<li class="dropdown">';
								echo '<a class="dropdown-toggle" role="button" data-toggle="dropdown">'.$type->clear_name.' <b class="caret"></b></a>';
								echo '<ul class="dropdown-menu">';
									echo "<li><a data-type='type' data-name='".$type->name."' class='toggle_on' title='An'><i class='icon-ok'></i> An</a></li>";
									echo "<li><a data-type='type' data-name='".$type->name."' class='toggle_off' title='Aus'><i class='icon-off'></i> Aus</a></li>";
								echo '</ul>';
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
										echo "<img width='20' height='20' src='".base_url('img/type_icons/'.$type->icon)."' class='pull-left devicelist-icon' /> <a class='pull-left' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
										echo "<div class='pull-right'>";	
											// Options
											if ($this->device->deviceHasOption($device->name,"toggle")) {
											  echo "<a data-type='device' data-name='".$device->name."' class='toggle_on btn btn-mini btn-success' title='".$device->clear_name." anschalten.' ><i class='icon-ok icon-white'></i></a>";
											  echo " <a data-type='device' data-name='".$device->name."' class='toggle_off btn btn-mini btn-danger' title='".$device->clear_name." ausschalten.' ><i class='icon-off icon-white'></i></a>";
											}
										echo "</div>";
									echo "</li>";
								}
							} 
							else {
								echo "<p class='lead'>Keine Geräte gefunden</p>";
							}
						echo '</ul>';
					echo "</div>";
				}
			}
			else {
				echo "<div class='span3'><p class='lead'>Keine Gerätetypen angelegt</p></div>";
			}
		}
	?>
</div>
