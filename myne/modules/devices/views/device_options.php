<div class="row-fluid">
	<?php
	// Get Device Type Options
	$device_type = $this->device->getTypeByID($device->type);

	echo "<ul class='inline'>";
		echo "<li><a class='btn btn-danger' href='".base_url('devices/delete/device/'.$device->name.'/confirm')."' title='Löschen'><i class='icon-remove-circle icon-white'></i> Löschen</a></li>";
		echo "<li><a class='btn btn-primary	' href='".base_url('tasks/add/new/device/'.$device->name)."' title='Neuer Task'><i class='icon-plus icon-white'></i> Task</a></li>";		
		echo "</li>";
	echo "</ul>";
	echo "<hr>";
	echo "<ul class='inline'>";
		$this->load->model('action');
		// If "set_status" is set
		if ($this->action->deviceHasAction($device->name,"set_status")) {
		echo "<li>";
		  echo "<li><span class='label label-info'>Schalten</span></li>";
		  echo "<a data-type='device' data-name='".$device->name."' class='toggle_on btn btn-success' title='".$device->clear_name." anschalten.' ><i class='icon-ok icon-white'></i></a> ";
		  echo "<a data-type='device' data-name='".$device->name."' class='toggle_off btn btn-danger' title='".$device->clear_name." anschalten.' ><i class='icon-off icon-white'></i></a>";
		echo "</li>";
		}

		// If "dim" is set
		if ($this->action->deviceHasAction($device->name,"dim")) {
		echo "<li>";
		  echo "<li><span class='label label-info'>Dimmen</span></li>";
		  echo "<a data-type='device' data-name='".$device->name."' class='dim_incr btn btn-success' title='".$device->clear_name." anschalten.' ><i class='icon-plus icon-white'></i></a> ";
		  echo "<a data-type='device' data-name='".$device->name."' class='dim_decr btn btn-danger' title='".$device->clear_name." anschalten.' ><i class='icon-minus icon-white'></i></a>";
		echo "</li>";
		}

	echo "</ul>";
	?>
</div>
