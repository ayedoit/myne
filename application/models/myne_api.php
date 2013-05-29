<?php
  Class myne_api extends CI_Model {
	   
    public function request($json) {
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
		
		// Call function
		$model = $this->load->model($model);
		try {
			$result = call_user_func_array(array($model,$method), $opts);
			
			$return = array(
				"jsonrpc" => $v,
				"result" => $result,
				"id" => $id
			);
			
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
			
			return json_encode($return);
		}
	}
	
	public function notify($version,$method,$params="") {
		
	}
  }
?>
