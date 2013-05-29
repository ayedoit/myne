<?php
Class device extends CI_Model {
	/*
	 * 
	 * Devices
	 * 
	 */
	 
	public function getDevices() {
		$this->load->database();
		$query = $this->db->get('devices');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	 
	public function getDevicesByRoom($room) {
		$this->load->database();
		$query = $this->db->get_where('devices', array('room' => $room));
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDevicesByGroup($group) {
		$this->load->database();
		$query = $this->db->get_where('devices', array('group' => $group));
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDevicesByGateway($gateway) {
		$this->load->database();
		$query = $this->db->get_where('devices', array('gateway' => $gateway));
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDevicesByVendor($vendor) {
		$this->load->database();
		$query = $this->db->get_where('devices', array('vendor' => $vendor));
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDevicesByModel($model) {
		$this->load->database();
		$query = $this->db->get_where('devices', array('model' => $model));
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getTypeByName($name) {
		$this->load->database();
		$query = $this->db->get_where('device_types', array('name' => $name));
		
		foreach ($query->result() as $row)
		{
			$device_type = $row;
		}
		return $device_type;
	}
	
	public function getTypeByID($id) {
		$this->load->database();
		$query = $this->db->get_where('device_types', array('id' => $id));
		
		foreach ($query->result() as $row)
		{
			$device_type = $row;
		}
		return $device_type;
	}
	
	public function getDevicesByType($type) {
		$this->load->database();
		$query = $this->db->get_where('devices', array('type' => $type));
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDeviceTypes() {
		$this->load->database();
		$query = $this->db->get('device_types');
		
		$types = array();
		foreach ($query->result() as $row)
		{
			$types[] = $row;
		}
		return $types;
	}
	
	public function getDevicesByName($name) {
		$this->load->database();
		$this->db->select('*');
		$this->db->from('devices');
		$this->db->like('name',$name);
		$query = $this->db->get();
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDeviceByName($name) {
		$this->load->database();
		$query = $this->db->get_where('devices',array('name' => $name));
				
		foreach ($query->result() as $row)
		{
			$device = $row;
		}
		return $device;
	}
	
	public function getDevicesByID($ids) {
		$this->load->database();
		$this->db->select('*');
		$this->db->from('devices');
		$this->db->where_in('id', $ids);
		$query = $this->db->get();
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getVendorByID($id) {
		$this->load->database();
		$query = $this->db->get_where('vendors',array('id' => $id));
				
		foreach ($query->result() as $row)
		{
			$vendor = $row;
		}
		return $vendor;
	}
	
	public function getGroups() {
		$this->load->database();
		$query = $this->db->get('device_groups');
		
		$groups = array();
		foreach ($query->result() as $row)
		{
			$groups[] = $row;
		}
		return $groups;
	}
	
	public function getGroupByName($name) {
		$this->load->database();
		$query = $this->db->get_where('device_groups',array('name' => $name));
				
		foreach ($query->result() as $row)
		{
			$group = $row;
		}
		return $group;
	}
	
	public function getGroupByID($id) {
		$this->load->database();
		$query = $this->db->get_where('device_groups',array('id' => $id));
				
		$group = "";
		foreach ($query->result() as $row)
		{
			$group = $row;
		}
		return $group;
	}
	
	public function getOptionByID($id) {
		$this->load->database();
		$query = $this->db->get_where('device_options',array('id' => $id));
				
		foreach ($query->result() as $row)
		{
			$option = $row;
		}
		return $option;
	}
	
	public function addDeviceOptionPair($device_id,$option_id) {
		$query = $this->db->insert('device_has_option',array('device_id' => $device_id,'option_id' => $option_id));
		return $this->db->insert_id();
	}
	
	public function getOptionsByDeviceID($id) {
		$query = $this->db->get_where('device_has_option', array('device_id' => $id));
		
		$options = array();
		foreach ($query->result() as $row)
		{
			$option_data = $this->getOptionByID($row->option_id);
			$options[$option_data->name] = $option_data;
			
		}
		return $options;
	}
	
	public function getOptionsByGroupID($id) {
		$query = $this->db->get_where('group_has_option', array('group_id' => $id));
		
		$options = array();
		foreach ($query->result() as $row)
		{
			$option_data = $this->getOptionByID($row->option_id);
			$options[$option_data->name] = $option_data;
			
		}
		return $options;
	}
	
	public function getOptions() {
		$query = $this->db->get('device_options');
		
		$options = array();
		foreach ($query->result() as $row)
		{
			$options[] = $row;
			
		}
		return $options;
	}
	
	public function addGroup($data) {
		$this->db->insert('groups', $data); 
		return $this->db->insert_id();
	}
	
	public function addDevice($data) {
		$this->db->insert('devices', $data); 
		return $this->db->insert_id();
	}
	
	public function deleteDevice($name) {
		// Delete device options
		$device = $this->getDeviceByName($name);
		$this->db->delete('device_has_option', array('device_id' => $device->id)); 
		
		// Delete device
		$this->db->delete('devices', array('name' => $name)); 
	}
	
	public function updateDevice($name,$what,$new_value) {
		$data = array(
		   $what => $new_value
		);

		$this->db->where('name', $name);
		try {
			$this->db->update('devices', $data);
			return true;
		}  catch (Exception $e) {
			throw new Exception($e->getMessage());
		} 
	}
	
	public function toggle($type,$name,$status){
	    $this->load->model('room');
	    $this->load->model('gateways/gateway');
		
	    switch ($type) {
			case 'device' : $devices = $this->getDevicesByName($name); break;
			case 'room' : $room = $this->room->getRoomByName($name); $devices = $this->device->getDevicesByRoom($room->id); break;
			case 'group' : $group = $this->getGroupByName($name); $devices = $this->device->getDevicesByGroup($group->id); break;
			case 'type' : $type = $this->getTypeByName($name); $devices = $this->device->getDevicesByType($type->id); break;
			case 'gateway' : $type = $this->gateway->getGatewayByName($name); $devices = $this->device->getDevicesByGateway($type->id); break;
			default: return false;
		}
	    
	    if (!empty($devices) && sizeof($devices) != 0) {
	    
			// Toggle each Device
			foreach ($devices as $device) {	
				// Get options
				$options = $this->getOptionsByDeviceID($device->id);
				
				if (array_key_exists('toggle', $options)) {		
					// Get Vendor
					$vendor = $this->getVendorByID($device->vendor);
					
					// Create Message
					// Therefore determine device vendor
					switch ($vendor->name) {
						case 'elro':
							$this->load->model('devices/elro'); 
							try {
								$msg = $this->elro->msg($device,$status); 
							} catch (Exception $e) {
								show_error($e->getMessage());
							}
							break;
						case 'intertechno':
							$this->load->model('devices/intertechno'); 
							try {
								$msg = $this->intertechno->msg($device,$status); 
							} catch (Exception $e) {
								show_error($e->getMessage());
							}
							break;
						case 'xbmc':
							$msg=''; 
							break;
						default: 
							return 0;
					}
					
					// If the device has a gateway, send the message via the gateway
					if ($device->gateway != 0) {
						// Get Gateway
						$this->load->model('gateways/gateway');
						$gateway = $this->gateway->getGatewayByID($device->gateway);
												
						// Get Gateway Type
						$gateway_type = $this->gateway->getGatewayTypeByID($gateway->type);
						
						$this->load->model('gateways/'.strtolower($gateway_type->name),'gateway_model');
						try {
							$this->gateway_model->send($device, $msg, $gateway);
						} catch (Exception $e) {
							show_error($e->getMessage());
						}	
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
		else {
			throw new Exception('Kein Gerät zum Schalten angegeben.');
			die;
		}
		return true;
	}
}
?>
