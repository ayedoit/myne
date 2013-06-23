<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Update extends MY_Controller {    
	public function index() {  	
        if ($this->db->table_exists('myne_data')) {
            // Check if installed
            if ($this->tools->getMyneData('installed') == 'yes') {
                $this->config->load('myne_config');

                $this->load->library('page');
                $html = $this->load->view('title',array('update_version' => $this->config->item('myne_update_version'), 'title' => 'Update myne'),true);
                $html .= $this->load->view('installer/update',"",true);
                $this->page->show($html);
            }
            else {
                redirect(base_url('installer'), 'refresh');
            }
        }
        else {
            redirect(base_url('devices'), 'refresh');
        } 
    }

    public function do_update() {
        $this->config->load('myne_config');
        $this->load->view('installer/update_latest');
    } 
}
