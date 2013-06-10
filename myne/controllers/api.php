<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class API extends CI_Controller {
	function __construct(){
        parent::__construct();

		// Check API
        if($this->tools->getSettingByName('api') != 'true') {
        	log_message('error','API not activated!');
			show_error('API not activated!');
			die;
		}
    }
    
	public function request($json="") {
		$json = json_decode(file_get_contents('php://input'),true);
		
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
			
			// Check for correct request type
			// If not JSON, die
			log_message('debug', 'Request from "'.$_SERVER['REMOTE_ADDR'].'"');
			log_message('error', 'API Error: Wrong request type');
			log_message('debug','Requested with: '.$_SERVER['HTTP_X_REQUESTED_WITH']);
			show_error('Error. Wrong request type: "'.$_SERVER['HTTP_X_REQUESTED_WITH'].'"');
			die;
		} 

		log_message('debug','Request: '.print_r($json,true));
		
	    $this->load->model('myne_api');

	    if (isset($json['params']['api_key']) && trim($json['params']['api_key']) != '') {
		    if ($this->myne_api->checkAPIKey($json['params']['api_key'])) {
		    	$response = $this->myne_api->request($json);

		    	// Return response
		    	echo $response;
		    }
		    else {
		    	// JSON Error
		    	$error = array(
					"code" => "-32602",
					"message" => "API Authentication failed"
				);
				
				$return = array(
					"jsonrpc" => "2.0",
					"error" => $error,
					"id" => "1"
				);
				
				log_message('debug', 'Request: Error');
				log_message('debug', 'Error: '.$error['message']);
				
				echo json_encode($return);
		    }
		}
	    else {
	    	// JSON Error
	    	$error = array(
				"code" => "-32602",
				"message" => "API Authentication failed"
			);
			
			$return = array(
				"jsonrpc" => "2.0",
				"error" => $error,
				"id" => "1"
			);
			
			log_message('debug', 'Request: Error');
			log_message('debug', 'Error: '.$error['message']);
			
			echo json_encode($return);
	    }   
    }
    
    public function notify($json) {  
	    $this->load->library('myne_api');
	    
	    $this->myne_api->notify($json);
    }
}
