<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class Gateways extends MX_Controller { 
	function __construct(){
        parent::__construct();
        
        // Check Login
        if($this->tools->getSettingByName('login') == 'true') {
			$this->load->model('user');
			if(!$this->user->is_logged_in()) redirect('login', 'refresh');
		}
    }
	
	public function index() {  
	    $this->load->library('page');
	    $html = $this->load->view('devices/devices_by_gateway',"",true);
	    $this->page->show($html);
    }
	
	public function view($view) {
		$this->load->view($view,"");
	}
	
	public function update($name){
		$this->load->model('gateways/gateway');
		try {
			$this->gateway->updateGateway($name,$_POST['pk'],$_POST['value']);
			return true;
		} catch (Exception $e) {
			show_error($e->getMessage(), 500);
		}
	}
	
	public function show($gateway){
		// Get device
		$this->load->model('gateway');
		$gateway = $this->gateway->getGatewayByName($gateway);

		if (empty($gateway) || sizeof($gateway) == 0) {
			show_404();
			die;
		}
			    
		$this->load->library('page');
		$html = $this->load->view('title',array('icon' => $gateway->icon,'title' => $gateway->clear_name),true);
		$html .= $this->load->view('gateway',array('gateway' => $gateway),true);
		$this->page->show($html);
	}
	
	public function add($status) {
		if (empty($status) || trim($status) == '') {
			log_message('debug', '[Gateways/Add]: No status given (should be "new" for new rooms or "validate" for validation)');
			redirect(base_url('gateways/add/new'), 'refresh');
		}
		else {
			if ($status == 'validate') {
				$this->load->model('gateway');
				if (isset($_POST['form']) && $_POST['form']=='1') {
					// Take form input and validate
					$gateway_data = array(
						'name' => $_POST['gateways_name'],
						'clear_name' => $_POST['gateways_clear_name'],
						'description' => $_POST['gateways_description'],
						'icon' => $_POST['gateways_icon'],
						'type' => $_POST['gateways_type'],
						'address' => $_POST['gateways_address'],
						'port' => $_POST['gateways_port'],
						'room' => $_POST['gateways_room']
					);			

					// Insert!
					$gateway_id = $this->gateway->addGateway($gateway_data);
					
					// Done!
					redirect(base_url('gateways/show/'.$gateway_data['name']), 'refresh');
				}
				else {
					log_message('debug', '[Gateways/Add]: Validation requested but no data submitted');
					redirect(base_url('gateways/add/new'), 'refresh');
				}
			}
			elseif ($status == 'new') {
				$this->load->library('page');
				$html = $this->load->view('title',array('title' => "Neues Gateway anlegen"),true);
				$html .= $this->load->view('gateways/add', array('status' => $status),true);
				$this->page->show($html);
			}
		}

	}
	
	public function delete($name,$status) {
		
		$this->load->model('gateways/gateway');
		$gateway = $this->gateway->getGatewayByName($name);
		
		if (empty($status) || trim($status) == '') {
			log_message('debug', '[Gateways/Delete]: No status given (should be "confirm" or "execute" after successful confirmation)');
			redirect(base_url('gateways/show/'.$gateway->name), 'refresh');
		}
		else {
			if ($status == 'confirm') {
				$this->load->library('page');
				$html = $this->load->view('title',array('icon' => $gateway->icon,'title' => $gateway->clear_name),true);
				$html .= $this->load->view('gateways/confirm_delete',array('gateway' => $gateway),true);
				$html .= $this->load->view('gateways/gateway_delete', array('gateway' => $gateway),true);
				$this->page->show($html);
			}
			elseif($status == 'execute') {
				 $referer = $this->agent->referrer();
				 if ($referer == base_url('gateways/delete/'.$name.'/confirm')) {
					 $this->gateway->deleteGateway($gateway);
					 redirect(base_url('gateways/'), 'refresh');
				 }
			}
			else {
				log_message('debug', '[Rooms/Delete]: Wrong status given (should be "confirm" or "execute" after successful confirmation)');
				redirect(base_url('gateways/'), 'refresh');
			}
		}

	}
}
