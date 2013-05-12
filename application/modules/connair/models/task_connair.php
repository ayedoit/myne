<?php
Class task_connair extends CI_Model {
	
	public function getGateways() {
		$this->load->database();
		$query = $this->db->get('connair_gateways');
		
		$gateways = array();
		foreach ($query->result() as $row)
		{
			$gateways[] = $row;
		}
		return $gateways;
	}
	
	/*
	 * getDevicesByRoom
	 * getDevicesByGroup
	 * getDeviceByID
	 * getDevicesByName (%LIKE%)
	 * */
	
	public function getDevices() {
		$this->load->database();
		$query = $this->db->get('connair_devices');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	/*
	 * getDevicesByModel
	 * getDevicesByVendor
	 * getDevicesByRoom
	 * getDevicesByGroup
	 * getDeviceByID
	 * getDeviceByName (%LIKE%)
	 * */
	
	public function send($device, $msg, $connair) {
		$len = strlen($msg);
		if(!($sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP))) {
			$errorcode = socket_last_error();
			$errormsg = socket_strerror($errorcode);
			$errormessage="Couldn't create socket: [$errorcode] $errormsg \n";
			return;
		}
		//~ $devicesenderid=(string)$device->senderid;
		//~ if(!empty($devicesenderid) && (string)$device->senderid != (string)$connair->id) {
			//~ continue;
		//~ }
		
		$newmsg=str_replace("#baud#","25",$msg);
		
		$connairIP = trim((string)$connair->address);
		if(!filter_var($connairIP, FILTER_VALIDATE_IP)) {
			$connairIPCheck = @gethostbyname(trim((string)$connair->address));
			if($connairIP == $connairIPCheck) {
				$errormessage="ConnAir ".$connairIP." is not availible. Check IP or Hostname.";
				continue;
			} else {
				$connairIP = $connairIPCheck;
			}
		}
		if( ! socket_sendto ( $sock , $newmsg, $len , 0, $connairIP , (integer)$connair->port)) {
				$errorcode = socket_last_error();
				if($errorcode>0) {
				$errormsg = socket_strerror($errorcode);
				$errormessage="Could not send data: [$errorcode] $errormsg \n";
			} else {
				$errormessage="Befehl an Connair gesendet \n";
			}
		} else {
			$errormessage="Befehl an Connair gesendet \n";
		}
		if($sock) {
			socket_close($sock);
		}
	}
}
?>
