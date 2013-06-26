<div class="row-fluid span6">
	<?php
		$this->load->model('devices/device');
		if (isset($group) && !empty($group)) {
			echo '<div class="span12 group">';
				echo '<span class="groupname">';
					echo '<li class="dropdown">';
						echo '<a class="dropdown-toggle" role="button" data-toggle="dropdown">'.$group->clear_name.' <b class="caret"></b></a>';
						echo '<ul class="dropdown-menu">';
							$this->load->model('action');
							if ($this->action->groupHasAction($group->name,'set_status')) {	
								echo "<li><a data-type='group' data-name='".$group->name."' class='toggle_on' title='An'><i class='icon-ok'></i> An</a></li>";
								echo "<li><a data-type='group' data-name='".$group->name."' class='toggle_off' title='Aus'><i class='icon-off'></i> Aus</a></li>";
								echo '<li class="divider"></li>';
							}
							echo '<li class="nav-header">Verwaltung</li>';
							echo '<li><a href="'.base_url("devices/showgroup/").'/'.$group->name.'"><i class="icon-share-alt"></i> Gruppe anzeigen</a></li>';
						echo '</ul>';
					echo '</li>';
				echo '</span>';
				
				echo '<ul class="unstyled devicelist">';
					$devices = $this->device->getDevicesByGroup($group->id);
					if (sizeof($devices) > 0) {
						foreach ($devices as $device) {
							echo "<li class='clearfix'>";
								$type = $this->device->getTypeByID($device->type);
								echo "<img width='20' height='20' src='".base_url('img/type_icons/'.$device->icon)."' class='pull-left devicelist-icon' /> <a class='pull-left' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
								echo "<div class='pull-right'>";	
									// Options
									if ($this->action->deviceHasAction($device->name,"set_status")) {
									  echo "<a data-type='device' data-name='".$device->name."' class='toggle_on btn btn-mini btn-success' title='".$device->clear_name." anschalten.' ><i class='icon-ok icon-white'></i></a>";
									  echo " <a data-type='device' data-name='".$device->name."' class='toggle_off btn btn-mini btn-danger' title='".$device->clear_name." ausschalten.' ><i class='icon-off icon-white'></i></a>";
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
			// All Groups
			echo "<h4>Gruppen</h4>";
			$this->load->model('devices/device');
			$groups = $this->device->getGroups();
			
			if (sizeof($groups) > 0) {
				foreach ($groups as $group) {
					echo '<div class="span5 group">';
						echo '<span class="groupname">';
							echo '<li class="dropdown">';
								echo '<a class="dropdown-toggle" role="button" data-toggle="dropdown">'.$group->clear_name.' <b class="caret"></b></a>';
								echo '<ul class="dropdown-menu">';
									$this->load->model('action');
									if ($this->action->groupHasAction($group->name,'set_status')) {	
										echo "<li><a data-type='group' data-name='".$group->name."' class='toggle_on' title='An'><i class='icon-ok'></i> An</a></li>";
										echo "<li><a data-type='group' data-name='".$group->name."' class='toggle_off' title='Aus'><i class='icon-off'></i> Aus</a></li>";
										echo '<li class="divider"></li>';
									}
									echo '<li class="nav-header">Verwaltung</li>';
									echo '<li><a href="'.base_url("devices/showgroup/").'/'.$group->name.'"><i class="icon-share-alt"></i> Gruppe anzeigen</a></li>';
								echo '</ul>';
							echo '</li>';
						echo '</span>';
						
						echo '<ul class="unstyled devicelist">';
							// Get group members
							$this->load->model('devices/device');
							$devices = $this->device->getDevicesByGroup($group->id);
							if (sizeof($devices) > 0) {
								foreach ($devices as $device) {
									echo "<li class='clearfix'>";
										$type = $this->device->getTypeByID($device->type);
										echo "<img width='20' height='20' src='".base_url('img/type_icons/'.$device->icon)."' class='pull-left devicelist-icon' /> <a class='pull-left' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
										echo "<div class='pull-right'>";	
											// Options
											if ($this->action->deviceHasAction($device->name,"set_status")) {
											  echo "<a data-type='device' data-name='".$device->name."' class='toggle_on btn btn-mini btn-success' title='".$device->clear_name." anschalten.' ><i class='icon-ok icon-white'></i></a>";
											  echo " <a data-type='device' data-name='".$device->name."' class='toggle_off btn btn-mini btn-danger' title='".$device->clear_name." ausschalten.' ><i class='icon-off icon-white'></i></a>";
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
				echo "<div class='span3'><a class='btn btn-primary' href='/devices/addgroup/new' title='Gruppe anlegen'><i class='icon-plus icon-white'></i> Gruppe</a></div>";			
			}
		}
	?>
</div>
