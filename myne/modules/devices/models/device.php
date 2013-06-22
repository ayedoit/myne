<?php
Class device extends CI_Model {
	/*
	 * 
	 * Devices
	 * 
	 */
	 
	public function getDevices() {
		$query = $this->db->get('devices');
		
		log_message('debug', 'Polling devices from database');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	 
	public function getDevicesByRoom($room) {
		$query = $this->db->get_where('devices', array('room' => $room));
		
		log_message('debug', 'Polling devices in room "'.$room.'" from database');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDevicesWithoutRoom() {
		$query = $this->db->get_where('devices', array('room' => "0"));
		
		log_message('debug', 'Polling devices without room from database');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDevicesWithoutGateway() {
		$query = $this->db->get_where('devices', array('gateway' => "0"));
		
		log_message('debug', 'Polling devices without gateway from database');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDevicesByGroup($group) {		
		$this->db->select('*');
		$this->db->from('devices');
		$this->db->join('device_group_members', 'device_group_members.device_id = devices.id AND device_group_members.group_id = "'.$group.'"');
		
		$query = $this->db->get();
		
		log_message('debug', 'Polling devices in group with ID "'.$group.'" from database');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getGroupsByDevice($device) {		
		$this->db->select('*');
		$this->db->from('device_groups');
		$this->db->join('device_group_members', 'device_group_members.group_id = device_groups.id AND device_group_members.device_id = "'.$device.'"');
		
		$query = $this->db->get();
		
		log_message('debug', 'Polling groups with device with id "'.$device.'" in it from database');
		
		$groups = array();
		foreach ($query->result() as $row)
		{
			$groups[] = $row;
		}
		return $groups;
	}
	
	public function getDevicesByGateway($gateway) {
		$query = $this->db->get_where('devices', array('gateway' => $gateway));
		
		log_message('debug', 'Polling devices with gateway with ID "'.$gateway.'" from database');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDevicesByVendor($vendor) {
		$query = $this->db->get_where('devices', array('vendor' => $vendor));
		
		log_message('debug', 'Polling devices from vendor with ID "'.$denvor.'" from database');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDevicesByModel($model) {
		$query = $this->db->get_where('devices', array('model' => $model));
		
		log_message('debug', 'Polling devices of model with ID "'.$model.'" from database');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getTypeByName($name) {
		$query = $this->db->get_where('device_types', array('name' => $name));
		
		log_message('debug', 'Polling device type with name "'.$name.'" from database');
		
		$device_type = "";
		foreach ($query->result() as $row)
		{
			$device_type = $row;
		}
		return $device_type;
	}
	
	public function getTypeByID($id) {
		$query = $this->db->get_where('device_types', array('id' => $id));
		
		log_message('debug', 'Polling device type with ID "'.$id.'" from database');
		
		$device_type = "";
		foreach ($query->result() as $row)
		{
			$device_type = $row;
		}
		return $device_type;
	}
	
	public function getDevicesByType($type) {
		$query = $this->db->get_where('devices', array('type' => $type));
		
		log_message('debug', 'Polling devices of type with ID "'.$type.'" from database');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDeviceTypes() {
		$query = $this->db->get('device_types');
		
		log_message('debug', 'Polling device types from database');
		
		$device_types = array();
		foreach ($query->result() as $row)
		{
			$device_types[] = $row;
		}
		return $device_types;
	}
	
	public function getDevicesByName($name) {
		$this->db->select('*');
		$this->db->from('devices');
		$this->db->like('name',$name);
		$query = $this->db->get();
		
		log_message('debug', 'Polling devices with name like "'.$name.'" from database');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}
	
	public function getDeviceByName($name) {
		$query = $this->db->get_where('devices',array('name' => $name));
				
		log_message('debug', 'Polling device with name "'.$name.'" from database');
		
		$device = "";
		foreach ($query->result() as $row)
		{
			$device = $row;
		}
		return $device;
	}

	public function getDeviceByID($id) {
		$query = $this->db->get_where('devices',array('id' => $id));
				
		log_message('debug', 'Polling device with id "'.$id.'" from database');
		
		$device = "";
		foreach ($query->result() as $row)
		{
			$device = $row;
		}
		return $device;
	}

	public function getDeviceTypeByName($name) {
		$query = $this->db->get_where('device_types',array('name' => $name));
				
		log_message('debug', 'Polling device type with name "'.$name.'" from database');
		
		$device_type = "";
		foreach ($query->result() as $row)
		{
			$device_type = $row;
		}
		return $device_type;
	}
	
	public function getDevicesByID($ids) {
		$this->db->select('*');
		$this->db->from('devices');
		$this->db->where_in('id', $ids);
		$query = $this->db->get();
		
		log_message('debug', 'Polling devices with IDs "'.$ids.'" from database');
		
		$devices = array();
		foreach ($query->result() as $row)
		{
			$devices[] = $row;
		}
		return $devices;
	}

	public function getDevicesByActions($actions) {
		$devices = $this->getDevices();

		$return = array();
		foreach($devices as $device) {
			$device_has_actions = true;
			foreach($actions as $action) {
				$this->load->model('action');
				$r_action = $this->action->getActionByID($action);

				// Check if device has option
				if (!$this->action->deviceHasAction($device->name,$r_action->name)) {
					$device_has_actions = false;
				}
			}
			if ($device_has_actions) {
				$return[] = $device;
			}
		}

		return $return;
	}
	
	public function getVendorByID($id) {
		$query = $this->db->get_where('vendors',array('id' => $id));
		
		log_message('debug', 'Polling vendor with ID "'.$id.'" from database');
		
		$vendor = "";		
		foreach ($query->result() as $row)
		{
			$vendor = $row;
		}
		return $vendor;
	}
	
	public function getGroups() {
		$query = $this->db->get('device_groups');
		
		log_message('debug', 'Polling device groups from database');
		
		$groups = array();
		foreach ($query->result() as $row)
		{
			$groups[] = $row;
		}
		return $groups;
	}
	
	public function getGroupByName($name) {
		$query = $this->db->get_where('device_groups',array('name' => $name));
				
		log_message('debug', 'Polling device group with name "'.$name.'" from database');
		
		$group ="";
		foreach ($query->result() as $row)
		{
			$group = $row;
		}
		return $group;
	}
	
	public function getGroupByID($id) {
		$query = $this->db->get_where('device_groups',array('id' => $id));
		
		log_message('debug', 'Polling device group with ID "'.$id.'" from database');
				
		$group = "";
		foreach ($query->result() as $row)
		{
			$group = $row;
		}
		return $group;
	}	
	
	public function addGroup($data) {
		log_message('debug', 'Adding device group with name "'.$data['clear_name'].'" to database');
		
		$this->db->insert('device_groups', $data); 
		return $this->db->insert_id();
	}
	
	public function addGroupMember($group_id,$device_id) {
		$data = array(
			'group_id' => $group_id,
			'device_id' => $device_id
		);
		
		log_message('debug', 'Adding device with ID "'.$group_id.'" to device group with ID "'.$device_id.'" to database');
		
		$this->db->insert('device_group_members', $data); 
	}
	
	public function removeGroupMember($group_id,$device_id) {
		log_message('debug', 'Removing device with ID "'.$device_id.'" from device group with ID "'.$group_id.'" from database');
		
		$this->db->delete('device_group_members', array('group_id' => $group_id,'device_id' => $device_id)); 
	}
	
	public function deviceHasGroup($group_id,$device_id) {
		log_message('debug', 'Check if device with ID "'.$device_id.'" is member of device group with ID "'.$group_id.'"');
		
		$query = $this->db->get_where('device_group_members', array('group_id' => $group_id,'device_id' => $device_id));
		
		if ($query->num_rows() >= 1) {
			return true;
			log_message('debug', 'Result: TRUE');
		}
		else {
			return false;
			log_message('debug', 'Result: FALSE');
		}
	}
	
	public function addDevice($data) {
		$this->db->insert('devices', $data); 
		
		log_message('debug', 'Adding device with name "'.$data['clear_name'].'" to database');
		
		return $this->db->insert_id();
	}
	
	public function deleteDevice($name) {	
		// Delete device options
		$device = $this->getDeviceByName($name);
		log_message('debug', 'Attempting to remove device with name "'.$device->clear_name.'" from database...');
		
		
		log_message('debug', 'Removing device options for device with ID "'.$device->id.'" from database');
		$this->load->model('action');
		$actions = $this->action->getRevokedActions($device->id);
		
		if (sizeof($actions) != 0) {
			foreach ($actions as $action) {
				$this->removeDeviceActionRevokation($device->id,$action->id);
			}
		}
		
		// Delete device
		$this->db->delete('devices', array('name' => $name)); 
		log_message('debug', 'Removing device with name "'.$device->clear_name.'" from database');
	}
	
	public function updateDevice($name,$what,$new_value) {
		$data = array(
		   $what => $new_value
		);
		
		$this->db->where('name', $name);
		try {
			$this->db->update('devices', $data);
			log_message('debug', 'Updating device with name "'.$name.'", setting "'.$what.'" to "'.$new_value.'" in database');
			return true;
		}  catch (Exception $e) {
			log_message('debug', 'Updating device with name "'.$name.'", setting "'.$what.'" to "'.$new_value.'" in database NOT successful: "'.$e->getMessage().'"');
			throw new Exception($e->getMessage());
		} 
	}

	public function updateGroup($name,$what,$new_value) {
		$data = array(
		   $what => $new_value
		);
		
		$this->db->where('name', $name);
		try {
			$this->db->update('device_groups', $data);
			log_message('debug', 'Updating group with name "'.$name.'", setting "'.$what.'" to "'.$new_value.'" in database');
			return true;
		}  catch (Exception $e) {
			log_message('debug', 'Updating group with name "'.$name.'", setting "'.$what.'" to "'.$new_value.'" in database NOT successful: "'.$e->getMessage().'"');
			throw new Exception($e->getMessage());
		} 
	}
	
	public function deleteGroup($name) {
		log_message('debug', 'Attempting to remove device group with name "'.$name.'" from database...');
		
		// Find group members
		$group = $this->getGroupByName($name);
		
		log_message('debug', 'Searching for members of device group with name "'.$name.'"');
		$devices = $this->getDevicesByGroup($group->id);
		
		// Remove members
		if (sizeof($devices != 0)) {
			foreach($devices as $device) {
				$this->removeGroupMember($group->id,$device->id);
			}
		}
		
		// Remove options
		$this->load->model('action');
		$actions = $this->action->getActionsByGroup($group->id);
		
		if (sizeof($actions) != 0) {
			foreach ($actions as $action) {
				$this->action->removeGroupAction($group->id,$action->id);
			}
		}

		// Delete group
		log_message('debug', 'Removing device group with name "'.$name.'" from database');
		$this->db->delete('device_groups', array('name' => $name)); 
	}

	public function dipIsUnique($masterdip,$slavedip) {
		
		log_message('debug', 'Checking if Master DIP /Slave DIP combination is unique');
		
		$query = $this->db->get_where('devices',array('masterdip' => $masterdip, 'slavedip' => $slavedip));
		
		if ($query->num_rows != 0) {
			return "false";
		}
		return "true";
	}
	
	public function toggle($type,$name,$status){
	    $this->load->model('room');
	    $this->load->model('gateways/gateway');
	    
	    log_message('debug', 'Attempting to toggle '.$type.' with name "'.$name.'" - Status: "'.$status.'"');
		
	    switch ($type) {
			case 'device' : $devices = array('0' => $this->getDeviceByName($name)); break;
			case 'room' : $room = $this->room->getRoomByName($name); $devices = $this->device->getDevicesByRoom($room->id); break;
			case 'group' : $group = $this->getGroupByName($name); $devices = $this->device->getDevicesByGroup($group->id); break;
			case 'type' : $type = $this->getTypeByName($name); $devices = $this->device->getDevicesByType($type->id); break;
			case 'gateway' : $type = $this->gateway->getGatewayByName($name); $devices = $this->device->getDevicesByGateway($type->id); break;
			default: return false;
		}
	    
	    if (!empty($devices) && sizeof($devices) != 0) {
	    
			// Toggle each Device
			foreach ($devices as $device) {	
				
				log_message('debug', '['.$device->clear_name.'] Attempting to set status "'.$status.'"');
				log_message('debug', '['.$device->clear_name.'] Checking permissions');
				
				// If device has option "set_status", set the status it
				$this->load->model('action');
				if ($this->action->deviceHasAction($device->name,"set_status")) {	
					log_message('debug', '['.$device->clear_name.'] Has option "set_status"');
						
					// Get Vendor
					$vendor = $this->getVendorByID($device->vendor);
					
					log_message('debug', '['.$device->clear_name.'] Is from vendor "'.$vendor->clear_name.'"');
					log_message('debug', '['.$device->clear_name.'] Creating vendor-/type-specific message');
					
					// Create Message
					// Therefore determine device vendor
					switch ($vendor->name) {
						case 'elro':
							$this->load->model('devices/elro'); 
							try {
								$msg = $this->elro->msg($device,$status); 
								log_message('debug', '['.$device->clear_name.'] Message: "'.$msg.'"');
							} catch (Exception $e) {
								log_message('debug', '['.$device->clear_name.'] Could not generate message: "'.$e->getMessage().'"');
								throw new Exception($e->getMessage());
							}
							break;
						case 'pollin':
							$this->load->model('devices/pollin'); 
							try {
								$msg = $this->pollin->msg($device,$status); 
								log_message('debug', '['.$device->clear_name.'] Message: "'.$msg.'"');
							} catch (Exception $e) {
								log_message('debug', '['.$device->clear_name.'] Could not generate message: "'.$e->getMessage().'"');
								throw new Exception($e->getMessage());
							}
							break;
						case 'intertechno':
							$this->load->model('devices/intertechno'); 
							try {
								$msg = $this->intertechno->msg($device,$status); 
								log_message('debug', '['.$device->clear_name.'] Message: "'.$msg.'"');
							} catch (Exception $e) {
								log_message('debug', '['.$device->clear_name.'] Could not generate message: "'.$e->getMessage().'"');
								throw new Exception($e->getMessage());
							}
							break;
						case 'xbmc':
							$msg=''; 
							log_message('debug', '['.$device->clear_name.'] Is of type XBMC. No message needed');
							break;
						default: 
							return 0;
					}
					
					// If the device has a gateway, send the message via the gateway
					if ($device->gateway != 0) {
						log_message('debug', '['.$device->clear_name.'] Gateway needed');
						
						// Get Gateway
						$this->load->model('gateways/gateway');
						$gateway = $this->gateway->getGatewayByID($device->gateway);
						
						log_message('debug', '['.$device->clear_name.'] Gateway: "'.$gateway->clear_name.'"');
									
						// Get Gateway Type
						$gateway_type = $this->gateway->getGatewayTypeByID($gateway->type);
						
						log_message('debug', '['.$device->clear_name.'] Gateway is of type "'.$gateway_type->clear_name.'"');
						
						$this->load->model('gateways/'.strtolower($gateway_type->name),'gateway_model');
						try {
							log_message('debug', '['.$device->clear_name.'] Attempting to send message to Gateway "'.$gateway->clear_name.'"');
							$this->gateway_model->send($device, $msg, $gateway);
						} catch (Exception $e) {
							log_message('debug', '['.$device->clear_name.'] Error: Could not send message to Gateway "'.$gateway->clear_name.'"');
							throw new Exception($e->getMessage());
						}	
					} # Device needs gateway for communication
					// Otherwise, send directly to the device
					else {
						log_message('debug', '['.$device->clear_name.'] No Gateway needed');
						if ($vendor->name == 'xbmc') {
							log_message('debug', '['.$device->clear_name.'] Device is of type XBMC');
							if ($status == 'off') {
								// Create device URL
								$this->load->model('xbmc'); 
								$msg=$this->xbmc->msg($device,$status);
								
								$url = $device->user.":".$device->password."@".$device->address.":".$device->port."/jsonrpc";
								
								$this->load->model('devices/xbmc');
								log_message('debug', '['.$device->clear_name.'] Attempting to send message to device');
								
								try {
									$this->xbmc->send($msg, $url);
								} catch (Exception $e) {
									log_message('debug', '['.$device->clear_name.'] Could net send message to device: "'.$e->getMessage().'"');
									throw new Exception($e->getMessage());
								}
							} # Status "off"
							elseif ($status == 'on') {
								$this->load->model('wol');
								log_message('debug', '['.$device->clear_name.'] Attempting to wake device via Wake on LAN');
								
								try {
									$response = $this->wol->WakeOnLan($device->address, $device->mac_address, $device->wol_port);
								} catch (Exception $e) {
									log_message('debug', '['.$device->clear_name.'] Could net send message to device: "'.$e->getMessage().'"');
									throw new Exception($e->getMessage());
								}
							} # Status "on"
						} # Device vendor is xbmc
						else {
							log_message('debug', '['.$device->clear_name.'] Device is of undefined type. Nothing to do here');
							continue;
						} # Device vendor is not xbmc
					} # Device needs no gateway for communication
				} # Has option "toggle"
				else {
					log_message('debug', '['.$device->clear_name.'] Does not have option "toggle". Nothing to do here');
				}
			} # foreach
		} # Device array contains devices
		else {
			log_message('debug', 'No devices given. Nothing to do here');
			throw new Exception('Kein Gerät zum Schalten angegeben.');
			die;
		} # Device array contains no devices
		return true;
	}

	public function set_status($type,$name,$status){
	    $this->load->model('room');
	    $this->load->model('gateways/gateway');
	    
	    log_message('debug', 'Attempting to toggle '.$type.' with name "'.$name.'" - Status: "'.$status.'"');
		
	    switch ($type) {
			case 'device' : $devices = array('0' => $this->getDeviceByName($name)); break;
			case 'room' : $room = $this->room->getRoomByName($name); $devices = $this->device->getDevicesByRoom($room->id); break;
			case 'group' : $group = $this->getGroupByName($name); $devices = $this->device->getDevicesByGroup($group->id); break;
			case 'type' : $type = $this->getTypeByName($name); $devices = $this->device->getDevicesByType($type->id); break;
			case 'gateway' : $type = $this->gateway->getGatewayByName($name); $devices = $this->device->getDevicesByGateway($type->id); break;
			default: return false;
		}
	    
	    if (!empty($devices) && sizeof($devices) != 0) {
	    
			// Toggle each Device
			foreach ($devices as $device) {	
				
				log_message('debug', '['.$device->clear_name.'] Attempting to set status "'.$status.'"');
				log_message('debug', '['.$device->clear_name.'] Checking permissions');
				
				// If device has option "set_status", set the status it
				$this->load->model('action');
				if ($this->action->deviceHasAction($device->name,"set_status")) {	
					log_message('debug', '['.$device->clear_name.'] Has option "set_status"');
						
					// Get Vendor
					$vendor = $this->getVendorByID($device->vendor);
					
					log_message('debug', '['.$device->clear_name.'] Is from vendor "'.$vendor->clear_name.'"');
					log_message('debug', '['.$device->clear_name.'] Creating vendor-/type-specific message');
					
					// Create Message
					// Therefore determine device vendor
					switch ($vendor->name) {
						case 'elro':
							$this->load->model('devices/elro'); 
							try {
								$msg = $this->elro->msg($device,$status); 
								log_message('debug', '['.$device->clear_name.'] Message: "'.$msg.'"');
							} catch (Exception $e) {
								log_message('debug', '['.$device->clear_name.'] Could not generate message: "'.$e->getMessage().'"');
								throw new Exception($e->getMessage());
							}
							break;
						case 'pollin':
							$this->load->model('devices/pollin'); 
							try {
								$msg = $this->pollin->msg($device,$status); 
								log_message('debug', '['.$device->clear_name.'] Message: "'.$msg.'"');
							} catch (Exception $e) {
								log_message('debug', '['.$device->clear_name.'] Could not generate message: "'.$e->getMessage().'"');
								throw new Exception($e->getMessage());
							}
							break;
						case 'intertechno':
							$this->load->model('devices/intertechno'); 
							try {
								$msg = $this->intertechno->msg($device,$status); 
								log_message('debug', '['.$device->clear_name.'] Message: "'.$msg.'"');
							} catch (Exception $e) {
								log_message('debug', '['.$device->clear_name.'] Could not generate message: "'.$e->getMessage().'"');
								throw new Exception($e->getMessage());
							}
							break;
						case 'xbmc':
							$msg=''; 
							log_message('debug', '['.$device->clear_name.'] Is of type XBMC. No message needed');
							break;
						default: 
							return 0;
					}
					
					// If the device has a gateway, send the message via the gateway
					if ($device->gateway != 0) {
						log_message('debug', '['.$device->clear_name.'] Gateway needed');
						
						// Get Gateway
						$this->load->model('gateways/gateway');
						$gateway = $this->gateway->getGatewayByID($device->gateway);
						
						log_message('debug', '['.$device->clear_name.'] Gateway: "'.$gateway->clear_name.'"');
									
						// Get Gateway Type
						$gateway_type = $this->gateway->getGatewayTypeByID($gateway->type);
						
						log_message('debug', '['.$device->clear_name.'] Gateway is of type "'.$gateway_type->clear_name.'"');
						
						$this->load->model('gateways/'.strtolower($gateway_type->name),'gateway_model');
						try {
							log_message('debug', '['.$device->clear_name.'] Attempting to send message to Gateway "'.$gateway->clear_name.'"');
							$this->gateway_model->send($device, $msg, $gateway);
						} catch (Exception $e) {
							log_message('debug', '['.$device->clear_name.'] Error: Could not send message to Gateway "'.$gateway->clear_name.'"');
							throw new Exception($e->getMessage());
						}	
					} # Device needs gateway for communication
					// Otherwise, send directly to the device
					else {
						log_message('debug', '['.$device->clear_name.'] No Gateway needed');
						if ($vendor->name == 'xbmc') {
							log_message('debug', '['.$device->clear_name.'] Device is of type XBMC');
							if ($status == 'off') {
								// Create device URL
								$this->load->model('xbmc'); 
								$msg=$this->xbmc->msg($device,$status);
								
								$url = $device->user.":".$device->password."@".$device->address.":".$device->port."/jsonrpc";
								
								$this->load->model('devices/xbmc');
								log_message('debug', '['.$device->clear_name.'] Attempting to send message to device');
								
								try {
									$this->xbmc->send($msg, $url);
								} catch (Exception $e) {
									log_message('debug', '['.$device->clear_name.'] Could net send message to device: "'.$e->getMessage().'"');
									throw new Exception($e->getMessage());
								}
							} # Status "off"
							elseif ($status == 'on') {
								$this->load->model('wol');
								log_message('debug', '['.$device->clear_name.'] Attempting to wake device via Wake on LAN');
								
								try {
									$response = $this->wol->WakeOnLan($device->address, $device->mac_address, $device->wol_port);
								} catch (Exception $e) {
									log_message('debug', '['.$device->clear_name.'] Could net send message to device: "'.$e->getMessage().'"');
									throw new Exception($e->getMessage());
								}
							} # Status "on"
						} # Device vendor is xbmc
						else {
							log_message('debug', '['.$device->clear_name.'] Device is of undefined type. Nothing to do here');
							continue;
						} # Device vendor is not xbmc
					} # Device needs no gateway for communication
				} # Has option "toggle"
				else {
					log_message('debug', '['.$device->clear_name.'] Does not have option "toggle". Nothing to do here');
				}
			} # foreach
		} # Device array contains devices
		else {
			log_message('debug', 'No devices given. Nothing to do here');
			throw new Exception('Kein Gerät zum Schalten angegeben.');
			die;
		} # Device array contains no devices
		return true;
	}
}
?>
