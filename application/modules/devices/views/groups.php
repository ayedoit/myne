<div class="row-fluid">
	<h4>Räume</h4>
	<?php
	$this->load->model('room');
	$rooms = $this->room->getRooms();	
	foreach ($rooms as $room) {
		echo '<div class="span3 well">';
			echo "<h5>".$room->clear_name."</h5>";
			echo "<ul class='unstyled'>";
				// Get group members
				$this->load->model('device');
				$devices = $this->device->getDevicesByRoom($room->id);
				foreach ($devices as $device) {
					$type = $this->device->getTypeByID($device->type);
					echo "<li><img width='24' height='24' src='".base_url('img/type_icons/'.$type->icon)."' /> <a href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a></li>";
				}
			echo "</ul>";
			
			echo $this->load->view('group_options', array('group' => $room,'group_type' => 'room'),true);
		echo "</div>";
	}
	?>
</div>

<div class="row-fluid">
	<h4>Gerätetypen</h4>
	<?php
	$this->load->model('device');
	$types = $this->device->getDeviceTypes();	
	foreach ($types as $type) {
		echo '<div class="span3 well">';
			echo "<h5>".$type->clear_name."</h5>";
			echo "<ul class='unstyled'>";
				// Get group members
				$this->load->model('device');
				$devices = $this->device->getDevicesByType($type->id);
				foreach ($devices as $device) {
					$type = $this->device->getTypeByID($device->type);
					echo "<li><img width='24' height='24' src='".base_url('img/type_icons/'.$type->icon)."' /> <a href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a></li>";
				}
			echo "</ul>";
			
			echo $this->load->view('group_options', array('group' => $type,'group_type' => 'type'),true);
		echo "</div>";
	}
	?>
</div>

<div class="row-fluid">	
	<h4>Statische Gruppen</h4>
	<?php
	$this->load->model('device');
	$groups = $this->device->getGroups();
	foreach ($groups as $group) {
		echo '<div class="span3 well">';
		echo "<h5>".$group->clear_name."</h5>";
		echo "<ul class='unstyled'>";
			// Get group members
			$this->load->model('device');
			$devices = $this->device->getDevicesByGroup($group->id);
			foreach ($devices as $device) {
				$type = $this->device->getTypeByID($device->type);
				echo "<li><img width='24' height='24' src='".base_url('img/type_icons/'.$type->icon)."' /> <a href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a></li>";
			}
		echo "</ul>";
		
		echo $this->load->view('group_options', array('group' => $group,'group_type' => 'group'),true);
		echo "</div>";
	}
	?>
</div>
