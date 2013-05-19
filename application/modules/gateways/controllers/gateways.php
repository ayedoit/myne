<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class Gateways extends MX_Controller { 
	function __construct(){
        parent::__construct();
        
        // Check Login
        $this->load->model('user');
        if(!$this->user->is_logged_in()) redirect('login', 'refresh');
    }
	
	public function index(){	    
		$this->load->model('gateway');
		$gateways = $this->gateway->getGateways();
		
		$this->load->library('page');
		$html = $this->load->view('gateways',array('gateways' => $gateways),true);
		$this->page->show($html);
	}
	
	public function view($view) {
		$this->load->view($view,"");
	}
}
