<div class="row-fluid">
	<div class="span6">
		<?php
		$this->load->helper('form');
		$attributes = array('class' => 'form-horizontal', 'id' => 'add_device');
		echo form_open('devices/add/validate',$attributes);
		?>
		<fieldset>
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Geräte-ID', 'devices_name',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_name',
					  'id'          => 'devices_name',
					  'placeholder' => 'Geräte-ID'
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
					echo form_label('Geräte Name', 'devices_clear_name',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_clear_name',
					  'id'          => 'devices_clear_name',
					  'placeholder' => 'Geräte Name'
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
					echo form_label('Geräte Beschreibung', 'devices_description',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_description',
					  'id'          => 'devices_description',
					  'placeholder' => 'Geräte Beschreibung'
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
					echo form_label('Typ', 'devices_type',$attributes);
				?>
				<div class="controls">
				  <?php
					$this->load->model('type');
					$types = $this->type->getTypes();
					
					$options = array();
					foreach ($types as $type) {
						$options[$type->id] = $type->clear_name;
					}
					$data = 'id="devices_type"';
					echo form_dropdown('devices_type', $options,"1",$data);
				  ?>
				</div>
			</div>
			
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Hersteller', 'devices_vendor',$attributes);
				?>
				<div class="controls">
				  <?php
					$this->load->model('vendor');
					$vendors = $this->vendor->getVendorsByType('1');
					
					$options = array();
					foreach ($vendors as $vendor) {
						$options[$vendor->id] = $vendor->clear_name;
					}
					$data = 'id="devices_vendor"';
					echo form_dropdown('devices_vendor', $options,"1",$data);
				  ?>
<!--
				  <a  rel="tooltip" title="Neuen Hersteller anlegen" id="add_vendor" class="btn btn-success btn-small"><i class="icon-plus icon-white"></i></a>
-->
				</div>
			</div>
			
			<div id="vendor_space"></div>
			
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Modell', 'devices_model',$attributes);
				?>
				<div class="controls">
				  <?php
					$this->load->model('model');
					$models = $this->model->getModelsByVendor('1');
					
					$options = array();
					foreach ($models as $model) {
						$options[$model->id] = $model->clear_name;
					}
					$data = 'id="devices_model"';
					echo form_dropdown('devices_model', $options,"1",$data);
				  ?>
<!--
				  <a  rel="tooltip" title="Neues Modell anlegen" id="add_model" class="btn btn-success btn-small"><i class="icon-plus icon-white"></i></a>
-->
				</div>
			</div>
			
			<div id="model_space"></div>
			
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Raum', 'devices_room',$attributes);
				?>
				<div class="controls">
				  <?php
					$this->load->model('room');
					$rooms = $this->room->getRooms();
					
					$options = array();
					foreach ($rooms as $room) {
						$options[$room->id] = $room->clear_name;
					}
					$data = 'id="devices_room"';
					echo form_dropdown('devices_room', $options,"1",$data);
				  ?>
				  <a  rel="tooltip" title="Neuen Raum anlegen" id="add_room" class="btn btn-success btn-small"><i class="icon-plus icon-white"></i></a>
				</div>
			</div>
			
			<div id="room_space"></div>
			
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Gruppe', 'devices_group',$attributes);
				?>
				<div class="controls">
				  <?php
					$this->load->model('device');
					$groups = $this->device->getGroups();
					
					$options = "";
					foreach ($groups as $group) {
						$options[$group->id] = $group->clear_name;
					}
					$data = 'id="devices_group"';
					echo form_multiselect('devices_group[]', $options,"0",$data);
				  ?>
				  <a  rel="tooltip" title="Neue Gruppe anlegen" id="add_group" class="btn btn-success btn-small"><i class="icon-plus icon-white"></i></a>
				</div>
			</div>
			
			<div id="group_space"></div>
			
			<div class="control-group">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Gateway', 'devices_gateway',$attributes);
				?>
				<div class="controls">
				  <?php
					$this->load->model('gateways/gateway');
					$gateways = $this->gateway->getGateways();
					
					$options = array("0" => "Kein Gateway");
					foreach ($gateways as $gateway) {
						$options[$gateway->id] = $gateway->clear_name;
					}
					$data = 'id="devices_gateway"';
					echo form_dropdown('devices_gateway', $options,"1",$data);
				  ?>
				  <a  rel="tooltip" title="Neues Gateway anlegen" id="add_gateway" class="btn btn-success btn-small"><i class="icon-plus icon-white"></i></a>
				</div>
			</div>
			
			<div id="gateway_space"></div>
			
			<div class="control-group funksteckdose type-specific">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Master DIP', 'devices_masterdip',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_masterdip',
					  'id'          => 'devices_masterdip',
					  'placeholder' => 'Master DIP'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group funksteckdose type-specific">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Slave DIP', 'devices_slavedip',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_slavedip',
					  'id'          => 'devices_slavedip',
					  'placeholder' => 'Slave DIP'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group funksteckdose type-specific">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('TX433 Version', 'devices_tx433version',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_tx433version',
					  'id'          => 'devices_tx433version',
					  'value' => '1'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group xbmc type-specific hide">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Adresse', 'devices_address',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_address',
					  'id'          => 'devices_address',
					  'placeholder' => 'Adresse (IP, Hostname)'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group xbmc type-specific hide">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Port', 'devices_port',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_port',
					  'id'          => 'devices_port',
					  'placeholder' => 'Port'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group xbmc type-specific hide">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Wake On LAN Port', 'devices_wol_port',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_wol_port',
					  'id'          => 'devices_wol_port',
					  'placeholder' => 'Wake On LAN Port'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group xbmc type-specific hide">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('MAC Adresse', 'devices_mac_address',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_mac_address',
					  'id'          => 'devices_mac_address',
					  'placeholder' => 'MAC Adresse'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group xbmc type-specific hide">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Geräte User', 'devices_user',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_user',
					  'id'          => 'devices_user',
					  'placeholder' => 'Username'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
			
			<div class="control-group xbmc type-specific hide">
				<?php 
					$attributes = array(
						'class' => 'control-label'
					);
					echo form_label('Geräte Password', 'devices_password',$attributes);
				?>
				<div class="controls">
				  <?php
					$data = array(
					  'name'        => 'devices_password',
					  'id'          => 'devices_password',
					  'placeholder' => 'Geräte Passwort'
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
					echo form_label('Aktionen', 'options',$attributes);
				?>
				<div class="controls">
				  <?php
					$options = array();
					$this->load->model('devices/device');
					$device_options = $this->device->getOptions();
					
					foreach ($device_options as $option) {
						$options[$option->id] = $option->clear_name;
					}
					$data = 'id="options"';
					echo form_multiselect('options[]', $options,"1",$data);
				  ?>
				</div>
			</div>
			
			 <div class="control-group">
				<div class="controls">
				  <?php 
					$data = array(
					  'add_vendor'  => '0',
					  'add_model' => '0',
					  'add_room'   => '0',
					  'add_group'   => '0',
					  'add_gateway'   => '0',
					  'form' => '1'
					);		
					echo form_hidden($data);	
					
					$submit = array(
						"class" => "btn btn-primary btn-medium",
						"name" => "devices_submit",
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
			<dt>Geräte-ID</dt>
			<dd>Eindeutige Gerätebezeichnung. Nur Kleinbuchstaben, Zahlen sowie "<b>-</b>" und "<b>_</b>" als Sonderzeichen.</dd>
			<dt>Geräte Name</dt>
			<dd>Klarname des Gerätes für die Darstellung im Frontend.</dd>
			<dt>Geräte Beschreibung</dt>
			<dd>Beschreibung des Gerätes.</dd>
			<dt>Typ</dt>
			<dd>Typ des Gerätes.</dd>
			<dt>Hersteller</dt>
			<dd>Hersteller des Gerätes.</dd>
			<dt>Modell</dt>
			<dd>Modell des Gerätes.</dd>
			<dt>Raum</dt>
			<dd>Raum in dem sich das Gerät befindet.</dd>
			<dt>Gruppe</dt>
			<dd>Statische Gruppe(n) des Gerätes. Geräte werden automatisch nach Typ und Raum gruppiert. Statische Gruppen bieten die Möglichkeit, über Räume und Typen hinweg Geräte zu gruppieren.</dd>
			<dt>Gateway</dt>
			<dd>Gateway über das die Befehle an das Gerät geschickt werden, sofern nötig (z.B. bei Funksteckdosen).</dd>
			<dt>Master DIP</dt>
			<dd>Signalcode (Master). Mehr dazu in der <a href="<?= base_url('faq/masterdip'); ?>" title="FAQ: Master DIP">FAQ</a>.</dd>
			<dt>Slave DIP</dt>
			<dd>Signalcode (Slave). Mehr dazu in der <a href="<?= base_url('faq/slavedip'); ?>" title="FAQ: Slave DIP">FAQ</a>.</dd>
			<dt>TX433 Version</dt>
			<dd>Signalcode-Version für 433MHz Gateways. Mehr dazu in der <a href="<?= base_url('faq/tx433'); ?>" title="FAQ: TX433 Version">FAQ</a>.</dd>
			<dt>Adresse</dt>
			<dd>Adresse (IP oder Hostname) des Gerätes.</dd>
			<dt>Port</dt>
			<dd>Port des Gerätes (z.B. Port XBMC).</dd>
			<dt>Wake On LAN Port</dt>
			<dd>Port für WOL (z.B. Port "9" für XBMC).</dd>
			<dt>MAC Adresse</dt>
			<dd>MAC Adresse des Gerätes. Wichtig für Wake on LAN.</dd>
			<dt>Geräte User</dt>
			<dd>Username für Zugriff auf Gerät (z.B. XBMC).</dd>
			<dt>Geräte Passwort</dt>
			<dd>Passwort für Zugriff auf Gerät (z.B. XBMC).</dd>
			<dt>Aktionen</dt>
			<dd>Mögliche Aktionen für das Gerät.</dd>
			
		</dl>
	</div>
</div>
<script>
	$(document).ready(function() {  
		$('#devices_type').change(function() {
			var value = $('#devices_type').val();
			var response = "";

			// If type == funksteckdose, hide all div's of class "type-specific" without class "funksteckdose"
			if (value == "1") {
				$('.type-specific').not('.funksteckdose').addClass('hide');
				$('.type-specific.funksteckdose').removeClass('hide');
			}
			// XBMC
			else if (value == "2") {
				$('.type-specific').not('.xbmc').addClass('hide');
				$('.type-specific.xbmc').removeClass('hide');
			}

			
			// Get vendors for selected type
			var request = {"jsonrpc": "2.0", "method": "getVendorsByType", "params": {"model":"devices/vendor","opts":[value]}, "id": 2};
			$.post("<?= base_url('api/request'); ?>", request, function(data) {
				response = jQuery.parseJSON(data);
				
				$("#devices_vendor option").each(function() {
					$(this).remove();
				});
				
				// Udate vendors
				$.each(response.result, function (key,val) {
					$('#devices_vendor')
					 .append($("<option></option>")
					 .attr("value",val.id)
					 .text(val.clear_name)); 
				});
				
				$('#devices_vendor').trigger('change');
			});	
		});
		
		$('#devices_vendor').change(function() {
			var value = $('#devices_vendor').val();
			var response = "";
			
			// Get vendors for selected type
			var request = {"jsonrpc": "2.0", "method": "getModelsByVendor", "params": {"model":"devices/model","opts":[value]}, "id": 2};
			$.post("<?= base_url('api/request'); ?>", request, function(data) {
				response = jQuery.parseJSON(data);
				
				$("#devices_model option").each(function() {
					$(this).remove();
				});
				
				// Udate vendors
				$.each(response.result, function (key,val) {
					$('#devices_model')
					 .append($("<option></option>")
					 .attr("value",val.id)
					 .text(val.clear_name)); 
				});
				
				$('#devices_model').trigger('change');
			});	
		});
		
		// Tooltips
		$(function () {
			$("[rel='tooltip']").tooltip();
		});
		
		// Add new Vendor
		$('#add_vendor').live("click",function(){
				$(this).html('<i class="icon-minus icon-white"></i>').removeClass('btn-success').addClass('btn-danger').attr("id","add_vendor_cancel");
				$('#vendor_space').load('<?= base_url('devices/view/add_vendor'); ?>');
				$('#devices_vendor').attr("disabled", "disabled").val("0");
				$('input[name="add_vendor"]').val("1");		
		});
		$('#add_vendor_cancel').live("click",function(){
				$('#vendor_space').empty();
				$('#devices_vendor').removeAttr("disabled", "disabled");
				$('input[name="add_vendor"]').val("0");	
				$(this).html('<i class="icon-plus icon-white"></i>').removeClass('btn-dange').addClass('btn-success').attr("id","add_vendor");
		});
		
		// Add new Model
		$('#add_model').live("click",function(){
				$(this).html('<i class="icon-minus icon-white"></i>').removeClass('btn-success').addClass('btn-danger').attr("id","add_model_cancel");
				$('#model_space').load('<?= base_url('devices/view/add_model'); ?>');
				$('#devices_model').attr("disabled", "disabled").val("0");
				$('input[name="add_model"]').val("1");
				
		});
		$('#add_model_cancel').live("click",function(){
				$('#model_space').empty();
				$('#devices_model').removeAttr("disabled", "disabled");
				$('input[name="add_model"]').val("0");	
				$(this).html('<i class="icon-plus icon-white"></i>').removeClass('btn-dange').addClass('btn-success').attr("id","add_model");
		});
		
		// Add new Room
		$('#add_room').live("click",function(){
				$(this).html('<i class="icon-minus icon-white"></i>').removeClass('btn-success').addClass('btn-danger').attr("id","add_room_cancel");
				$('#room_space').load('<?= base_url('dash/view/add_room'); ?>');
				$('#devices_room').attr("disabled", "disabled").val("0");
				$('input[name="add_room"]').val("1");
				
		});
		$('#add_room_cancel').live("click",function(){
				$('#room_space').empty();
				$('#devices_room').removeAttr("disabled", "disabled");
				$('input[name="add_room"]').val("0");	
				$(this).html('<i class="icon-plus icon-white"></i>').removeClass('btn-dange').addClass('btn-success').attr("id","add_room");
		});
		
		// Add new Group
		$('#add_group').live("click",function(){
				$(this).html('<i class="icon-minus icon-white"></i>').removeClass('btn-success').addClass('btn-danger').attr("id","add_group_cancel");
				$('#group_space').load('<?= base_url('devices/view/add_group'); ?>');
				$('#devices_group').attr("disabled", "disabled").val("0");
				$('input[name="add_group"]').val("1");
				
		});
		$('#add_group_cancel').live("click",function(){
				$('#group_space').empty();
				$('#devices_group').removeAttr("disabled", "disabled");
				$('input[name="add_group"]').val("0");	
				$(this).html('<i class="icon-plus icon-white"></i>').removeClass('btn-dange').addClass('btn-success').attr("id","add_group");
		});
		
		// Add new Gateway
		$('#add_gateway').live("click",function(){
				$(this).html('<i class="icon-minus icon-white"></i>').removeClass('btn-success').addClass('btn-danger').attr("id","add_gateway_cancel");
				$('#gateway_space').load('<?= base_url('gateways/view/add_gateway'); ?>');
				$('#devices_gateway').attr("disabled", "disabled").val("0");
				$('input[name="add_gateway"]').val("1");
				
		});
		$('#add_gateway_cancel').live("click",function(){
				$('#gateway_space').empty();
				$('#devices_gateway').removeAttr("disabled", "disabled");
				$('input[name="add_gateway"]').val("0");
				$(this).html('<i class="icon-plus icon-white"></i>').removeClass('btn-dange').addClass('btn-success').attr("id","add_gateway");	
		});
		
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
		
		$('#add_device').validate(
		{
		rules: {
			devices_name: {
			  minlength: 3,
			  maxlength: 200,
			  required: true,
			  regex: /^[a-z\d_-]+$/,
			  unique: "devices"
			},
			devices_clear_name: {
			  required: true,
			  maxlength: 200
			},
			devices_description: {
			  required: true,
			  maxlength: 200
			},
			vendors_name: {
			  minlength: 3,
			  maxlength: 200,
			  required: true,
			  regex: /^[a-z\d_-]+$/,
			  unique: "vendors"
			},
			vendors_clear_name: {
			  required: true,
			  maxlength: 200
			},
			vendors_description: {
			  required: true,
			  maxlength: 200
			},
			groups_name: {
			  minlength: 3,
			  maxlength: 200,
			  required: true,
			  regex: /^[a-z\d_-]+$/,
			  unique: "device_groups"
			},
			groups_clear_name: {
			  required: true,
			  maxlength: 200
			},
			groups_description: {
			  required: true,
			  maxlength: 200
			},
			models_name: {
			  minlength: 3,
			  maxlength: 200,
			  required: true,
			  regex: /^[a-z\d_-]+$/,
			  unique: "models"
			},
			models_clear_name: {
			  required: true,
			  maxlength: 200
			},
			models_description: {
			  required: true,
			  maxlength: 200
			},
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
			},
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
			},
			devices_masterdip: {
			  regex: /^[A-Za-z\d]+$/,
			  required: true
			},
			devices_slavedip: {
			  regex: /^[A-Za-z\d]+$/,
			  required: true
			},
			devices_tx433version: {
				number: true
			},
			devices_address: {
				required: true
			},
			devices_port: {
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
