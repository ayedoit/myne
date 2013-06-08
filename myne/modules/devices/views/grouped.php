<?php
echo "<div class='row-fluid'>";
	// Rooms
	$this->load->view('devices/devices_by_room'); 

	// Types
	$this->load->view('devices/devices_by_type'); 
echo "</div>";

echo "<hr>";

echo "<div class='row-fluid'>";
	// Groups
	$this->load->view('devices/devices_by_group'); 

	// Gateways
	$this->load->view('devices/devices_by_gateway'); 
echo "</div>";
?>
