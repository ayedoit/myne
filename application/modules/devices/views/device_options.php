<div class="row-fluid">
	<?php
	// Get Device Type Options
	$options = $this->device->getOptionsByDeviceID($device->id);

		echo "<ul class='inline'>";
		echo "<li><a class='btn btn-warning' href='".base_url('devices/edit/'.$device->name)."/on' title='Ändern'><i class='icon-pencil icon-white'></i> Ändern</a></li>";
		echo "<li><a class='btn btn-danger' href='".base_url('devices/delete/'.$device->name.'/confirm')."' title='Delete'><i class='icon-remove-circle icon-white'></i> Löschen</a></li>";
		
		// If "toggle" is set
		if (array_key_exists('toggle',$options)) {
		echo "<li>";
			echo '<div class="btn-group">';
			  echo "<a class='btn btn-success' href='".base_url('devices/toggle/device/'.$device->name)."/on' title='On'>On</a>";
			  echo "<a class='btn btn-danger' href='".base_url('devices/toggle/device/'.$device->name)."/off' title='Off'>Off</a>";
			echo '</div>';
		echo "</li>";
		}

	echo "</ul>";
	?>
</div>
