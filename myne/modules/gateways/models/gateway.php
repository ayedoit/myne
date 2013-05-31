<?php
Class gateway extends CI_Model {
	
	/*
	 * 
	 * Gateways
	 * 
	 */
	
	public function getGateways() {
		$query = $this->db->get('gateways');
		
		log_message('debug', 'Polling gateways from database');
		
		$gateways = array();
		foreach ($query->result() as $row)
		{
			$gateways[] = $row;
		}
		return $gateways;
	}
	
	public function getGatewaysByRoom($room) {
		$query = $this->db->get_where('gateways', array('room' => $room));
		
		log_message('debug', 'Polling gateways in room with ID "'.$room.'" from database');
		
		$gateways = array();
		foreach ($query->result() as $row)
		{
			$gateways[] = $row;
		}
		return $gateways;
	}
	
	public function getGatewaysByGroup($group) {
		$query = $this->db->get_where('gateways', array('group' => $group));
		
		log_message('debug', 'Polling gateways with group with ID "'.$group.'" from database');
		
		$gateways = array();
		foreach ($query->result() as $row)
		{
			$gateways[] = $row;
		}
		return $gateways;
	}
	
	public function getGatewaysByName($name) {
		$this->db->select('*');
		$this->db->from('gateways');
		$this->db->like('name',$name);
		$query = $this->db->get();
		
		log_message('debug', 'Polling gateways with name like "'.$name.'" from database');
		
		$gateways = array();
		foreach ($query->result() as $row)
		{
			$gateways[] = $row;
		}
		return $gateways;
	}
	
	public function getGatewayByName($name) {
		$query = $this->db->get_where('gateways', array('name' => $name));
		
		log_message('debug', 'Polling gateway with name "'.$name.'" from database');

		foreach ($query->result() as $row)
		{
			$gateway = $row;
		}
		return $gateway;
	}
	
	public function getGatewaysByID($ids) {
		$this->db->select('*');
		$this->db->from('gateways');
		$this->db->where_in('id', $ids);
		$query = $this->db->get();
		
		log_message('debug', 'Polling gateways with IDs "'.$ids.'" from database');
		
		$gateways = array();
		foreach ($query->result() as $row)
		{
			$gateways[] = $row;
		}
		return $gateways;
	}
	
	public function getGatewayTypeByID($id) {
		$query = $this->db->get_where('gateway_types', array('id' => $id));
		
		log_message('debug', 'Polling gateway type with ID "'.$id.'" from database');
		
		foreach ($query->result() as $row)
		{
			$gateway_type = $row;
		}
		return $gateway_type;
	}
	
	public function getGatewayByID($id) {
		$query = $this->db->get_where('gateways', array('id' => $id));
		
		log_message('debug', 'Polling gateway with ID "'.$id.'" from database');
		
		foreach ($query->result() as $row)
		{
			$gateway = $row;
		}
		return $gateway;
	}
	
	public function getGatewayTypes() {
		$query = $this->db->get('gateway_types');
		
		log_message('debug', 'Polling gateway types from database');
		
		$types = array();
		foreach ($query->result() as $row)
		{
			$types[] = $row;
		}
		return $types;
	}
	
	public function updateGateway($name,$what,$new_value) {
		$data = array(
		   $what => $new_value
		);

		$this->db->where('name', $name);
		try {
			$this->db->update('gateways', $data);
			log_message('debug', 'Updating gateway with name "'.$name.'", setting "'.$what.'" to "'.$new_value.'" in database');
			return true;
		}  catch (Exception $e) {
			atch (Exception $e) {
			log_message('debug', 'Updating gateway with name "'.$name.'", setting "'.$what.'" to "'.$new_value.'" in database NOT successful: "'.$e->getMessage().'"');
			throw new Exception($e->getMessage());
		}
	}
	
	public function addGateway($data) {
		$this->db->insert('gateways', $data); 
		log_message('debug', 'Adding gateway with name "'.$data['clear_name'].'" to database');
		return $this->db->insert_id();
	}
	
	public function deleteGateway($gateway) {
		log_message('debug', 'Attempting to remove gateway with name "'.$gateway->clear_name.'" from database...');
		
		// Find devices with this gateway as gateway
		log_message('debug', 'Searching for devices with gateway with ID "'.$gateway->id.'" as gateway');
		
		$this->load->model('devices/device');
		$devices = $this->device->getDevicesByGateway($gateway->id);
		
		if (sizeof($devices) != 0) {
			foreach ($devices as $device) {
				$this->device->updateDevice($device->name,"gateway","0");
			}
		}
		
		// Delete Gateway
		log_message('debug', 'Removing gateway with name "'.$gateway->clear_name.'" from database');
		$this->db->delete('gateways', array('name' => $gateway->name)); 
	}
}
?>
