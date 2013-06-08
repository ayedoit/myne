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
		echo form_label('Aktionen', 'groups_options',$attributes);
	?>
	<div class="controls">
	  <?php
		$options = array();
		$this->load->model('devices/device');

		// Get options
		$group_options = $this->device->getOptions();
		
		$selected = "1";
		foreach ($group_options as $option) {
			$options[$option->id] = $option->clear_name;
		}

		$data = 'id="groups_options"';
		echo form_multiselect('groups_options[]', $options,$selected,$data);
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

		// Get devices, start with option "toggle"
		$devices = $this->device->getDevicesByOptions(array(0 => "1"));

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
		$('#groups_options').change(function() {
			var options = $(this).val();
			var i = 0;
			var n_options = {};

			$.each(options, function(key,value) {
			  n_options[i] = value;
			  i++;
			});

			var response = "";
			
			// Get devices with selected options
			var request = {"jsonrpc": "2.0", "method": "getDevicesByOptions", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>","model":"devices/device","opts":[n_options]}, "id": 2};
			$.post("<?= base_url('api/request'); ?>", request, function(data) {
				
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