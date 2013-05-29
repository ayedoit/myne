<div class="row-fluid">
	<div class="row-fluid">
		<p class="lead">
			Du bist dabei "<?php echo $room->clear_name; ?>" zu löschen.
		</p>
	</div>
	<div class="span4">
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
					<td><?= $room->description ?></td>
				</tr>
		    <?php
			}
			?>
		</table>
	</div>
</div>
