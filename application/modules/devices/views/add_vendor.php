<?php
	$this->load->helper('form');
?>
<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Hersteller-ID', 'vendors_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'vendors_name',
		  'id'          => 'vendors_name',
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
		echo form_label('Hersteller Name', 'vendors_clear_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'vendors_clear_name',
		  'id'          => 'vendors_clear_name',
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
		echo form_label('Hersteller Beschreibung', 'vendors_description',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'vendors_description',
		  'id'          => 'vendors_description',
		  'placeholder' => 'Hersteller Beschreibung'
		);
		echo form_input($data);
	  ?>
	  <span class="validation_space"></span>
	</div>
</div>
<hr>
