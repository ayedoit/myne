<div class="row-fluid">
	<div class="span4">
		<h3>Gruppeninformationen</h3>
		<table class="table table-striped">
    		<?php
			// Get Name
			if (isset($group->clear_name) && trim($group->clear_name) != '') {
				?>
				<tr>
					<td><b>Name</b></td>
					<td><?= $group->clear_name ?></td>
				</tr>
		    <?php
			}
			?>
    		
			<?php
			// Get Description
			if (isset($group->description) && trim($group->description) != '') {
				?>
				<tr>
					<td><b>Beschreibung</b></td>
					<td><?= $group->description ?></td>
				</tr>
		    <?php
			}
			?>
		</table>
	</div>
	
	<div class="span6">
		<?php
			$this->load->view('devices/devices_by_group',array('group' => $group));
		?>
	</div>
</div>
