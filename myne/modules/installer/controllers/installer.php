<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Installer extends CI_Controller {
	function __construct(){
        parent::__construct();
    }
    
	public function index() {  	
	    $this->load->view('installer/installer');
    }

    public function install() {
    	// Create Tables & Inserts
    	try {
    		$this->tools->setupMysql();
    	} catch (Exception $e) {
    		show_error($e->getMessage());
    	}

    	// Update API Key
    	$api_key = $this->tools->generateAPIKey();
    	$this->tools->updateSettings("api_key",$api_key);

    	// Add User
    	$this->tools->addUser($_POST['username'],$_POST['password'],$_POST['givenname'],$_POST['surename']);

        // Add Cron for Tasks
        $this->load->model('cron');
        $cron = $this->cron->onDayOfWeek('*');
        $this->cron->onHour('*');
        $this->cron->onMinute('*');
        $this->cron->onMonth('*');
        $this->cron->ondayOfMonth('*');
        $this->cron->doJob('echo "Hallo"');
        $this->cron->listJobs();
        
        $this->cron->activate(true);
        $this->cron->listJobs();
        var_dump($cron);

    	redirect(base_url('devices'), 'refresh');
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
