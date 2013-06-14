<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class settings extends MY_Controller {    
	public function index() {  	
	    $this->load->library('page');
	    $html = $this->load->view('title',array('title' => "Einstellungen"),true);
	    $html .= $this->load->view('settings',"",true);
	    $this->page->show($html);
    }

    public function update(){
		log_message('debug', '[Settings/Update]: Update via POST requested');
		$this->load->model('tools');
		try {
			$update = $this->tools->updateSettings($_POST['pk'],$_POST['value']);
			return true;
		} catch (Exception $e) {
			show_error($e->getMessage(), 500);
		}
	}
}
