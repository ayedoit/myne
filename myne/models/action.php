<?php
Class action extends CI_Model {
	public function getActionByID($id) {
		$query = $this->db->get_where('actions',array('id' => $id));
		
		log_message('debug', 'Polling action with ID "'.$id.'" from database');
		
		$action = "";	
		foreach ($query->result() as $row)
		{
			$action = $row;
		}
		return $action;
	}

	public function addGroupAction($group_id,$action_id) {
		$query = $this->db->insert('group_has_action',array('group_id' => $group_id,'action_id' => $action_id));
		
		log_message('debug', 'Adding action with ID "'.$action_id.'" for group with ID "'.$group_id.'" to database');
		
		return $this->db->insert_id();
	}

	public function removeGroupAction($group_id,$action_id) {
		$query = $this->db->delete('group_has_action',array('group_id' => $group_id,'action_id' => $action_id));
		
		log_message('debug', 'Removing action with ID "'.$action_id.'" for group with ID "'.$group_id.'" from database');
	}
	
	public function removeDeviceActionRevokation($device_id,$action_id) {
		log_message('debug', 'Remvoving revoke of action with ID "'.$action_id.'" for device with ID "'.$device_id.'" from database');
		
		$this->db->delete('device_revoke_action', array('device_id' => $device->id, 'action_id' => $action_id));
	}
	
	public function getRevokedActions($device_id) {
		$query = $this->db->get_where('device_revoke_action', array('device_id' => $device_id));
		
		log_message('debug', 'Polling revoked device actions for device with ID "'.$device_id.'" from database');
		
		$actions = array();
		foreach ($query->result() as $row)
		{
			$action_data = $this->getActionByID($row->action_id);
			$actions[$action_data->name] = $action_data;
			
		}
		return $actions;
	}

	public function groupHasAction($group_name,$action_name) {
		log_message('debug', 'Determining if group with name "'.$group_name.'" has action "'.$action_name.'"');

		// Get device
		$this->load->model('devices/device');
		$group = $this->device->getGroupByName($group_name);

		// Check actions by group
		$actions = $this->getActionsByGroup($group->id);

		if (array_key_exists($action_name,$actions)) {
			// Device has requested action inherited from device type
			log_message('debug', 'Group with name "'.$group_name.'" has action "'.$action_name.'".');
			return true;
		}
		return false;
	}

	public function deviceTypeHasAction($device_type_name,$action_name) {
		log_message('debug', 'Determining if device type with name "'.$device_type_name.'" has action "'.$action_name.'"');

		// Get device type
		$this->load->model('devices/device');
		$device_type = $this->device->getDeviceTypeByName($device_type_name);

		// Check acton by device type
		$actions = $this->getActionsByDeviceType($device_type->id);

		if (array_key_exists($action_name,$actions)) {
			// Device has requested action inherited from device type
			log_message('debug', 'Device type with name "'.$device_type_name.'" has action "'.$action_name.'".');
			return true;
		}
		return false;
	}

	public function deviceHasAction($device_name,$action_name) {
		log_message('debug', 'Determining if device with name "'.$device_name.'" has action "'.$action_name.'"');

		// Get device
		$this->load->model('devices/device');
		$device = $this->device->getDeviceByName($device_name);

		// Check actions by device type
		$actions = $this->getActionsByDeviceType($device->type);

		if (array_key_exists($action_name,$actions)) {
			// Checking if action is revoked for this device specifically
			if (array_key_exists($action_name, $this->getRevokedActions($device->id))) {
				log_message('debug', 'Device with name "'.$device_name.'" has revoked action "'.$action_name.'".');
				return false;
			}
			return true;
		}
		return false;
	}

	public function getActionsByDeviceType($id) {
		$query = $this->db->get_where('device_type_has_action', array('device_type_id' => $id));
		
		log_message('debug', 'Polling device type actions for device type with ID "'.$id.'" from database');
		
		$actions = array();
		foreach ($query->result() as $row)
		{
			$action_data = $this->getActionByID($row->action_id);
			$actions[$action_data->name] = $action_data;
			
		}
		return $actions;
	}
	
	public function getActionsByGroup($id) {
		$query = $this->db->get_where('group_has_action', array('group_id' => $id));
		
		log_message('debug', 'Polling device group actions for device group with ID "'.$id.'" from database');
		
		$actions = array();
		foreach ($query->result() as $row)
		{
			$action_data = $this->getActionByID($row->action_id);
			$actions[$action_data->name] = $action_data;
			
		}
		return $actions;
	}

	public function getActionsByDevice($device_id) {
		// Get device
		$this->load->model('devices/device');
		$device = $this->device->getDeviceByID($device_id);

		log_message('debug', 'Polling possible actions for device with name "'.$device->name.'"');

		// Get Actions
		$actions = $this->getActions();

		$device_actions = array();

		foreach ($actions as $action) {
			if ($this->deviceHasAction($device->name,$action->name)) {
				$device_actions[] = $action;
			}
		}
		
		return $device_actions;
	}
	
	public function getActions() {
		$query = $this->db->get('actions');
		
		log_message('debug', 'Polling actions from database');
		
		$actions = array();
		foreach ($query->result() as $row)
		{
			$actions[] = $row;
			
		}
		return $actions;
	}

	public function getActionItemByID($id) {
		$query = $this->db->get_where('action_items', array('id' => $id));
		
		foreach ($query->result() as $row)
		{
			$action_item = $row;
		}
		log_message('debug', 'Polling action with id "'.$id.'" from actionlist');
		return $action_item;
	}

	public function getActionItems() {
		$query = $this->db->get('action_items');
		
		log_message('debug', 'Polling actionlist from database');
		
		$action_items = array();
		foreach ($query->result() as $row)
		{
			$action_items[] = $row;
			
		}
		return $action_items;
	}

	/*
		correct action data will look as follows (just like the JSON format for the API calls):

		$data = array(
			'method' => 'toggle',
			'params' => array(
				'model' => 'devices/device',
				'opts' => array(
					0 => 'Opt 1',
					1 => 'Opt 2',
					...
				)
			)
		);
	
	*/
	public function triggerAction($id="",$data="") {
		log_message('debug', 'Action triggered.');
		if (isset($id) && trim($id)!='') {
			// $id is set, so pull action from database
			$action_item = $this->getActionItemByID($id);

			log_message('debug', 'Action ID "'.$action_item->action_id.'"');

			// Get action data
			$data = $this->decodeAction($action_item->data);

			log_message('debug', 'Action data: '.print_r($data,true));

			// Get action method
			$method = $data->method;

			log_message('debug', 'Action method: '.$method);

			// Get action data
			$opts = $data->params->opts;

			log_message('debug', 'Action opts: '.print_r($opts,true));

			// Determine action type
			$action = $this->getActionByID($action_item->action_id);

			// Get action model
			$action_model = $action->model;

			log_message('debug', 'Action model: '.$action_model);

			$model = $this->load->model($action_model);
			try {
				log_message('debug', 'Executing action');
				$result = call_user_func_array(array($model,$method), $opts);
				
				return $result;
			} catch (Exception $e) {
				log_message('debug', 'Execution of action failed');
				show_error($e->getMessage());
			}
		}
		else {
			// Parse data
			$data = $this->decodeAction($data);

			log_message('debug', 'Action data: '.print_r($data,true));

			// Get action method
			$method = $data->method;

			log_message('debug', 'Action method: '.$method);

			// Get action data
			$opts = $data->params->opts;

			log_message('debug', 'Action opts: '.print_r($opts,true));

			// Get model from data
			$action_model = $data->params->model;

			log_message('debug', 'Action model: '.$action_model);

			$model = $this->load->model($action_model);
			try {
				log_message('debug', 'Executing action');
				$result = call_user_func_array(array($model,$method), $opts);
				
				return $result;
			} catch (Exception $e) {
				log_message('debug', 'Execution of action failed');
				show_error($e->getMessage());
			}
		}
		return false;
	}

	public function encodeAction($data) {
		return json_encode($data);
	}

	public function decodeAction($data) {
		return json_decode($data);
	}

	public function addActionItem($action_id,$data) {
		$query = $this->db->insert('action_items',array('action_id' => $action_id,'data' => $data));
		
		log_message('debug', 'Adding action item with action-ID "'.$action_id.'" to action items');
		
		return $this->db->insert_id();
	}
}