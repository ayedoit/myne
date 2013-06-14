<div class="row-fluid">
	<div class="span4">
		<h3>Rauminformationen</h3>
		<table class="table table-striped">
    		<?php
			// Get Name
			if (isset($room->clear_name) && trim($room->clear_name) != '') {
				?>
				<tr>
					<td><b>Name</b></td>
					<td><?= $room->clear_name ?></td>
				</tr>
		    <?php
			}
			?>
    		
			<?php
			// Get Description
			if (isset($room->description) && trim($room->description) != '') {
				?>
				<tr>
					<td><b>Beschreibung</b></td>
					<td><a class="editable" id="<?= $room->name ?>-description" data-type="text" data-pk="description" data-url="<?php echo base_url(); ?>rooms/update/<?= $room->name ?>" data-original-title="Beschreibung"><?= $room->description ?></a></td>
				</tr>
		    <?php
			}
			?>
		</table>
	</div>
	
	<div class="span6">
		<?php
			$this->load->view('devices/devices_by_room',array('room' => $room));
		?>
	</div>
</div>
<div class="row-fluid">
	<?php
	echo "<ul class='inline'>";
		echo "<li><a class='btn btn-danger' href='".base_url('rooms/delete/'.$room->name.'/confirm')."' title='Löschen'><i class='icon-remove-circle icon-white'></i> Löschen</a></li>";
	echo "</ul>";
	?>
</div>
