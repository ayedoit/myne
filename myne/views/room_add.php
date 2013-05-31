<div class="row-fluid">
	<div class="span6">
		<?php
		$this->load->helper('form');
		$attributes = array('class' => 'form-horizontal', 'id' => 'add_room');
		echo form_open('rooms/add/validate',$attributes);
		?>
		<fieldset>
			<?php $this->load->view('add_room'); ?>
			
			<div class="control-group">
				<div class="controls">
				  <?php 
					$data = array(
					  'form' => '1'
					);		
					echo form_hidden($data);	
					
					$submit = array(
						"class" => "btn btn-primary btn-medium",
						"name" => "rooms_submit",
						"value" => "Anlegen"
					);
					echo form_submit($submit);	
				?>
				</div>
			</div>
		</fieldset>
		<?php form_close(); ?>
	</div>
	
	<div class="span6 well">
		<dl>
			<dt>Raum-ID</dt>
			<dd>Eindeutige Raumbezeichnung. Nur Kleinbuchstaben, Zahlen sowie "<b>-</b>" und "<b>_</b>" als Sonderzeichen.</dd>
			<dt>Raum Name</dt>
			<dd>Klarname des Raumes für die Darstellung im Frontend.</dd>
			<dt>Raum Beschreibung</dt>
			<dd>Beschreibung des Raumes.</dd>
		</dl>
	</div>
</div>
<script>
	$(document).ready(function() {  
		// Validator
		$.validator.addMethod(
			"regex",
			function(value, element, regexp) {
				var check = false;
				var re = new RegExp(regexp);
				return this.optional(element) || re.test(value);
			},
			"Nur Kleinbuchstaben und Zahlen sowie '-' und '_' erlaubt."
		);
		
		$.validator.addMethod(
			"unique",
			function(value, element, id_type) {
				var response = null;
				// Check ID against API
				var request = {"jsonrpc": "2.0", "method": "idIsUnique", "params": {"model":"tools","opts":[value,id_type]}, "id": 1};
				$.ajax({
					url: "<?= base_url('api/request'); ?>",
					type: "post",
					data: request,
					dataType: "json",
					async: false,
					success: function(data) {
						response = data;
						console.log(response.result);
					} 
				});	
				if (response.result=="true") {
					return true;
				}
				else {
					return false;
				}
			},
			"Diese ID existiert bereits. Die ID muss eindeutig sein."
		);
		
		$('#add_room').validate(
		{
		rules: {
			rooms_name: {
			  minlength: 3,
			  maxlength: 200,
			  required: true,
			  regex: /^[a-z\d_-]+$/,
			  unique: "rooms"
			},
			rooms_clear_name: {
			  required: true,
			  maxlength: 200
			},
			rooms_description: {
			  required: true,
			  maxlength: 200
			}
		},
		highlight: function(element) {
			$(element).closest('.control-group').removeClass('success').addClass('error');
		},
		success: function(element) {
			element
			.html('<i class="icon-ok-circle"></i>').addClass('valid')
			.closest('.control-group').removeClass('error').addClass('success');
		}
		});
		
	} ); 
</script>
