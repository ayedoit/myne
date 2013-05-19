<div class="row-fluid">
	<div class="span4">
		<table class="table table-striped">
			<tr>
				<?php
				// Get Type-Data
				$this->load->model('device');
				$type = $this->device->getTypeByID($device->type);
				?>
				<td><b>Typ</b></td>
				<td><?= $type->clear_name ?></td>
			</tr>
		    <tr>
				<?php
				// Get Vendor-Data
				$this->load->model('devices/vendor');
				$vendor = $this->vendor->getVendorByID($device->vendor);
				?>
				<td><b>Hersteller</b></td>
				<td><?= $vendor->clear_name ?></td>
		    </tr>
		    <tr>
				<?php
				// Get Model-Data
				$this->load->model('model');
				$model = $this->model->getModelByID($device->model);
				?>
				<td><b>Modell</b></td>
				<td><?= $model->clear_name ?></td>
		    </tr>
		    
		    <tr>
				<?php
				// Get Room
				$this->load->model('room');
				$room = $this->room->getRoomByID($device->room);
				?>
				<td><b>Raum</b></td>
				<td><a href="<?= base_url('rooms/show/'.$room->name) ?>" title="<?= $room->clear_name ?>"><?= $room->clear_name ?></a></td>
		    </tr>
		    
			<?php
			// Get Group
			if (isset($device->group) && trim($device->group) != '' && $device->group != 0) {
				$group = $this->device->getGroupByID($device->group);
				?>
				<tr>
					<td><b>Gruppe</b></td>
					<td><a href="<?= base_url('devices/groups/'.$group->name) ?>" title="<?= $group->clear_name ?>"><?= $group->clear_name ?></a></td>
				</tr>
		    <?php
			}
			?>
		    
		    
		    <?php
			// Get Master DIP
			if (isset($device->masterdip) && trim($device->masterdip) != '') {
				?>
				<tr>
					<td><b>Master DIP</b></td>
					<td><?= $device->masterdip ?></td>
				</tr>
		    <?php
			}
			?>
		    
		    <?php
			// Get Slave DIP
			if (isset($device->slavedip) && trim($device->slavedip) != '') {
				?>
				<tr>
					<td><b>Slave DIP</b></td>
					<td><?= $device->slavedip ?></td>
				</tr>
		    <?php
			}
			?>
			
			<?php
			// Get Address
			if (isset($device->address) && trim($device->address) != '') {
				?>
				<tr>
					<td><b>Adresse</b></td>
					<td><?= $device->address ?></td>
				</tr>
		    <?php
			}
			?>
		</table>
	</div>
</div>
