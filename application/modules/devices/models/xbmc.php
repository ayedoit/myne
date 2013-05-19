<?php
Class xbmc extends CI_Model {
	public function msg($device, $action) {
		// Currently supported actions
		// - Player Stop
		// - System Shutdown (off)
		
		if ($action == 'off') {
			// Shutdown via JSON API
			$data = array(
				'jsonrpc'      => '2.0',
				'method'    => 'System.Shutdown',
				'id' => 1
			);
		}
		return json_encode($data);
	}
	
	public function send($msg,$url) {
		$ch = curl_init($url);                                                                
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($msg))                                                                       
		);                                                                                                                   
		 
		$response = curl_exec($ch);
		
		var_dump($response);
	}
}
?>
