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
	    $this->load->model('myne_api');
	    
	    $response = $this->myne_api->request($_POST);
	    echo $response;
    }
    
    public function notify($json) {  
	    $this->load->library('myne_api');
	    
	    $this->myne_api->notify($json);
    }
}
