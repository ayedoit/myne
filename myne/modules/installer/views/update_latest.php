<?php
	$version = "1.0.1";
	$sql = "ALTER TABLE devices ADD parent int(10);";

	// Change version
	try {
		$this->tools->updateMyneData('version',$version);
	} catch (Exception $e) {
	    show_error($e->getMessage());
	} 

	// Update DB
	try {
		$this->db->query($sql);
		echo $sql;
	} catch (Exception $e) {
	    show_error($e->getMessage());
	}

	redirect('installer/update_successful',refresh);
?>