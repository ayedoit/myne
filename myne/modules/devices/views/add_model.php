<?php
	$this->load->helper('form');
?>
<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Modell-ID', 'models_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'models_name',
		  'id'          => 'models_name',
		  'placeholder' => 'Modell-ID'
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
		echo form_label('Modell Name', 'models_clear_name',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'models_clear_name',
		  'id'          => 'models_clear_name',
		  'placeholder' => 'Modell Name'
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
		echo form_label('Modell Beschreibung', 'models_description',$attributes);
	?>
	<div class="controls">
	  <?php
		$data = array(
		  'name'        => 'models_description',
		  'id'          => 'models_description',
		  'placeholder' => 'Modell Beschreibung'
		);
		echo form_input($data);
	  ?>
	  <span class="validation_space"></span>
	</div>
</div>
<hr>
