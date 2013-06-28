<?php
	$version = "1.0.1";
	$sql = array(
		0 => "INSERT INTO `settings` VALUES ('','weather_location','0');",
		1 => "ALTER TABLE devices ADD parent int(10) NOT NULL DEFAULT '0';"
		2 => "INSERT INTO `vendors` VALUES ('','dario','Dario','Dario');",
		3 => "INSERT INTO `vendor_types` VALUES (6,1);",
		4 => "INSERT INTO `models` VALUES ('','dmv-7008as','DMV-7008AS','DMV-7008AS',6);",
		5 => "INSERT INTO `models` VALUES ('','cmr1000','CMR-1000','CMR-1000',1);",
		6 => "INSERT INTO `models` VALUES ('','cmr300','CMR-300','CMR-300',1);",
		7 => "INSERT INTO `models` VALUES ('','cmr500','CMR-500','CMR-500',1);",
		8 => "INSERT INTO `models` VALUES ('','itl500','ITL-500','ITL-500',1);",
		9 => "INSERT INTO `models` VALUES ('','itlr300','ITLR-300','ITLR-300',1);",
		10 => "INSERT INTO `models` VALUES ('','itlr3500','ITLR-3500','ITLR-3500',1);",
		11 => "INSERT INTO `models` VALUES ('','pa31000','PA3-1000','PA3-1000',1);",
		12 => "INSERT INTO `models` VALUES ('','ab440s','AB 440S','AB 440S',3);",
		13 => "INSERT INTO `models` VALUES ('','dmv-7008ad','DMV-7008AD','DMV-7008AD',6);",
		14 => "INSERT INTO `device_types` VALUES ('' , 'remote_outlet_dim', 'Funksteckdose (Dimmer)', 'Funksteckdose mit Dimmfunktion', 'd_funksteckdose.png');",
		15 => "INSERT INTO `actions` VALUES ('','dim','Dimmen','Dimmfunktion','devices/device');",
		16 => "INSERT INTO `device_type_has_action` VALUES (3, 2),(3, 1);",
		17 => "INSERT INTO `vendor_types` VALUES ('6', '3');"
	);

	// Update DB
	try {
		foreach ($sql as $key => $value) {
			$this->db->query($value);
		}
	} catch (Exception $e) {
	    show_error($e->getMessage());
	}

	// Change version
	try {
		$this->tools->updateMyneData('version',$version);
	} catch (Exception $e) {
	    show_error($e->getMessage());
	} 
	?>

	<div class="span6">
		<div class="alert alert-info">
			<h4>Update  erfolgreich!</h4>
			<br>
			<ul>
				<li>Neue Version: <b><?= $version; ?></b></li>
			</ul>
		</div>

		<h3>Das ist neu</h3>

		<ul>
			<li>Neue Modelle:</li>
				<ul>
					<li><b>Dario</b> 7008-AS</li>
					<li><b>Dario</b> 7008-AD (Dimmer)</li>
					<li><b>Elro</b> AB 440S</li>
					<li><b>Intertechno</b> CMR-1000</li>
					<li><b>Intertechno</b> CMR-300</li>
					<li><b>Intertechno</b> CMR-500</li>
					<li><b>Intertechno</b> ITLR-3500</li>
					<li><b>Intertechno</b> ITLR-300</li>
					<li><b>Intertechno</b> ITL-500</li>
					<li><b>Intertechno</b> PA3-1000</li>
				</ul>
			<li>Neuer Gerätetyp: <b>Dimmer</b></li>
			<li>Neue Event-Source: <b>Wetter</b></li>
			<li>Neues Event > Action Modell (mehr Optionen, performanter)</li>
			<li>Neues Geräte-Attribut: <b>Eltern-Gerät</b> (für kaskadierte Schaltungen)</li>
		</ul>
		<hr>
		<a href="<?= base_url('devices'); ?>" title="Startseite" class="btn btn-success">Zur Startseite</a>
	</div>