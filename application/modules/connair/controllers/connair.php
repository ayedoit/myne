<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class Connair extends MX_Controller { 
	function __construct(){
        parent::__construct();
        
        // Check Login
        if($this->tools->getSettingByName('login') == 'true') {
			$this->load->model('user');
			if(!$this->user->is_logged_in()) redirect('login', 'refresh');
		}
    }
	
	public function index(){	    
		$this->load->library('page');
		$html = $this->load->view('connair',"",true);
		$this->page->show($html);
	}
	
	public function gateways(){
	    $this->load->model('task_connair');
	    
	    $gateways = $this->task_connair->getGateways();
	    foreach ($gateways as $gateway) {
			echo $gateway->name;
		}
	    
	    $this->load->library('page');
	    $html = $this->load->view('connair',"",true);
	    $this->page->show($html);
	}
	
	public function device($device,$status){
	    $this->load->model('task_connair');
	    
	    $gateways = $this->task_connair->getGateways();
	    $connair = $gateways[0];
	    
	    // Switch device with ID 1
	    $devices = $this->task_connair->getDevices();
	    $device = $devices[0];
	    
	    $this->load->model('intertechno');
	    $msg = $this->intertechno->connair_create_msg_intertechno($device, $status);

	    $this->task_connair->send($device, $msg, $connair);
	    
	    $this->load->library('page');
	    $html = $this->load->view('connair',"",true);
	    $this->page->show($html);
	}
}
