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

			<tr>
				<td><b>Gruppenaktionen</b></td>
				<td>
					<li class="dropdown group_dropdown">
					<?php
						$this->load->model('devices/device');
						$group_options = $this->device->getOptionsByGroup($group->id);
						$option_count = sizeof($group_options);
						
						$options = $this->device->getOptions();
					?>
					<a class="dropdown-toggle" data-toggle="dropdown"><span class="option_count"><?= $option_count ?></span> Aktion(en) <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="nav-header">Mögl. Aktionen</li>
							<?php
								foreach ($options as $option) {
									// Check if device already has this option
									if ($this->device->groupHasOption($group->name,$option->name)) {
										echo '<li><a id="option-'.$option->id.'" data-group="'.$group->id.'" data-id="'.$option->id.'" class="remove_option"><i class="indicator icon-ok"></i> '.$option->clear_name.'</a></li>';
									}
									else {
										echo '<li><a id="option-'.$option->id.'" data-group="'.$group->id.'" data-id="'.$option->id.'" class="add_option"><i class="indicator"></i> '.$option->clear_name.'</a></li>';
									}
								}
							?>
						</ul>
					</li>
				</td>
			</tr>	
		</table>
	</div>
	
	<div class="span6">
		<?php
			$this->load->view('devices/devices_by_group',array('group' => $group));
		?>
	</div>
</div>

<div class="row-fluid">
	<?php
	echo "<ul class='inline'>";
		echo "<li><a class='btn btn-danger' href='".base_url('devices/delete/group/'.$group->name.'/confirm')."' title='Löschen'><i class='icon-remove-circle icon-white'></i> Löschen</a></li>";
	echo "</ul>";
	?>
</div>
<script>
	$(document).ready(function() {
		$('.remove_option').click(function() {
			$(this).myne_api({
			  method: "removeGroupOption",
			  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "devices/device", "opts":{"group_id":$(this).data('group'),"option_id":$(this).data('id')}}
			});
			$('#option-'+$(this).data('id')+' i.indicator').toggleClass('icon-ok');
			var value = parseInt($('.option_count').text());
			$('.option_count').text(value-1);
		});
		
		$('.add_option').click(function() {
			$(this).myne_api({
			  method: "addGroupOption",
			  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "devices/device", "opts":{"group_id":$(this).data('group'),"option_id":$(this).data('id')}}
			});
			$('#option-'+$(this).data('id')+' i.indicator').toggleClass('icon-ok');
			var value = parseInt($('.option_count').text());
			$('.option_count').text(value+1);
		});
	});
</script>