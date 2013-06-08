<div class="row-fluid span6">
	<?php
		if (isset($room) && !empty($room)) {
			echo '<div class="span12 group">';
				echo '<span class="groupname">';	
					echo '<li class="dropdown">';
						echo '<a class="dropdown-toggle" role="button" data-toggle="dropdown">'.$room->clear_name.' <b class="caret"></b></a>';
						echo '<ul class="dropdown-menu">';
							echo "<li><a data-type='room' data-name='".$room->name."' class='toggle_on' title='An'><i class='icon-ok'></i> An</a></li>";
							echo "<li><a data-type='room' data-name='".$room->name."' class='toggle_off' title='Aus'><i class='icon-off'></i> Aus</a></li>";
							echo '<li class="divider"></li>';
							echo '<li class="nav-header">Verwaltung</li>';
							echo '<li><a href="'.base_url("rooms/show").'/'.$room->name.'"><i class="icon-share-alt"></i> Raum anzeigen</a></li>';
						echo '</ul>';
					echo '</li>';
				echo '</span>';
				
				echo '<ul class="unstyled devicelist">';
					$this->load->model('devices/device');
					$devices = $this->device->getDevicesByRoom($room->id);
					if (sizeof($devices) > 0) {
						foreach ($devices as $device) {
							echo "<li class='clearfix'>";
								$type = $this->device->getTypeByID($device->type);
								echo "<img width='20' height='20' src='".base_url('img/type_icons/'.$device->icon)."' class='pull-left devicelist-icon' /> <a class='pull-left' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
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
			echo "<h4>Räume</h4>";
			$this->load->model('room');
			$rooms = $this->room->getRooms();
			
			if (sizeof($rooms) > 0) {
				foreach ($rooms as $room) {
					echo '<div class="span5 group">';
						echo '<span class="groupname">';
							echo '<li class="dropdown">';
								echo '<a class="dropdown-toggle" role="button" data-toggle="dropdown">'.$room->clear_name.' <b class="caret"></b></a>';
								echo '<ul class="dropdown-menu">';
									echo "<li><a data-type='room' data-name='".$room->name."' class='toggle_on' title='An'><i class='icon-ok'></i> An</a></li>";
									echo "<li><a data-type='room' data-name='".$room->name."' class='toggle_off' title='Aus'><i class='icon-off'></i> Aus</a></li>";
									echo '<li class="divider"></li>';
									echo '<li class="nav-header">Verwaltung</li>';
									echo '<li><a href="'.base_url("rooms/show").'/'.$room->name.'"><i class="icon-share-alt"></i> Raum anzeigen</a></li>';
								echo '</ul>';
							echo '</li>';
						echo '</span>';
						
						echo '<ul class="unstyled devicelist">';
							// Get group members
							$this->load->model('devices/device');
							$devices = $this->device->getDevicesByRoom($room->id);
							if (sizeof($devices) > 0) {
								foreach ($devices as $device) {
									echo "<li class='clearfix'>";
										$type = $this->device->getTypeByID($device->type);
										echo "<img width='20' height='20' src='".base_url('img/type_icons/'.$device->icon)."' class='pull-left devicelist-icon' /> <a class='pull-left' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
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
				echo "<div class='span3'><p class='lead'>Keine Räume angelegt</p></div>";
			}
			
			// Devices without a room
			$this->load->model('devices/device');
			$devices_wo = $this->device->getDevicesWithoutRoom();
			if (sizeof($devices_wo) > 0) {
				echo '<div class="span3 group">';
					echo '<span class="groupname">';
						echo "Geräte ohne Raum";
					echo '</span>';
					
					echo '<ul class="unstyled devicelist">';
						foreach ($devices_wo as $device) {
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
					echo '</ul>';
				echo "</div>";
			} 
		}
	?>
</div>
