<div class="row-fluid">
	<?php
		if (isset($gateway) && !empty($gateway)) {
			echo '<div class="span6 group">';
				echo '<span class="groupname">';	
					echo '<li class="dropdown">';
						echo '<a class="dropdown-toggle" role="button" data-toggle="dropdown">'.$gateway->clear_name.' <b class="caret"></b></a>';
						echo '<ul class="dropdown-menu">';
							echo "<li><a data-type='gateway' data-name='".$gateway->name."' class='toggle_on' title='An'><i class='icon-ok'></i> An</a></li>";
							echo "<li><a data-type='gateway' data-name='".$gateway->name."' class='toggle_off' title='Aus'><i class='icon-off'></i> Aus</a></li>";
						echo '</ul>';
					echo '</li>';
				echo '</span>';
				
				echo '<ul class="unstyled devicelist">';
					$this->load->model('devices/device');
					$devices = $this->device->getDevicesByGateway($gateway->id);
					if (sizeof($devices) > 0) {
						foreach ($devices as $device) {
							echo "<li class='clearfix'>";
								$type = $this->device->getTypeByID($device->type);
								echo "<img width='20' height='20' src='".base_url('img/type_icons/'.$type->icon)."' class='pull-left devicelist-icon' /> <a class='pull-left' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
								echo "<div class='pull-right'>";	
									// Options
									$options = $this->device->getOptionsByDeviceID($device->id);

									if (array_key_exists('toggle',$options)) {
									  echo "<a data-type='device' data-name='".$device->name."' class='toggle_on btn btn-small btn-success' title='".$device->clear_name." anschalten.' ><i class='icon-ok icon-white'></i></a>";
									  echo " <a data-type='device' data-name='".$device->name."' class='toggle_off btn btn-small btn-danger' title='".$device->clear_name." ausschalten.' ><i class='icon-off icon-white'></i></a>";
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
			// All Gateways
			echo "<h4>Gateways</h4>";
			$this->load->model('gateways/gateway');
			$gateways = $this->gateway->getGateways();
			
			if (sizeof($gateways) > 0) {
				foreach ($gateways as $gateway) {
					echo '<div class="span3 group">';
						echo '<span class="groupname">';
							echo '<li class="dropdown">';
								echo '<a class="dropdown-toggle" role="button" data-toggle="dropdown">'.$gateway->clear_name.' <b class="caret"></b></a>';
								echo '<ul class="dropdown-menu">';
									echo "<li><a data-type='gateway' data-name='".$gateway->name."' class='toggle_on' title='An'><i class='icon-ok'></i> An</a></li>";
									echo "<li><a data-type='gateway' data-name='".$gateway->name."' class='toggle_off' title='Aus'><i class='icon-off'></i> Aus</a></li>";
								echo '</ul>';
							echo '</li>';
						echo '</span>';
						
						echo '<ul class="unstyled devicelist">';
							// Get group members
							$this->load->model('devices/device');
							$devices = $this->device->getDevicesByGateway($gateway->id);
							if (sizeof($devices) > 0) {
								foreach ($devices as $device) {
									echo "<li class='clearfix'>";
										$type = $this->device->getTypeByID($device->type);
										echo "<img width='20' height='20' src='".base_url('img/type_icons/'.$type->icon)."' class='pull-left devicelist-icon' /> <a class='pull-left' href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a>";
										echo "<div class='pull-right'>";	
											// Options
											$options = $this->device->getOptionsByDeviceID($device->id);

											if (array_key_exists('toggle',$options)) {
											  echo "<a data-type='device' data-name='".$device->name."' class='toggle_on btn btn-small btn-success' title='".$device->clear_name." anschalten.' ><i class='icon-ok icon-white'></i></a>";
											  echo " <a data-type='device' data-name='".$device->name."' class='toggle_off btn btn-small btn-danger' title='".$device->clear_name." ausschalten.' ><i class='icon-off icon-white'></i></a>";
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
				echo "<div class='span3'><p class='lead'>Keine Gateways angelegt</p></div>";
			}
		}
	?>
</div>
