<?php
	$version = "1.0.1";
	$sql = array(
		0 => "INSERT INTO `settings` VALUES ('','weather_location','0');",
		1 => "ALTER TABLE devices ADD parent int(10) NOT NULL DEFAULT '0';"
		2 => "INSERT INTO `vendors` VALUES ('','dario','Dario','Dario');",
		3 => "INSERT INTO `vendor_types` VALUES (6,1);",
		4 => "INSERT INTO `models` VALUES ('','dmv-7008','DMV-7008','DMV-7008',6);",
		5 => "INSERT INTO `models` VALUES ('','cmr1000','CMR-1000','CMR-1000',1);",
		6 => "INSERT INTO `models` VALUES ('','cmr300','CMR-300','CMR-300',1);",
		7 => "INSERT INTO `models` VALUES ('','cmr500','CMR-500','CMR-500',1);",
		8 => "INSERT INTO `models` VALUES ('','itl500','ITL-500','ITL-500',1);",
		9 => "INSERT INTO `models` VALUES ('','itlr300','ITLR-300','ITLR-300',1);",
		10 => "INSERT INTO `models` VALUES ('','itlr3500','ITLR-3500','ITLR-3500',1);",
		11 => "INSERT INTO `models` VALUES ('','pa31000','PA3-1000','PA3-1000',1);",
		12 => "INSERT INTO `models` VALUES ('','ab440s','AB 440S','AB 440S',3);"
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

	// Todo: Changelog
	redirect('installer/update',refresh);
?>
