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
