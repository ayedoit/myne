<?php
  Class myne_api extends CI_Model {
	   
    public function request($json) {
		// IP the request comes from
		$remote_ip = $_SERVER['REMOTE_ADDR'];  
		
		// Get values
		$v = $json["jsonrpc"];
		$method = $json["method"];
		$model = $json["params"]["model"];
		$opts = $json["params"]["opts"];
		$id = $json["id"];
		
		$error = array(
			"code" => "",
			"message" => "",
			"data" => ""
		);
		
		// Set header
		header('Content-Type: application/json');
		
		log_message('debug', 'API Call from '.$remote_ip);
		log_message('debug', 'Method: '.$method);
		log_message('debug', 'Model: '.$model);
		log_message('debug', 'Opts: '.print_r($opts,true));
		
		// Call function
		$model = $this->load->model($model);
		try {
			$result = call_user_func_array(array($model,$method), $opts);
			
			$return = array(
				"jsonrpc" => $v,
				"result" => $result,
				"id" => $id
			);
			
			log_message('debug', 'Request: Success');
			log_message('debug', 'Response: '.print_r($result,true));
			
			return json_encode($return);
		} catch (Exception $e) {
			
			$error = array(
				"code" => "-32602",
				"message" => $e->getMessage()
			);
			
			$return = array(
				"jsonrpc" => $v,
				"error" => $error,
				"id" => $id
			);
			
			log_message('debug', 'Request: Error');
			log_message('debug', 'Error: '.$error['message']);
			
			return json_encode($return);
		}
	}

	public function checkAPIKey($api_key) {
		$key = $this->tools->getSettingByName('api_key');

		// Check if given API key is equal to the one defined in the database
		if ($api_key == $key) {
			log_message('debug', '[myne_api/checkAPIKey] API Key verification successful: "'.$api_key.'"');
			return true;
		}
		log_message('debug', '[myne_api/checkAPIKey] API Key verification failed: "'.$api_key.'"');
		return false;
	}
  }
?>
