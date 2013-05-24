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
	
	public function addGateway($data) {
		$this->db->insert('gateways', $data); 
		return $this->db->insert_id();
	}
}
?>
