<?php
Class kraken extends CI_Model {
	/*
	 * 
	 * Kraken
	 * 
	 */
	
	public function send($device,$msg,$gateway) {
		// Generate URL from Gateway-Data + msg

		$url = "http://".$gateway->address.":".$gateway->port."/interfaces/".$msg['interface_name']."/vendors/".$msg['vendor_name']."/models/".$msg['model_name'];

		$ch = curl_init($url);                                                                
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  

		$post_data = array(
			"master_dip" => $msg['master_dip'],
			"slave_dip" => $msg['slave_dip'],
			"action" => $msg['action'],
			"status" => $msg['status']
		);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen(json_encode($post_data)))                                                                       
		);                                                                                                                   

		$response = curl_exec($ch);

		if (!$response) {
			log_message('debug', 'Could not reach gateway');
			throw new Exception("Could not reach gateway");
		}
		
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		if ($http_status != '200') {
			throw new Exception($response);
		}
		return json_decode($response);
	}

	// public function send($device, $msg, $gateway) {
	// 	$len = strlen($msg);
	// 	if(!($sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP))) {
	// 		$errorcode = socket_last_error();
	// 		$errormsg = socket_strerror($errorcode);
	// 		log_message('debug', 'Could not create socket: ['.$errorcode.']: '.$errormsg);
	// 		throw new Exception("Could not create socket: [".$errorcode."]: ".$errormsg);
	// 		die;
	// 	}
		
	// 	$ip = trim((string)$gateway->address);
	// 	if(!filter_var($ip, FILTER_VALIDATE_IP)) {
	// 		$ipCheck = @gethostbyname(trim((string)$gateway->address));

	// 		if($ip == $ipCheck) {
	// 			throw new Exception("Could not determine IP address from hostname for gateway '".$gateway->clear_name."'. Is it offline?");
	// 		} else {
	// 			$ip = $ipCheck;
	// 		}
	// 	}
	// 	if( ! socket_sendto ( $sock , $msg, $len , 0, $ip , (integer)$gateway->port)) {
	// 			$errorcode = socket_last_error();
	// 			if($errorcode>0) {
	// 				$errormsg = socket_strerror($errorcode);
	// 				log_message('debug', "Could not send data: [".$errorcode."]: ".$errormsg);
	// 				throw new Exception("Could not send data: [".$errorcode."]: ".$errormsg);
	// 				die;
	// 			}
	// 	} 

	// 	if($sock) {
	// 		socket_close($sock);
	// 	}
	// }
}
?>
