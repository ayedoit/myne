<?php
	$this->load->helper('form');
?>
<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Hersteller-ID', 'vendor_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'vendor_name',
		  'id'          => 'vendor_name',
		  'placeholder' => 'Hersteller-ID'
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
		echo form_label('Hersteller Name', 'vendor_clear_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'vendor_clear_name',
		  'id'          => 'vendor_clear_name',
		  'placeholder' => 'Hersteller Name'
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
		echo form_label('Hersteller Beschreibung', 'vendor_description',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'vendor_description',
		  'id'          => 'vendor_description',
		  'placeholder' => 'Hersteller Beschreibung'
		);
		echo form_input($data);
	  ?>
	  <span class="validation_space"></span>
	</div>
</div>
<hr>
