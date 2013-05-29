<div class="row-fluid">
	<div class="row-fluid">
		<p class="lead">
			Du bist dabei "<?php echo $group->clear_name; ?>" zu löschen.
		</p>
	</div>
	<div class="span4">
		<table class="table table-striped">	    
			
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
</div>
