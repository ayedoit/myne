<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Dashboard extends MY_Controller {    
	public function index() {  
	    $this->load->library('page');
	    $html = $this->load->view('title',array('title' => "Dashboard"),true);
	    $html .= $this->load->view('dashboard',"",true);
	    $this->page->show($html);
    }
}
