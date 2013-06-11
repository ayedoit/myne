<div class="row-fluid">
	<div class="span6">
		<?php
		$this->load->helper('form');
		$attributes = array('class' => 'form-horizontal', 'id' => 'add_gateway');
		echo form_open('gateways/add/validate',$attributes);
		?>
		<fieldset>
			<?php $this->load->view('gateways/add_gateway'); ?>
			
			<div class="control-group">
				<div class="controls">
				  <?php 
					$data = array(
					  'form' => '1'
					);		
					echo form_hidden($data);	
					
					$submit = array(
						"class" => "btn btn-primary btn-medium",
						"name" => "gateways_submit",
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
			<dt>Gateway-ID</dt>
			<dd>Eindeutige Gerätebezeichnung. Nur Kleinbuchstaben, Zahlen sowie "<b>-</b>" und "<b>_</b>" als Sonderzeichen.</dd>
			<dt>Gateway Name</dt>
			<dd>Klarname des Gateways für die Darstellung im Frontend.</dd>
			<dt>Gateway Beschreibung</dt>
			<dd>Beschreibung des Gateways.</dd>
			<dt>Gateway Typ</dt>
			<dd>Typ des Gerätes.</dd>
			<dt>Gateway Adresse</dt>
			<dd>IP oder Hostname des Gateways.</dd>
			<dt>Gateway Port</dt>
			<dd>Port für die Kommunikation mit dem Gateway (z.B. <b>49880</b> für Connair).</dd>
			<dt>Raum</dt>
			<dd>Raum in dem sich das Gateway befindet.</dd>
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
				var request = {"jsonrpc": "2.0", "method": "idIsUnique", "params": {"api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "model":"tools","opts":[value,id_type]}, "id": 1};
				$.ajax({
					url: "<?= base_url('api/request'); ?>",
					type: "post",
					data: JSON.stringify(request),
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
		
		$('#add_gateway').validate(
		{
		rules: {
			gateways_name: {
			  minlength: 3,
			  maxlength: 200,
			  required: true,
			  regex: /^[a-z\d_-]+$/,
			  unique: "gateways"
			},
			gateways_clear_name: {
			  required: true,
			  maxlength: 200
			},
			gateways_description: {
			  required: true,
			  maxlength: 200
			},
			gateways_address: {
				required: true
			},
			gateways_port: {
				number: true,
				required: true,
				maxlength: 5
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
