<?php
	$this->load->helper('form');
?>
<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Gateway-ID', 'gateways_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'gateways_name',
		  'id'          => 'gateways_name',
		  'placeholder' => 'Gateway-ID'
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
		echo form_label('Gateway Name', 'gateways_clear_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'gateways_clear_name',
		  'id'          => 'gateways_clear_name',
		  'placeholder' => '49880'
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
		echo form_label('Gateway Beschreibung', 'gateways_description',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'gateways_description',
		  'id'          => 'gateways_description',
		  'placeholder' => 'Gateway Beschreibung'
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
		echo form_label('Geräte Icon', 'gateways_icon',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'gateways_icon',
		  'placeholder' => 'Gateway Icon'
		);

		$icons = $this->tools->getIconsByType('gateway');
		$count = 1;
		foreach($icons as $icon) {
			echo '<label class="radio inline iconpicker">';
				echo '<input type="radio" name="gateways_icon" class="gateways_icon"';
				if ($count == 1) {
					echo " checked";
				}
				echo ' value="'.$icon.'"> <img width="20" height="20" src="'.base_url('img/type_icons')."/".$icon.'" />';
			echo '</label>';

			if ($count%4 == 0) {
				echo "<br />";
			}
			$count++;
		}
		
	  ?>
	  <span class="validation_space"></span>
	</div>
</div>

<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Gateway Typ', 'gateways_type',$attributes);
	?>
	<div class="controls">
	  <?php
		$this->load->model('gateway');
		$gateway_types = $this->gateway->getGatewayTypes();
		
		$options = array();
		foreach ($gateway_types as $gateway_type) {
			$options[$gateway_type->id] = $gateway_type->clear_name;
		}
		$data = 'id="gateways_type"';
		echo form_dropdown('gateways_type', $options,"1",$data);
	  ?>
	</div>
</div>

<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Gateway Adresse', 'gateways_address',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'gateways_address',
		  'id'          => 'gateways_address',
		  'placeholder' => 'Gateway Adresse'
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
		echo form_label('Gateway Port', 'gateways_port',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'gateways_port',
		  'id'          => 'gateways_port',
		  'placeholder' => 'Gateway Port'
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
		echo form_label('Gateway Raum', 'gateways_room',$attributes);
	?>
	
	<div class="controls">
	  <?php
		$this->load->model('room');
		$rooms = $this->room->getRooms();
		
		$options = array();
		$options['latest'] = 'Zuletzt angelegter Raum';
		foreach ($rooms as $room) {
			$options[$room->id] = $room->clear_name;
		}
		$data = 'id="gateways_room"';
		echo form_dropdown('gateways_room', $options,"1",$data);
	  ?>
	</div>
</div>
