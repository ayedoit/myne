<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class Devices extends MX_Controller { 
	function __construct(){
        parent::__construct();
        
        // Check Login
        if($this->tools->getSettingByName('login') == 'true') {
			$this->load->model('user');
			if(!$this->user->is_logged_in()) redirect('login', 'refresh');
		}
    }
	
	public function index(){
		$this->load->library('page');
		
		if ($this->agent->is_mobile()) {
			$html = $this->load->view('groups_mobile',"",true);
			$this->page->show($html);
		}
		else {
			$html = $this->load->view('groups',"",true);
			$this->page->show($html);
		}
	}
	
	public function groups(){
		$this->load->library('page');
		
		if ($this->agent->is_mobile()) {
			$html = $this->load->view('groups_mobile',"",true);
			$this->page->show($html);
		}
		else {
			$html = $this->load->view('groups',"",true);
			$this->page->show($html);
		}
	}
	
	public function show($device){
		// Get device
		$this->load->model('device');
		$device = $this->device->getDeviceByName($device);
			    
		$this->load->library('page');
		$html = $this->load->view('title',array('icon' => $this->device->getTypeByID($device->type),'title' => $device->clear_name),true);
		$html .= $this->load->view('device',array('device' => $device),true);
		$html .= $this->load->view('device_options', array('device' => $device),true);
		$this->page->show($html);
	}
	
	public function toggle($type,$name,$status){
	    $this->load->model('device');
	    $this->load->model('room');
    
	    switch ($type) {
			case 'device' : $devices = $this->device->getDevicesByName($name); break;
			case 'room' : $room = $this->room->getRoomByName($name); $devices = $this->device->getDevicesByRoom($room->id); break;
			case 'group' : $group = $this->device->getGroupByName($name); $devices = $this->device->getDevicesByGroup($group->id); break;
			case 'type' : $type = $this->device->getTypeByName($name); $devices = $this->device->getDevicesByType($type->id); break;
			default: return false;
		}
	    
	    if (!empty($devices) && sizeof($devices) != 0) {
	    
			// Toggle each Device
			foreach ($devices as $device) {	
				// Get options
				$options = $this->device->getOptionsByDeviceID($device->id);
				
				if (array_key_exists('toggle', $options)) {		
					// Get Vendor
					$vendor = $this->device->getVendorByID($device->vendor);
					
					// Create Message
					// Therefore determine device vendor
					switch ($vendor->name) {
						case 'elro':$this->load->model('elro'); $msg=$this->elro->msg($device,$status); break;
						case 'intertechno':$this->load->model('intertechno'); $msg=$this->intertechno->msg($device,$status); break;
						case 'xbmc':$msg=''; break;
						default: return 0;
					}
					
					// If the device has a gateway, send the message via the gateway
					if ($device->gateway != 0) {
						// Get Gateway
						$this->load->model('gateways/gateway');
						$gateway = $this->gateway->getGatewayByID($device->gateway);
												
						// Get Gateway Type
						$gateway_type = $this->gateway->getGatewayTypeByID($gateway->type);
						
						$this->load->model('gateways/'.strtolower($gateway_type->name),'gateway_model');
						$this->gateway_model->send($device, $msg, $gateway);		
					}
					// Otherwise, send directly to the device
					else {
						if ($vendor->name == 'xbmc') {
							if ($status == 'off') {
								// Create device URL
								$this->load->model('xbmc'); 
								$msg=$this->xbmc->msg($device,$status);
								
								$url = $device->user.":".$device->password."@".$device->address.":".$device->port."/jsonrpc";
								
								$this->load->model('devices/xbmc');
								$this->xbmc->send($msg, $url);
							}
							elseif ($status == 'on') {
								$this->load->model('wol');
								$response = $this->wol->WakeOnLan($device->address, $device->mac_address, $device->wol_port);
							}
						}
						else {
							continue;
						}
					}
				}
			}
		}
		
		if ($this->agent->is_referral())
		{
			redirect($this->agent->referrer(), 'refresh');
		}
		else {
			redirect(base_url(), 'refresh');
		}
	}
	
	public function type($type){
	    $this->load->model('device');
	    
	    // Get type ID
	    $device_type = $this->device->getTypeByName($type);
	    
	    $devices = $this->device->getDevicesByType($device_type->id);
	    
	    echo "<pre>".print_r($devices,true)."</pre>";
		die;
	    $this->load->library('page');
	    $html = $this->load->view('connair',"",true);
	    $this->page->show($html);
	}
	
	public function add($status) {
		if (empty($status) || trim($status) == '') {
			redirect(base_url('devices/add/new'), 'refresh');
		}
		else {
			if ($status == 'validate') {
				$this->load->model('device');
				if (isset($_POST['form']) && $_POST['form']=='1') {
					// Take form input and validate
					$device_data = array(
						'name' => $_POST['devices_name'],
						'clear_name' => $_POST['devices_clear_name'],
						'description' => $_POST['devices_description'],
						'type' => $_POST['devices_type']
					);
					
					// Vendor
					if (isset($_POST['add_vendor']) && $_POST['add_vendor'] == '1') {
						// Add Vendor
						$vendor_data = array(
							'name' => $_POST['vendors_name'],
							'clear_name' => $_POST['vendors_clear_name'],
							'description' => $_POST['vendors_description']
						);
						
						// Add Vendor to DB
						$this->load->model('vendor');
						$vendor_id = $this->vendor->addVendor($vendor_data);
						
						// Add Vendor ID to Device Data
						$device_data['vendor'] = $vendor_id;
					}
					else {
						// Use data from form
						$device_data['vendor'] = $_POST['devices_vendor'];
					}
					
					// Model
					if (isset($_POST['add_model']) && $_POST['add_model'] == '1') {
						// Add Vendor
						$model_data = array(
							'name' => $_POST['models_name'],
							'clear_name' => $_POST['models_clear_name'],
							'description' => $_POST['models_description'],
							'vendor_id' => $device_data['vendor']
						);
						
						// Add Model to DB
						$this->load->model('model');
						$model_id = $this->model->addModel($model_data);
						
						// Add Model ID to Device Data
						$device_data['model'] = $model_id;
					}
					else {
						// Use data from form
						$device_data['model'] = $_POST['devices_model'];
					}
					
					// Room
					if (isset($_POST['add_room']) && $_POST['add_room'] == '1') {
						// Add Room
						$room_data = array(
							'name' => $_POST['rooms_name'],
							'clear_name' => $_POST['rooms_clear_name'],
							'description' => $_POST['rooms_description']
						);
						
						// Add Room to DB
						$this->load->model('room');
						$room_id = $this->room->addModel($room_data);
						
						// Add Room ID to Device Data
						$device_data['room'] = $room_id;
					}
					else {
						// Use data from form
						$device_data['room'] = $_POST['devices_room'];
					}
					
					// Group
					if (isset($_POST['add_group']) && $_POST['add_group'] == '1') {
						// Add Room
						$group_data = array(
							'name' => $_POST['groups_name'],
							'clear_name' => $_POST['groups_clear_name'],
							'description' => $_POST['groups_description']
						);
						
						// Add Group to DB
						$this->load->model('device');
						$group_id = $this->device->addGroup($group_data);
						
						// Add Group ID to Device Data
						$device_data['group'] = $group_id;
					}
					else {
						// Use data from form
						$device_data['group'] = $_POST['devices_group'];
					}
					
					// Gateway
					if (isset($_POST['add_gateway']) && $_POST['add_gateway'] == '1') {
						// Add Gateway
						
						if ($_POST['gateways_room'] == 'latest') {
							$this->load->model('room');
							$latest_room = $this->room->getLatestRoom();
							
							$latest_room_id = $latest_room->id;
						}
						else {
							$latest_room_id = $_POST['gateways_room'];
						}
						
						$gateway_data = array(
							'name' => $_POST['gateways_name'],
							'clear_name' => $_POST['gateways_clear_name'],
							'description' => $_POST['gateways_description'],
							'type' => $_POST['gateways_type'],
							'address' => $_POST['gateways_address'],
							'port' => $_POST['gateways_port'],
							'room' => $latest_room_id
						);
						
						// Add Gateway to DB
						$this->load->model('gateway');
						$gateway_id = $this->gateway->addGroup($gateway_data);
						
						// Add Group ID to Device Data
						$device_data['gateway'] = $gateway_id;
					}
					else {
						// Use data from form
						$device_data['gateway'] = $_POST['devices_gateway'];
					}
					
					// Master DIP
					if (isset($_POST['devices_masterdip']) && trim($_POST['devices_masterdip'] != '')) {
						$device_data['masterdip'] = $_POST['devices_masterdip'];
					}
					
					// Slave DIP
					if (isset($_POST['devices_slavedip']) && trim($_POST['devices_slavedip'] != '')) {
						$device_data['slavedip'] = $_POST['devices_slavedip'];
					}
					
					// TX433 Version
					if (isset($_POST['devices_tx433version']) && trim($_POST['devices_tx433version'] != '')) {
						$device_data['tx433version'] = $_POST['devices_tx433version'];
					}
					
					// Address
					if (isset($_POST['devices_address']) && trim($_POST['devices_address'] != '')) {
						$device_data['address'] = $_POST['devices_address'];
					}
					
					// Port
					if (isset($_POST['devices_port']) && trim($_POST['devices_port'] != '')) {
						$device_data['port'] = $_POST['devices_port'];
					}
					
					// Port
					if (isset($_POST['devices_wol_port']) && trim($_POST['devices_wol_port'] != '')) {
						$device_data['wol_port'] = $_POST['devices_wol_port'];
					}
					
					// MAC Address
					if (isset($_POST['devices_mac_address']) && trim($_POST['devices_mac_address'] != '')) {
						$device_data['mac_address'] = $_POST['devices_mac_address'];
					}
					
					// User
					if (isset($_POST['devices_user']) && trim($_POST['devices_user'] != '')) {
						$device_data['user'] = $_POST['devices_user'];
					}
					
					// Password
					if (isset($_POST['devices_password']) && trim($_POST['devices_password'] != '')) {
						$device_data['password'] = $_POST['devices_password'];
					}			

					// Insert!
					$device_id = $this->device->addDevice($device_data);
					
					// Tasks / Options
					foreach($_POST['options'] as $option) {
						$this->device->addDeviceOptionPair($device_id,$option);
					}
					
					// Done!
					redirect(base_url('devices/show/'.$device_data['name']), 'refresh');
				}
				else {
					redirect(base_url('devices/add/new'), 'refresh');
				}
			}
			elseif ($status == 'new') {
				$this->load->library('page');
				$html = $this->load->view('title',array('title' => "Neues Gerät anlegen"),true);
				$html .= $this->load->view('devices/add', array('status' => $status),true);
				$this->page->show($html);
			}
		}

	}
	
	public function delete($name,$status) {
		
		$this->load->model('device');
		$device = $this->device->getDeviceByName($name);
		
		if (empty($status) || trim($status) == '') {
			redirect(base_url('devices/show/'.$device->name), 'refresh');
		}
		else {
			if ($status == 'confirm') {
				$this->load->library('page');
				$html = $this->load->view('title',array('icon' => $this->device->getTypeByID($device->type),'title' => $device->clear_name),true);
				$html .= $this->load->view('confirm_delete',array('device' => $device),true);
				$html .= $this->load->view('device_delete', array('device' => $device),true);
				$this->page->show($html);
			}
			elseif($status == 'execute') {
				 $referer = $this->agent->referrer();
				 if ($referer == base_url('devices/delete/'.$name.'/confirm')) {
					 $this->device->deleteDevice($name);
					 redirect(base_url('devices/'), 'refresh');
				 }
			}
			else {
				redirect(base_url('devices/'), 'refresh');
			}
		}

	}
	
	public function view($view) {
		$this->load->view($view,"");
	}
	
}
