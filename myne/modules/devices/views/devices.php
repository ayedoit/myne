<div class="row-fluid">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>Aktion</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($devices as $device) {
				echo "<tr>";
				// Type
				$this->load->model('device');
				$type = $this->device->getTypeByID($device->type);

				// Options
				$options = $this->device->getOptionsByDeviceID($device->id);	
					
					echo "<td><p class='lead'><a href='".base_url('devices/show/'.$device->name)."' title='".$device->clear_name."'>".$device->clear_name."</a></p></td>";
					echo "<td>";
						echo '<div class="btn-group">';
						if (array_key_exists('toggle',$options)) {
						  echo "<a data-type='device' data-name='".$device->name."' class='toggle_on btn btn-large btn-success' title='On'>On</a>";
						  echo " <a data-type='device' data-name='".$device->name."' class='toggle_off btn btn-large btn-danger' title='Off'>Off</a>";
						}
						echo '</div>';
					echo "</td>";
				
				echo "</tr>";
			}	
		?>
		</tbody>
	</table>
</div>
