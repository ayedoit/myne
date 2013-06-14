<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Devices extends MY_Controller { 
	public function index(){
		$this->load->library('page');
		
		if ($this->agent->is_mobile()) {
			$html = $this->load->view('grouped_mobile',"",true);
			$this->page->show($html);
		}
		else {
			$html = $this->load->view('grouped',"",true);
			$this->page->show($html);
		}
	}
	
	public function update($type,$name){
		log_message('debug', '[Devices/Update]: Update via POST requested');
		if ($type == 'device') {
			$this->load->model('devices/device');
			try {
				$update = $this->device->updateDevice($name,$_POST['pk'],$_POST['value']);
				return true;
			} catch (Exception $e) {
				show_error($e->getMessage(), 500);
			}
		}
		elseif ($type == 'group') {
			$this->load->model('devices/device');
			try {
				$update = $this->device->updateGroup($name,$_POST['pk'],$_POST['value']);
				return true;
			} catch (Exception $e) {
				show_error($e->getMessage(), 500);
			}
		}		
	}
	
	public function grouped(){
		$this->load->library('page');
		
		if ($this->agent->is_mobile()) {
			$html = $this->load->view('grouped_mobile',"",true);
			$this->page->show($html);
		}
		else {
			$html = $this->load->view('grouped',"",true);
			$this->page->show($html);
		}
	}
	
	public function groups(){
		$this->load->library('page');

		$html = $this->load->view('groups',"",true);
		$this->page->show($html);
	}
	
	public function show($device){
		// Get device
		$this->load->model('device');
		$device = $this->device->getDeviceByName($device);

		if (empty($device) || sizeof($device) == 0) {
			show_404();
			die;
		}
			    
		$this->load->library('page');
		$html = $this->load->view('title',array('icon' => $device->icon,'title' => $device->clear_name),true);
		$html .= $this->load->view('device',array('device' => $device),true);
		$html .= $this->load->view('device_options', array('device' => $device),true);
		$this->page->show($html);
	}
	
	public function showgroup($group){
		// Get device
		$this->load->model('device');
		$group = $this->device->getGroupByName($group);

		if (empty($group) || sizeof($group) == 0) {
			show_404();
			die;
		}
			    
		$this->load->library('page');
		$html = $this->load->view('title',array('title' => $group->clear_name),true);
		$html .= $this->load->view('group',array('group' => $group),true);
		$this->page->show($html);
	}
	
	public function add($status) {
		if (empty($status) || trim($status) == '') {
			log_message('debug', '[Devices/Add]: No status given (should be "new" for new rooms or "validate" for validation)');
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
						'icon' => $_POST['devices_icon'],
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
						// Add Model
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
						$room_id = $this->room->addRoom($room_data);
						
						// Add Room ID to Device Data
						$device_data['room'] = $room_id;
					}
					else {
						// Use data from form
						$device_data['room'] = $_POST['devices_room'];
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
						$this->load->model('gateways/gateway');
						$gateway_id = $this->gateway->addGateway($gateway_data);
						
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
					
					// Group
					if (isset($_POST['add_group']) && $_POST['add_group'] == '1') {
						// Add Group
						$group_data = array(
							'name' => $_POST['groups_name'],
							'clear_name' => $_POST['groups_clear_name'],
							'description' => $_POST['groups_description']
						);
						
						// Add Group to DB
						$group_id = $this->device->addGroup($group_data);

						// Tasks / Options
						foreach($_POST['groups_options'] as $option_id) {
							$this->device->addGroupOption($group_id,$option_id);
						}
						
						// Add Device ID & Group ID to mapping table
						$this->device->addGroupMember($group_id, $device_id);
					}
					else {
						if (!empty($_POST['devices_group']) && sizeof($_POST['devices_group']) != 0) {
							foreach ($_POST['devices_group'] as $key => $group_id) {
								$member_data = array(
									"group_id" => $group_id,
									"device_id" => $device_id
								);
								$this->device->addGroupMember($group_id, $device_id);
							}
						}
					}
					
					// Done!
					redirect(base_url('devices/show/'.$device_data['name']), 'refresh');
				}
				else {
					log_message('debug', '[Devices/Add]: Validation requested but no data submitted');
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
	
	public function addgroup($status) {
		if (empty($status) || trim($status) == '') {
			log_message('debug', '[Devices/Addgroup]: No status given (should be "new" for new rooms or "validate" for validation)');
			redirect(base_url('devices/addgroup/new'), 'refresh');
		}
		else {
			if ($status == 'validate') {
				$this->load->model('device');
				if (isset($_POST['form']) && $_POST['form']=='1') {
					// Take form input and validate
					$group_data = array(
						'name' => $_POST['groups_name'],
						'clear_name' => $_POST['groups_clear_name'],
						'description' => $_POST['groups_description']
					);	

					// Insert!
					$group_id = $this->device->addGroup($group_data);

					// Tasks / Options
					foreach($_POST['groups_options'] as $option_id) {
						$this->device->addGroupOption($group_id,$option_id);
					}

					// Members
					if (sizeof($_POST['groups_devices']) != 0) {
						foreach ($_POST['groups_devices'] as $device) {
							$this->device->addGroupMember($group_id,$device);
						}
					}
					
					// Done!
					redirect(base_url('devices/showgroup/'.$group_data['name']), 'refresh');
				}
				else {
					log_message('debug', '[Devices/Addgroup]: Validation requested but no data submitted');
					redirect(base_url('devices/addgroup/new'), 'refresh');
				}
			}
			elseif ($status == 'new') {
				$this->load->library('page');
				$html = $this->load->view('title',array('title' => "Neue Gruppe anlegen"),true);
				$html .= $this->load->view('devices/group_add', array('status' => $status),true);
				$this->page->show($html);
			}
		}

	}
	
	public function delete($type,$name,$status) {
		$this->load->model('device');
		if ($type == 'device') {
			$device = $this->device->getDeviceByName($name);
		
			if (empty($status) || trim($status) == '') {
				log_message('debug', '[Devices/Delete]: No status given (should be "confirm" or "execute" after successful confirmation)');
				redirect(base_url('devices/show/'.$device->name), 'refresh');
			}
			else {
				if ($status == 'confirm') {
					$this->load->library('page');
					$html = $this->load->view('title',array('icon' => $device->icon,'title' => $device->clear_name),true);
					$html .= $this->load->view('devices/confirm_delete',array('device' => $device),true);
					$html .= $this->load->view('devices/device_delete', array('device' => $device),true);
					$this->page->show($html);
				}
				elseif($status == 'execute') {
					 $referer = $this->agent->referrer();
					 if ($referer == base_url('devices/delete/device/'.$name.'/confirm')) {
						 $this->device->deleteDevice($name);
						 redirect(base_url('devices/'), 'refresh');
					 }
				}
				else {
					log_message('debug', '[Devices/Delete]: Wrong status given (should be "confirm" or "execute" after successful confirmation)');
					redirect(base_url('devices/'), 'refresh');
				}
			}
		}
		elseif ($type == 'group') {
			$group = $this->device->getGroupByName($name);
		
			if (empty($status) || trim($status) == '') {
				log_message('debug', '[Devices/Delete]: No status given (should be "confirm" or "execute" after successful confirmation)');
				redirect(base_url('devices/showgroup/'.$group->name), 'refresh');
			}
			else {
				if ($status == 'confirm') {
					$this->load->library('page');
					$html = $this->load->view('title',array('title' => $group->clear_name),true);
					$html .= $this->load->view('devices/confirm_group_delete',array('group' => $group),true);
					$html .= $this->load->view('devices/group_delete', array('group' => $group),true);
					$this->page->show($html);
				}
				elseif($status == 'execute') {
					 $referer = $this->agent->referrer();
					 if ($referer == base_url('devices/delete/group/'.$name.'/confirm')) {
						 $this->device->deleteGroup($name);
						 redirect(base_url('devices/groups'), 'refresh');
					 }
				}
				else {
					log_message('debug', '[Rooms/Delete]: Wrong status given (should be "confirm" or "execute" after successful confirmation)');
					redirect(base_url('devices/groups'), 'refresh');
				}
			}
		}
	}
	
	public function view($view) {
		$this->load->view($view,"");
	}
	
}
