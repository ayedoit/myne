<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Dash extends CI_Controller {
	function __construct(){
        parent::__construct();
        
        // Check Login
        if($this->tools->getSettingByName('login') == 'true') {
			$this->load->model('user');
			if(!$this->user->is_logged_in()) redirect('login', 'refresh');
		}
    }
    
	public function index() {  
		$this->load->model('task');
		$tasks = $this->task->getTasks();
		
	    $this->load->library('page');
	    $html = $this->load->view('title',array('title' => "Tasks"),true);
	    $html .= $this->load->view('dash',array('tasks' => $tasks),true);
	    $this->page->show($html);
    }
    
    public function icons() {
		$this->load->model('tools');
		$icons = $this->tools->getIcons();

		echo "Icons";
		echo "<pre>".print_r($icons,true)."</pre>";
		
	}
	
	public function view($view) {
		$this->load->view($view,"");
	}
        
    function logout()
	{
	  $this->session->unset_userdata('logged_in');
	  session_destroy();
	  redirect('dash', 'refresh');
	}
}
