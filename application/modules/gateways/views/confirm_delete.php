<div class="row-fluid">
	<div class="row-fluid">
		<p class="lead">
			Du bist dabei "<?php echo $gateway->clear_name; ?>" zu löschen.
		</p>
	</div>
	<div class="span4">
		<table class="table table-striped">
			<tr>
				<?php
				// Get Type-Data
				$this->load->model('gateways/gateway');
				$type = $this->gateway->getGatewayTypeByID($gateway->type);
				?>
				<td><b>Typ</b></td>
				<td><?= $type->clear_name ?></td>
			</tr>
		    
		    <tr>
				<?php
				// Get Room
				$this->load->model('room');
				$room = $this->room->getRoomByID($gateway->room);
				?>
				<td><b>Raum</b></td>
				<td><a href="<?= base_url('rooms/show/'.$room->name) ?>" title="<?= $room->clear_name ?>"><?= $room->clear_name ?></a></td>
		    </tr>    
		    
		    <?php
			// Get Address
			if (isset($gateway->address) && trim($gateway->address) != '') {
				?>
				<tr>
					<td><b>Adresse</b></td>
					<td><?= $gateway->address ?></td>
				</tr>
		    <?php
			}
			?>
		    
		    <?php
			// Get Port
			if (isset($gateway->port) && trim($gateway->port) != '') {
				?>
				<tr>
					<td><b>Port</b></td>
					<td><?= $gateway->port ?></td>
				</tr>
		    <?php
			}
			?>
		</table>
	</div>
</div>
