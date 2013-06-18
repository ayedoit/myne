<?php
	$this->load->helper('form');
?>
<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Gruppen-ID', 'groups_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'groups_name',
		  'id'          => 'groups_name',
		  'placeholder' => 'Gruppen-ID'
		);
		echo form_input($data);
	  ?>
	  <span class="validation_space"></span>
	</div>
</div>

<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Gruppen Name', 'groups_clear_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'groups_clear_name',
		  'id'          => 'groups_clear_name',
		  'placeholder' => 'Gruppen Name'
		);
		echo form_input($data);
	  ?>
	  <span class="validation_space"></span>
	</div>
</div>

<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Gruppen Beschreibung', 'groups_description',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'groups_description',
		  'id'          => 'groups_description',
		  'placeholder' => 'Gruppen Beschreibung'
		);
		echo form_input($data);
	  ?>
	  <span class="validation_space"></span>
	</div>
</div>

<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Aktionen', 'groups_actions',$attributes);
	?>
	<div class="controls">
	  <?php
		$options = array();
		$this->load->model('action');

		// Get actions
		$group_actions = $this->action->getActions();
		
		$selected = "1";
		foreach ($group_actions as $action) {
			$options[$action->id] = $action->clear_name;
		}

		$data = 'id="groups_actions"';
		echo form_multiselect('groups_actions[]', $options,$selected,$data);
	  ?>
	</div>
</div>

<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Geräte', 'groups_devices',$attributes);
	?>
	<div class="controls">
	  <?php
		$options = array();
		$this->load->model('devices/device');

		// Get devices, start with option "set_status"
		$devices = $this->device->getDevicesByActions(array(0 => "1"));

		$selected = "";
		foreach ($devices as $device) {
			$options[$device->id] = $device->clear_name;
		}
		$data = 'id="groups_devices" size="'.sizeof($devices).'"';
		echo form_multiselect('groups_devices[]', $options,$selected,$data);
	  ?>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#groups_actions').change(function() {
			var actions = $(this).val();
			var i = 0;
			var n_actions = {};

			$.each(actions, function(key,value) {
			  n_actions[i] = value;
			  i++;
			});

			var response = "";
			
			// Get devices with selected options
			var request = {"jsonrpc": "2.0", "method": "getDevicesByOptions", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>","model":"devices/device","opts":[n_actions]}, "id": 2};
			$.post("<?= base_url('api/request'); ?>", JSON.stringify(request), function(data) {
				
				$("#groups_devices option").each(function() {
					$(this).remove();
				});

				// Udate Devices
				$.each(data.result, function (key,val) {
					$('#groups_devices')
					 .append($("<option></option>")
					 .attr("value",val.id)
					 .text(val.clear_name)); 
				});
				
				$('#groups_devices').trigger('change');
			});	
		});
	});
</script>