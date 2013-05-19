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
}
?>
