<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class Installer extends MX_Controller { 
	function __construct(){
        parent::__construct();
        
    }
	
	public function index() {  
	    $this->load->library('page');
	    $html = $this->load->view('installer/installer',"",true);
	    $this->page->show($html);
    }
}
