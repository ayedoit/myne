<?php
	$this->load->helper('form');
?>
<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Raum-ID', 'rooms_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'rooms_name',
		  'id'          => 'rooms_name',
		  'placeholder' => 'Raum-ID'
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
		echo form_label('Raum Name', 'rooms_clear_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'rooms_clear_name',
		  'id'          => 'rooms_clear_name',
		  'placeholder' => 'Raum Name'
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
		echo form_label('Raum Beschreibung', 'rooms_description',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'rooms_description',
		  'id'          => 'rooms_description',
		  'placeholder' => 'Raum Beschreibung'
		);
		echo form_input($data);
	  ?>
	  <span class="validation_space"></span>
	</div>
</div>
<hr>
