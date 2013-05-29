<?php
Class connair extends CI_Model {
	/*
	 * 
	 * Commands
	 * 
	 */
	
	public function send($device, $msg, $gateway) {
		$len = strlen($msg);
		if(!($sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP))) {
			$errorcode = socket_last_error();
			$errormsg = socket_strerror($errorcode);
			throw new Exception("Could not create socket: [".$errorcode."]: ".$errormsg);
			die;
		}
		
		$ip = trim((string)$gateway->address);
		if(!filter_var($ip, FILTER_VALIDATE_IP)) {
			$ipCheck = @gethostbyname(trim((string)$gateway->address));
			if($ip == $ipCheck) {
				continue;
			} else {
				$ip = $ipCheck;
			}
		}
		if( ! socket_sendto ( $sock , $msg, $len , 0, $ip , (integer)$gateway->port)) {
				$errorcode = socket_last_error();
				if($errorcode>0) {
					$errormsg = socket_strerror($errorcode);
					throw new Exception("Could not send data: [".$errorcode."]: ".$errormsg);
					die;
				}
		} 

		if($sock) {
			socket_close($sock);
		}
	}
}
?>
