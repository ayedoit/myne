<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Installer extends MY_Controller {    
	public function index() {  	
        if (!$this->db->table_exists('myne_data')) {
            $this->load->view('installer/installer');
        }
        else {
            redirect(base_url('devices'), 'refresh');
        }
	    
    }

    public function install() {
        if (!$this->db->table_exists('myne_data')) {
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
            // Run once a minute, 24/7 to check if there are tasks to execute
            $this->load->model('cron');
            $this->cron->onDayOfWeek('*');
            $this->cron->onHour('*');
            $this->cron->onMinute('*');
            $this->cron->onMonth('*');
            $this->cron->ondayOfMonth('*');
            $this->cron->doJob('curl http://192.168.0.107/tasks/run > /dev/null 2>&1');        
            $this->cron->activate(true);
        }

    	redirect(base_url('devices'), 'refresh');
    }
}
