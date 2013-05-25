<?php
Class gateway extends CI_Model {
	
	/*
	 * 
	 * Gateways
	 * 
	 */
	
	public function getGateways() {
		$this->load->database();
		$query = $this->db->get('gateways');
		
		$gateways = array();
		foreach ($query->result() as $row)
		{
			$gateways[] = $row;
		}
		return $gateways;
	}
	
	public function getGatewaysByRoom($room) {
		$this->load->database();
		$query = $this->db->get_where('gateways', array('room' => $room));
		
		$gateways = array();
		foreach ($query->result() as $row)
		{
			$gateways[] = $row;
		}
		return $gateways;
	}
	
	public function getGatewaysByGroup($group) {
		$this->load->database();
		$query = $this->db->get_where('gateways', array('group' => $group));
		
		$gateways = array();
		foreach ($query->result() as $row)
		{
			$gateways[] = $row;
		}
		return $gateways;
	}
	
	public function getGatewaysByName($name) {
		$this->load->database();
		$this->db->select('*');
		$this->db->from('gateways');
		$this->db->like('name',$name);
		$query = $this->db->get();
		
		$gateways = array();
		foreach ($query->result() as $row)
		{
			$gateways[] = $row;
		}
		return $gateways;
	}
	
	public function getGatewayByName($name) {
		$query = $this->db->get_where('gateways', array('name' => $name));

		foreach ($query->result() as $row)
		{
			$gateway = $row;
		}
		return $gateway;
	}
	
	public function getGatewaysByID($ids) {
		$this->load->database();
		$this->db->select('*');
		$this->db->from('gateways');
		$this->db->where_in('id', $ids);
		$query = $this->db->get();
		
		$gateways = array();
		foreach ($query->result() as $row)
		{
			$gateways[] = $row;
		}
		return $gateways;
	}
	
	public function getGatewayTypeByID($id) {
		$this->load->database();
		$query = $this->db->get_where('gateway_types', array('id' => $id));
		
		foreach ($query->result() as $row)
		{
			$gateway_type = $row;
		}
		return $gateway_type;
	}
	
	public function getGatewayByID($id) {
		$this->load->database();
		$query = $this->db->get_where('gateways', array('id' => $id));
		
		foreach ($query->result() as $row)
		{
			$gateway = $row;
		}
		return $gateway;
	}
	
	public function getGatewayTypes() {
		$query = $this->db->get('gateway_types');
		
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
		$this->db->update('gateways', $data); 
	}
	
	public function addGateway($data) {
		$this->db->insert('gateways', $data); 
		return $this->db->insert_id();
	}
	
	public function deleteGateway($gateway) {
		// Find devices with this gateway as gateway
		$this->load->model('devices/device');
		$devices = $this->device->getDevicesByGateway($gateway->id);
		
		if (sizeof($devices) != 0) {
			foreach ($devices as $device) {
				$data = array(
					'gateway' => 0
				);
				
				// Set new gateway to "0"
				$this->db->where('id',$device->id);
				$this->db->update('devices',$data);
			}
		}
		
		// Delete Gateway
		$this->db->delete('gateways', array('name' => $gateway->name)); 
	}
}
?>
