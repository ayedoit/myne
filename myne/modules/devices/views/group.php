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
					<td><a class="editable" id="<?= $group->name ?>-clear_name" data-type="text" data-pk="clear_name" data-url="<?php echo base_url(); ?>devices/update/group/<?= $group->name ?>" data-original-title="Name"><?= $group->clear_name ?></a></td>
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
					<td><a class="editable" id="<?= $group->name ?>-description" data-type="text" data-pk="description" data-url="<?php echo base_url(); ?>devices/update/group/<?= $group->name ?>" data-original-title="Beschreibung"><?= $group->description ?></a></td>
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
		?>
		<div class="btn-group">
		  <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
		    Gerät hinzufügen
		    <span class="caret"></span>
		  </a>
		  <ul class="dropdown-menu">
		    <?php
		    	$g_options = $this->device->getOptionsByGroup($group->id);

		    	$options = array();
		    	foreach ($g_options as $option) {
		    		$options[] = $option->id;
		    	}

		    	$devices = $this->device->getDevicesByOptions($options);

		    	foreach ($devices as $device) {
		    		// Check if device already has this group
		    		if (!$this->device->deviceHasGroup($group->id,$device->id)) {
		    			echo "<li><a class='href add_group_member' data-device_icon='".$device->icon."' data-device_name='".$device->name."' data-device_clear_name='".$device->clear_name."' data-device_id='".$device->id."' data-group_id='".$group->id."'><img width='20' height='20' src='".base_url('img/type_icons/'.$device->icon)."' class='pull-left devicelist-icon' />".$device->clear_name."</a></li>";
		    		}
		    	}
		    ?>
		  </ul>
		</div>
		<?php echo "<li><a class='btn btn-primary' href='".base_url('tasks/add/new/group/'.$group->name)."' title='Neuer Task'><i class='icon-plus icon-white'></i> Task</a></li>"; ?>
	<?php
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

		$(document).on('click', '.add_group_member', function() {
			var response = $(this).myne_api({
			  method: "addGroupMember",
			  params: {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model": "devices/device", "opts":{"group_id":$(this).data('group_id'),"device_id":$(this).data('device_id')}}
			});
			var r_value = jQuery.parseJSON(response.responseText);
			
			if (r_value.hasOwnProperty('error')) {
				$(this).myne_notify({
					"text":r_value.error.message,
					"class":"error"
				});
			}
			else {
				var append = "<li class='clearfix'><img width='20' height='20' src='<?= base_url('img/type_icons/'); ?>/"+$(this).data('device_icon')+"' class='pull-left devicelist-icon'><a class='pull-left' href='<?= base_url('devices/show/'); ?>/"+$(this).data('device_name')+"' title='"+$(this).data('device_clear_name')+"'>"+$(this).data('device_clear_name')+"</a><div class='pull-right'><a data-type='device' data-name='"+$(this).data('device_name')+"' class='toggle_on btn btn-mini btn-success' title='"+$(this).data('device_clear_name')+" anschalten.'><i class='icon-ok icon-white'></i></a>	<a data-type='device' data-name='"+$(this).data('device_name')+"' class='toggle_off btn btn-mini btn-danger' title='"+$(this).data('device_clear_name')+" ausschalten.'><i class='icon-off icon-white'></i></a></div></li>";
				$('.devicelist').append(append);
				$(this).myne_notify({
					"text":$(this).data('device_clear_name')+" hinzugefügt",
					"class":"success"
				});
				$(this).remove();
			}
		});
	});
</script>