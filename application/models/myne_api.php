<?php
  Class myne_api extends CI_Model {
	 
	public function response($jsonrpc,$result,$error,$id) {
		$arr = array(
			"jsonrpc" => $jsonrpc,
			"result" => $result,
			"id" => $id
		);
		return json_encode($arr);
	}
	  
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
		
		// Call function
		$model = $this->load->model($model);
		$response = call_user_func_array(array($model,$method), $opts);
		
		// Format json reply
		return $this->response($v,$response,$error="",$id);
	}
	
	public function notify($version,$method,$params="") {
		
	}
  }
?>
