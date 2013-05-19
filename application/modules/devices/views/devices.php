<div class="row-fluid">
	<?php
		echo "<ul class='unstyled'>";
		foreach ($devices as $device) {
			$this->load->model('device');
			$type = $this->device->getTypeByID($device->type);
				echo "<li><img width='24' height='24' src='".base_url('img/type_icons/'.$type->icon)."' /> <a href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a></li>";
				
		}
		echo "</ul>";
	?>
</div>
