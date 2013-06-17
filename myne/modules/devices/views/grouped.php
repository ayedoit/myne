<?php
echo "<div class='row-fluid'>";
	// Groups
	$this->load->view('devices/devices_by_group'); 

	// Rooms
	$this->load->view('devices/devices_by_room'); 
echo "</div>";

echo "<hr>";

echo "<div class='row-fluid'>";
	// Types
	$this->load->view('devices/devices_by_type'); 

	// Gateways
	$this->load->view('devices/devices_by_gateway'); 
echo "</div>";
?>
