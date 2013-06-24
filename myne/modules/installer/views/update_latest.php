<?php
	$version = "1.0.1";
	$sql = array(
		0 => "INSERT INTO `settings` VALUES ('','weather_location','0');",
		1 => "ALTER TABLE devices ADD parent int(10) NOT NULL DEFAULT '0';"
		2 => "INSERT INTO `vendors` VALUES ('','dario','Dario','Dario');",
		3 => "INSERT INTO `vendor_types` VALUES ('6','1');",
		4 => "INSERT INTO `vendor_types` VALUES ('','dmv-7008','DMV-7008','DMV-7008','6');",
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

	redirect('installer/update_successful',refresh);
?>
