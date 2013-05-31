<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class API extends CI_Controller {
	function __construct(){
        parent::__construct();
        
        // Check Login
        if($this->tools->getSettingByName('login') == 'true') {
			$this->load->model('user');
			if(!$this->user->is_logged_in()) redirect('login', 'refresh');
		}
    }
    
	public function request($json="") {
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
			// Check for correct request type
			// If not JSON, die
			log_message('error', 'API Error: Wrong request type');
			show_error('Error. Wrong request type! JSON Only!');
			die;
		} 
		
	    $this->load->model('myne_api');
		$response = $this->myne_api->request($_POST);
	    
	    // Return response
	    echo $response;
    }
    
    public function notify($json) {  
	    $this->load->library('myne_api');
	    
	    $this->myne_api->notify($json);
    }
}
