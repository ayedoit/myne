<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gateways extends MY_Controller { 
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

	public function test(){
		// Get device
		$this->load->model('gateways/kraken');

		$this->load->model('devices/device');
		$desk = $this->device->getDeviceByName('desk');

		$this->load->model('gateways/gateway');
		$gateway = $this->gateway->getGatewayByID($desk->gateway);

		echo "<pre>".print_r($desk,true)."</pre>";
		echo "<pre>".print_r($gateway,true)."</pre>";

		$msg = array(
			"interface_name" => "433",
			"vendor_name" => "intertechno",
			"model_name" => "itr1500",
			"master_dip" => $desk->masterdip,
			"slave_dip" => $desk->slavedip,
			"action" => "set_status",
			"status" => "off"
		);

		echo "<pre>".print_r($msg,true)."</pre>";

		$response = $this->kraken->send($desk,$msg,$gateway);
		var_dump($response);
	}
	
	public function add($status="") {
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
						'port' => $_POST['gateways_port']
					);		

					if ($_POST['gateways_room'] == 'latest') {
						$this->load->model('room');
						$latest_room = $this->room->getLatestRoom();
						
						$latest_room_id = $latest_room->id;
					}
					else {
						$latest_room_id = $_POST['gateways_room'];
					}

					$gateway_data['room'] = $latest_room_id;	

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
