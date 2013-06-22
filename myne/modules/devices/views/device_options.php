<div class="row-fluid">
	<?php
	// Get Device Type Options
	$device_type = $this->device->getTypeByID($device->type);

		echo "<ul class='inline'>";
		echo "<li><a class='btn btn-danger' href='".base_url('devices/delete/device/'.$device->name.'/confirm')."' title='Löschen'><i class='icon-remove-circle icon-white'></i> Löschen</a></li>";
		echo "<li><a class='btn btn-primary	' href='".base_url('tasks/add/new/device/'.$device->name)."' title='Neuer Task'><i class='icon-plus icon-white'></i> Task</a></li>";		
		echo "<hr>";
		
		// If "toggle" is set
		$this->load->model('action');
		if ($this->action->deviceHasAction($device->name,"set_status")) {
		echo "<li>";
		  echo "<a data-type='device' data-name='".$device->name."' class='toggle_on btn btn-success' title='".$device->clear_name." anschalten.' ><i class='icon-ok icon-white'></i></a> ";
		  echo "<a data-type='device' data-name='".$device->name."' class='toggle_off btn btn-danger' title='".$device->clear_name." anschalten.' ><i class='icon-off icon-white'></i></a>";
		echo "</li>";
		}

	echo "</ul>";
	?>
</div>
